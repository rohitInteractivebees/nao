<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Team;
use App\Models\College;
use App\Models\Student;

class TeamRegistration extends Component
{
    public $teamName;
    public $teamLead;
    public $mentorName;
    public $mentorDetails;
    public $mentorType = 'Internal';
    public $teamMembers = [];
    public $collegeId;

    protected $rules = [
        'teamName' => 'required|string',
        'teamLead' => 'required|exists:students,id',
        'mentorName' => 'required|string',
        'mentorDetails' => 'nullable|string',
        'mentorType' => 'required|in:External,Internal',
        'teamMembers' => 'array|max:4',
        'teamMembers.*' => 'exists:students,id',
        'collegeId' => 'required|exists:colleges,id'
    ];

    public function addTeamMember($studentId)
    {
        if (count($this->teamMembers) < 4 && !in_array($studentId, $this->teamMembers)) {
            $this->teamMembers[] = $studentId;
        }
    }

    public function removeTeamMember($studentId)
    {
        $this->teamMembers = array_filter($this->teamMembers, function ($id) use ($studentId) {
            return $id != $studentId;
        });
    }

    public function registerTeam()
    {
        $this->validate();

        Team::create([
            'college_id' => $this->collegeId,
            'teamname' => $this->teamName,
            'teamlead_id' => $this->teamLead,
            'mentorname' => $this->mentorName,
            'mentordetails' => $this->mentorDetails,
            'mentortype' => $this->mentorType,
        ]);

        session()->flash('message', 'Team has been successfully registered.');

        $this->reset();
    }

    public function render()
    {
        $colleges = College::all();
        $students = Student::all();

        return view('livewire.team-registration', compact('colleges', 'students'));
    }
}
