<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use App\Models\Teams;
use App\Models\Prototype;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Livewire\Component;
use App\Models\Quiz;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Mail\PublishResultLevel;
use App\Mail\PublishResultLevelInstitute;
use Illuminate\Support\Facades\Mail;
class PrototypeList extends Component
{
    public function delete(Teams $admin)
    {
        //abort_if(!auth()->user()->is_admin, Response::HTTP_FORBIDDEN, 403);

       $admin->delete();
    }

    public function render()
{
    
    $is_login = auth()->user();
    
    
    if ($is_login) {
         

       $id = $is_login->id;
        
       $userId = (string) Auth::user()->id;
        $teamMember = Teams::whereJsonContains('teamMembers', $userId)->first();
        
       // dd($teamMember);
       if($teamMember)
       {
        $prototype = Prototype::where('student_id',$teamMember->teamlead_id)->get();
       }
       else{
        $prototype = Prototype::where('student_id',$id)->get();
       }


        

    

        
        return view('livewire.admin.prototype-list-student', [
            'prototypes' => $prototype
        ]);
    }else{
        Auth::logout();
    } 
}


public function publishLevel2Result(Request $request)
    {
        // Update all admin users to set level2result to 1 (published)
        User::where('is_admin', 1)->update(['level2result' => 1]);
        
        $all_team_id=Teams::all()->pluck('teamlead_id');
        $all_team_email= User::select('email','name')->whereIn('id', $all_team_id)->get();
        foreach ($all_team_email as $email) {
            //Mail::to($email->email)->send(new PublishResultLevel($email->name));
        }
        // all institute Mail
        $is_college_email = User::where('is_college', 1)->pluck('email');
        foreach ($is_college_email as $email) {
            //Mail::to($email)->send(new PublishResultLevelInstitute);
        }
        

        // Redirect or return response
        return redirect()->back()->with('status', 'Level 2 result published successfully!');
    }

    // Method to unpublish level 2 result
    public function unpublishLevel2Result(Request $request)
    {
        // Update all admin users to set level2result to 0 (unpublished)
        User::where('is_admin', 1)->update(['level2result' => 0]);

        // Redirect or return response
        return redirect()->back()->with('status', 'Level 2 result unpublished successfully!');
    }

}
