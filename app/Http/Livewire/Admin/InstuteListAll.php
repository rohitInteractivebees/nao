<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use App\Models\Instute;
use Livewire\Component;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Livewire\WithPagination;

class InstuteListAll extends Component
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

    public function render(): View
{
    $instuteList = Instute::select('name')->get()->map(function($item){
        return (object)['name' => trim($item->name)];
    });

    $userSchoolNames = User::select('school_name as name')
                        ->whereNotNull('school_name')
                        ->distinct()
                        ->get()
                        ->map(function($item){
                            return (object)['name' => trim($item->name)];
                        });

    $combined = $instuteList->merge($userSchoolNames)
                        ->unique('name')
                        ->values();

    // Apply search if search term is present
    if (!empty($this->search)) {
        $searchTerm = strtolower($this->search);

        $combined = $combined->filter(function ($item) use ($searchTerm) {
            return strpos(strtolower($item->name), $searchTerm) !== false;
        })->values(); // reset keys
    }

    // Manual pagination for collection
    $perPage = 10;
    $currentPage = Paginator::resolveCurrentPage() ?: 1;

    // Slice the collection to get items for the current page
    $currentPageItems = $combined->slice(($currentPage - 1) * $perPage, $perPage)->values();

    // Create paginator instance
    $paginatedItems = new LengthAwarePaginator(
        $currentPageItems,
        $combined->count(), // total items after filtering
        $perPage,
        $currentPage,
        ['path' => Paginator::resolveCurrentPath()] // preserve query params if any
    );

    return view('livewire.admin.instute-list-all', [
        'instute' => $paginatedItems
    ]);
}

}
