<?php

namespace App\Http\Livewire\Admin;

use App\Models\Prototype;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Teams;
use Illuminate\Support\Facades\Auth;
class SubmissonList extends Component
{
    public int $quiz_id = 0;
    public function delete(Instute $admin)
    {
        abort_if(!auth()->user()->is_admin, Response::HTTP_FORBIDDEN, 403);

        $admin->delete();
    }

    public function render()
    {
             //dd(auth()->user());
        if(auth()->user()->is_admin)
        {

            if ($this->quiz_id > 0) {
            $prototypes = Prototype::where('college_id',$this->quiz_id)->paginate(10);
            }
            else{
                $prototypes = Prototype::paginate(10);
            }
            return view('livewire.admin.prototype-list', [
                'prototypes' => $prototypes
            ]);
        }
        else if(auth()->user()->is_college == 1)
        {
            $prototypes = Prototype::where('college_id',auth()->user()->institute)->paginate(10);
       
            return view('livewire.admin.prototype-list', [
                'prototypes' => $prototypes
            ]);
        }
        else{
            Auth::logout();
        }
        

        
    }


    public function approveTeam(Request $request, $id)
{
    $team = Teams::find($id);
    $collegeId = $request->input('college_id');

    
    $approvedTeamsCount = Teams::where('college_id', $collegeId)->where('approved_level2', 1)->count();
    
    
    if ($approvedTeamsCount < 4) {
        if ($team) {
            $team->approved_level2 = 1;
            $team->save();
            return response()->json(['success' => true]);
        }
    } else {
        return response()->json(['success' => false]);
    }

    return response()->json(['success' => false]);
}





public function notapproveTeam(Request $request, $id)
{
    $team = Teams::find($id);
    $collegeId = $request->input('college_id');

    
    $approvedTeamsCount = Teams::where('college_id', $collegeId)->where('approved_level2', 0)->count();
    
    
    if ($approvedTeamsCount < 2) {
        if ($team) {
            $team->approved_level2 = 0;
            $team->save();
            return response()->json(['success' => true]);
        }
    } else {
        return response()->json(['success' => false]);
    }

    return response()->json(['success' => false]);
}
}
