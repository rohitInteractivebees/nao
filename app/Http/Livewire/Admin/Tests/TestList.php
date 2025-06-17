<?php

namespace App\Http\Livewire\Admin\Tests;

use App\Models\Quiz;
use App\Models\Test;
use App\Models\User;
use App\Models\Instute;
use Livewire\Component;
use App\Models\Classess;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class TestList extends Component
{
    use WithPagination;
    public Collection $quizzes;

    public $quiz_id = 0;
    public $class_id = 0;
    public $college;
    public $search = '';

    protected $updatesQueryString = ['quiz_id1','class_id'];

    public function mount()
    {
        $this->quizzes = Quiz::published()->get();
        $this->college = Instute::get();
        $this->search = request()->query('search', $this->search);
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingQuizId()
    {
        $this->resetPage();
    }
    public function updatingClassId()
    {
        $this->resetPage();
    }

    public function render()
    {

        $user_ids = [];

        if ($this->class_id > 0) {
            $query = User::query()
                ->whereRaw('JSON_CONTAINS(class, \'\"' . $this->class_id . '\"\')');

            if ($this->quiz_id === 'Other' || (is_numeric($this->quiz_id) && $this->quiz_id > 0)) {
                $query->where('institute', $this->quiz_id);
            }

            $user_ids = $query->pluck('id')->toArray();
        } elseif ($this->quiz_id === 'Other' || (is_numeric($this->quiz_id) && $this->quiz_id > 0)) {
            // No class filter, only institute-based filter
            $user_ids = User::where('institute', $this->quiz_id)->pluck('id')->toArray();
        }


        $tests = Test::query()
            ->with(['user', 'quiz'])
            ->withCount('questions')
            ->when($this->quiz_id > 0, function ($query) use ($user_ids) {
                $query->whereIn('user_id', $user_ids);
            })
            ->when($this->class_id > 0, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->whereRaw('JSON_CONTAINS(class, \'\"' . $this->class_id . '\"\')');
                });
            })
            ->when(!empty($this->search), function ($query) {
                $searchTerm = '%' . $this->search . '%';

                $query->whereHas('user', function ($q) use ($searchTerm) {
                    $q->where(function ($q2) use ($searchTerm) {
                        $q2->where('name', 'like', $searchTerm)
                        ->orWhere('loginId', 'like', $searchTerm)
                        ->orWhere('email', 'like', $searchTerm)
                        ->orWhere('phone', 'like', $searchTerm);
                    });
                });
            })
            ->latest()
            ->paginate();


            return view('livewire.admin.tests.test-list', [
            'tests' => $tests
        ]);
    }

    public function export()
    {
        $is_login = auth()->user();
        $quizId = request('quiz_id');
        $classId = request('class_id');
        if (auth()->user()->is_admin) {

            $user_ids = [];
            if ($classId > 0) {
                $query = User::query()
                    ->whereRaw('JSON_CONTAINS(class, \'\"' . $classId . '\"\')');

                if ($quizId === 'Other' || (is_numeric($quizId) && $quizId > 0)) {
                    $query->where('institute', $quizId);
                }

                $user_ids = $query->pluck('id')->toArray();
            } elseif ($quizId === 'Other' || (is_numeric($quizId) && $quizId > 0)) {
                // No class filter, only institute-based filter
                $user_ids = User::where('institute', $quizId)->pluck('id')->toArray();
            }


            $tests = Test::query()
                ->with(['user', 'quiz'])
                ->withCount('questions')
                ->when(!empty($user_ids), function ($query) use ($user_ids) {
                    $query->whereIn('user_id', $user_ids);
                })
                ->when($quizId > 0, function ($query) use ($quizId) {
                    $query->whereHas('user', function ($q) use ($quizId) {
                        $q->where('institute', $quizId);
                    });
                })
                ->when($classId > 0, function ($query) use ($classId) {
                    $query->whereHas('user', function ($q) use ($classId) {
                        $q->whereRaw('JSON_CONTAINS(class, ?)', ['"' . $classId . '"']);
                    });
                })
                ->get();


            $csvData = [];
            $csvData[] = ['Sr.No', 'School Name', 'Student Name', 'Login ID', 'Class', 'Parent Email', 'Parent Phone', 'Marks', 'Time Spent'];

            foreach ($tests as $index => $test) {
                $instituteName = $test->user->institute !== 'Other'
                    ? Instute::where('id', $test->user->institute)->value('name')
                    : 'Other (' . $test->user->school_name . ')';

                $classNames = Classess::whereIn('id', json_decode($test->user->class ?? '[]'))->pluck('name')->join(', ');
                $email = !empty($test->user->email) ? $test->user->email : 'N/A';
                $minutes = intval($test->time_spent / 60) >= $test->quiz->duration
                    ? $test->quiz->duration
                    : intval($test->time_spent / 60);

                $seconds = intval($test->time_spent / 60) >= $test->quiz->duration
                    ? '00'
                    : gmdate('s', $test->time_spent);

                $time_spend = $minutes . ':' . $seconds;

                $csvData[] = [
                    $index + 1,
                    $instituteName,
                    $test->user->name,
                    $test->user->loginId,
                    $classNames,
                    $email,
                    ($test->user->country_code || $test->user->phone) ? '+' . trim($test->user->country_code . ' ' . $test->user->phone) : 'N/A',
                    $test->result,
                    $time_spend,
                ];
            }

            // Convert array to CSV
            $filename = 'quizattempttracker_export_' . now()->format('Y_m_d_H_i_s') . '.csv';
            $handle = fopen('php://temp', 'r+');

            foreach ($csvData as $row) {
                fputcsv($handle, $row);
            }

            rewind($handle);
            $csvOutput = stream_get_contents($handle);
            fclose($handle);

            return Response::make($csvOutput, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ]);
        } else {
            Auth::logout();
            return redirect()->route('login');
        }
    }
}
