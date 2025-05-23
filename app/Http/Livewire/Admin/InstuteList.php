<?php

namespace App\Http\Livewire\Admin;

use App\Models\Instute;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Livewire\Component;

class InstuteList extends Component
{
    public function delete($instute)
    {
        $instute = Instute::find($instute)->delete();
       // abort_if(!auth()->user()->is_admin, Response::HTTP_FORBIDDEN, 403);
        return redirect()->back();
       // $admin->delete();
    }



    public function render(): View
    {
        $instute = Instute::paginate(10);
       
        return view('livewire.admin.instute-list', [
            'instute' => $instute
        ]);
    }
}
