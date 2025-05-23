<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use App\Models\ProjectSubmissionsPhase2;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Livewire\Component;
use App\Models\Quiz;
use Illuminate\Support\Facades\Auth;
class PhaseSubmission extends Component
{
    public function delete(ProjectSubmissionsPhase2 $admin)
    {
        //abort_if(!auth()->user()->is_admin, Response::HTTP_FORBIDDEN, 403);

       $admin->delete();
    }

    public function render()
{
    
    $is_login = auth()->user();
    
    
    if ($is_login && $is_login->is_college == 1) {
       
        $id = $is_login->institute;
        
        $submissions = ProjectSubmissionsPhase2::paginate(10);
        
       
        return view('livewire.admin.teams-management-list', [
            'submissions' => $submissions
        ]);
    }else{
        Auth::logout();
    } 
}

}
