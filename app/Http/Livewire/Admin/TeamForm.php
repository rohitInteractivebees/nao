<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Teams;
use App\Models\User;
use App\Models\Instute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Quiz;

class TeamForm extends Component
{
    public $name; // Team name
    public $mentorName; // Mentor name
    public $mentorDetails; // Mentor details
    public $mentorType = 'Internal'; // Mentor type
    public $teammember = []; // Array to hold team member IDs

    protected $rules = [
        'name' => 'required|string',
        'mentorName' => 'required|string',
        'mentorDetails' => 'nullable|string',
        'mentorType' => 'in:External,Internal',
        'teammember' => 'required|array|max:3',
    ];

    public function save()
    {
        $this->validate();

        $is_login = auth()->user();
        $college = $is_login->institute;
        $id = $is_login->id;

        Teams::create([
            'name' => 'BYD ' . $this->name,
            'college_id' => $college,
            'teamlead_id' => $id,
            'mentorname' => $this->mentorName,
            'mentordetails' => $this->mentorDetails,
            'mentortype' => $this->mentorType,
            'teamMembers' => json_encode($this->teammember), // Store as JSON
        ]);

        session()->flash('message', 'Team has been successfully registered.');

        return redirect()->route('register-team');
    }

    // public function render()
    // {
    //     $is_login = auth()->user();
    //     $id = $is_login->institute;

    //     $teamlist = Teams::where('college_id', $id)->get();
    //     $temexid = [];
        
    //     foreach($teamlist as $teamexit) {
    //         $temexid = array_merge($temexid, json_decode($teamexit->teamMembers, true));
    //     }
        
       
        
    //     $students = User::where('institute', $id)->where('id', '!=', $is_login->id)->whereIn('id', '!=', $temexid)->get();

        
    //     return view('livewire.admin.team-management-form', compact('students'));
    // }



    public function render()
    {
        $is_login = auth()->user();
        $id = $is_login->institute;
    
        // Get the list of teams for the current institute
        $teamlist = Teams::where('college_id', $id)->get();
        $temexid = [];
        
        // Extract team members and team leads from each team
        foreach($teamlist as $team) {
            $teamMembers = json_decode($team->teamMembers, true);
            if (is_array($teamMembers)) {
                $temexid = array_merge($temexid, $teamMembers);
            }
            $temexid[] = $team->teamlead_id; // Add team lead to the exclusion list
        }
    
        // Remove duplicate IDs
        $temexid = array_unique($temexid);
        
        // Get the list of students who are not in the current user's team, not team members, and not team leads
        $students = User::where('institute', $id)
                ->where('is_selected', 1)
                ->where('id', '!=', $is_login->id)
                ->whereNotIn('id', $temexid)
                ->where(function($query) {
                    $query->where('is_college', 0)
                          ->orWhereNull('is_college');
                })
                ->get();

           
       $result = Quiz::where('result_show',1)->first();
       
                        if(auth()->user()->is_selected == 1 && $result)
                        {
                            return view('livewire.admin.team-management-form', compact('students'));
                        }
                        else{
                            Auth::logout();
                        }
        // Return the view with the list of students
        
    }
    

    public function getUserDetails(Request $request)
    {
        $is_login = auth()->user();
        $id = $is_login->institute;

        $email = $request->email;
        $user = User::where('email', $email)->where('institute', $id)->first();

        if ($user) {
            return response()->json([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'college' => $user->institute,
            ]);
        }

        return response()->json(null, 404);
    }
}
