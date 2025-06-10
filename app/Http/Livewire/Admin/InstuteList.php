<?php

namespace App\Http\Livewire\Admin;

use App\Models\Instute;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Livewire\Component;
use Livewire\WithPagination;

class InstuteList extends Component
{
    use WithPagination;

    public $search = '';

    public function mount()
    {
        $this->search = request()->query('search', $this->search);
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function delete($instute)
    {
        $instute = Instute::find($instute)->delete();
       // abort_if(!auth()->user()->is_admin, Response::HTTP_FORBIDDEN, 403);
        return redirect()->back();
       // $admin->delete();
    }



    public function render(): View
    {
        $query = Instute::query();
        if (!empty($this->search)) {
            $searchTerm = '%' . $this->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('code', 'like', $searchTerm)
                ->orWhere('name', 'like', $searchTerm);
            });
        }
        $instute = $query->paginate(10);

        return view('livewire.admin.instute-list', [
            'instute' => $instute
        ]);
    }
}
