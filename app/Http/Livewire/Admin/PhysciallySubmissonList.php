<?php

namespace App\Http\Livewire\Admin;

use App\Models\Physicaly;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Teams;
use Illuminate\Support\Facades\Auth;
class PhysciallySubmissonList extends Component
{
    public int $quiz_id1 = 0;
    public function delete(Instute $admin)
    {
        abort_if(!auth()->user()->is_admin, Response::HTTP_FORBIDDEN, 403);

        $admin->delete();
    }

    public function render()
    {
             
        if(auth()->user()->is_admin)
        {

            if ($this->quiz_id1 > 0) {
                //dd($this->quiz_id1);
            $physicaly = Physicaly::where('college_id', $this->quiz_id1)->paginate(10);
            }
            else{
                $physicaly = Physicaly::paginate(10);
            }
            return view('livewire.admin.physcially-submisson-list', [
                'physicaly' => $physicaly
            ]);
        }
        else if(auth()->user()->is_college == 1)
        {
            $physicaly = Physicaly::where('college_id',auth()->user()->institute)->paginate(10);
       
            return view('livewire.admin.physcially-submisson-list', [
                'physicaly' => $physicaly
            ]);
        }
        else{
            Auth::logout();
        }
        

        
    }


    public function finalapproveTeam(Request $request, $id)
{
    $team = Teams::find($id);
    $collegeId = $request->input('college_id');

    
    $approvedTeamsCount = Teams::where('college_id', $collegeId)->where('approved_level3', 1)->count();
    
    
    if ($approvedTeamsCount < 1) {
        if ($team) {
            $team->approved_level3 = 1;
            $team->save();
            return response()->json(['success' => true]);
        }
    } else {
        return response()->json(['success' => false]);
    }

    return response()->json(['success' => false]);
}





public function finalnotapproveTeam(Request $request, $id)
{
    $team = Teams::find($id);
    $collegeId = $request->input('college_id');

    
    $approvedTeamsCount = Teams::where('college_id', $collegeId)->where('approved_level3', 0)->count();
    
    
    if ($approvedTeamsCount < 1) {
        if ($team) {
            $team->approved_level3 = 2;
            $team->save();
            return response()->json(['success' => true]);
        }
    } else {
        return response()->json(['success' => false]);
    }

    return response()->json(['success' => false]);
}

public function finalnotapproveTeam1(Request $request, $id)
{
    $team = Teams::find($id);
    $collegeId = $request->input('college_id');

    
    $approvedTeamsCount = Teams::where('college_id', $collegeId)->where('approved_level3', 0)->count();
    
    
    if ($approvedTeamsCount < 1) {
        if ($team) {
            $team->approved_level3 = 3;
            $team->save();
            return response()->json(['success' => true]);
        }
    } else {
        return response()->json(['success' => false]);
    }

    return response()->json(['success' => false]);
}

}
