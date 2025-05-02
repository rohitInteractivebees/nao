<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use App\Models\Teams;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Livewire\Component;
use App\Models\Quiz;
use Illuminate\Support\Facades\Auth;


class TeamRegistration extends Component
{
    public int $quiz_id = 0;
    public function delete(Teams $admin)
    {
        //abort_if(!auth()->user()->is_admin, Response::HTTP_FORBIDDEN, 403);

        $admin->delete();
    }

    public function render()
    {

        $is_login = auth()->user();


        if ($is_login) {
            if ($is_login->is_admin == 1) {



                if ($this->quiz_id > 0) {
                $student = Teams::where('college_id',$this->quiz_id)->paginate(10);
                }
                else{
                    $student = Teams::paginate(10);
                }
                return view('livewire.admin.teams-management-list', [
                    'student' => $student
                ]);
            } else {
                $id = $is_login->institute;



                $student = Teams::where('college_id', $id)->paginate(10);

            }

           // $result = Quiz::where('result_show', 1)->first();

           // if ($result) {

                return view('livewire.admin.teams-management-list', [
                    'student' => $student
                ]);
            //} else {
            //    Auth::logout();
           // }




        } else {
            Auth::logout();
        }
    }

}
