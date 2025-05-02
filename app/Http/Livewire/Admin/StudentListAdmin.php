<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use App\Models\Instute;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class StudentListAdmin extends Component
{
    use WithPagination;

    public int $quiz_id1 = 0;

    protected $updatesQueryString = ['quiz_id1'];

    public function updatedQuizId1()
    {
        // Reset pagination when the filter changes
        $this->resetPage();
    }

    public function delete(User $admin)
    {
        abort_if(!auth()->user()->is_admin, Response::HTTP_FORBIDDEN, '403 Forbidden');

        $admin->delete();
    }

    public function render()
    {
        $is_login = auth()->user();

        if (auth()->user()->is_admin) {
            $query = User::where('id', '!=', $is_login->id)
                         ->where(function ($query) {
                             $query->where('is_college', 0)
                                   ->orWhereNull('is_college');
                         });

            if ($this->quiz_id1 > 0) {
                $query->where('institute', $this->quiz_id1);
            }

            $students = $query->paginate(10);

            return view('livewire.admin.student-list-admin', [
                'students' => $students,
            ]);
        } else {
            Auth::logout();
            return redirect()->route('login');
        }
    }
}
