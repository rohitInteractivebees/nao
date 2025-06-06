<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use App\Models\Instute;
use Livewire\Component;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class InstuteListAll extends Component
{
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

        // Manual pagination for collection
        $perPage = 10;
        $currentPage = Paginator::resolveCurrentPage() ?: 1;

        // Slice the collection to get items for the current page
        $currentPageItems = $combined->slice(($currentPage - 1) * $perPage, $perPage)->values();

        // Create paginator instance
        $paginatedItems = new LengthAwarePaginator(
            $currentPageItems,
            $combined->count(), // total items
            $perPage,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath()] // preserve query params if any
        );

        return view('livewire.admin.instute-list-all', [
            'instute' => $paginatedItems
        ]);
    }
}
