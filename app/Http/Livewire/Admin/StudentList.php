<?php
namespace App\Http\Livewire\Admin;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Quiz;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;
use App\Mail\VarifyEmail;
use Illuminate\Support\Facades\Hash;

class StudentList extends Component
{
    
    public  $quiz_id = 3;

   
   
    public function render(): View
    {
       
        $is_login = auth()->user();
         // dd($is_login);
        if ($is_login && $is_login->is_college == 1) {
            $id = $is_login->institute;
            
            //dd($this->quiz_id);
            //$student = User::where('institute', $id)->where('id', '!=', $is_login->id)->paginate(10);

            if ($this->quiz_id == 1) {
                $student = User::where('institute', $id)
    ->where('id', '!=', $is_login->id)
    ->where(function ($query) {
        $query->where('is_verified', 0)
              ->orWhereNull('is_verified');
    })
    ->paginate(10);
          
          
        //  dd($student);
                
            }
            else if($this->quiz_id == 2)
            {
                $student = User::where('institute', $id)->where('id', '!=', $is_login->id)->where('is_verified', 1)->paginate(10);
            }
            else{
                $student = User::where('institute', $id)->where('id', '!=', $is_login->id)->paginate(10);
            }
             
      // dd("ok");
            return view('livewire.admin.student-list', [
                'student' => $student,
            ]);
        } else {
            Auth::logout();
        }
    }

    public function uploadCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();

        $csvData = array_map('str_getcsv', file($path));

        $is_login = auth()->user();
        $id = $is_login->institute;

        foreach ($csvData as $key => $row) {
            if ($key === 0) continue;
            $findUser = User::where('email',$row[5])->first();
            if($findUser){
                // dd($findUser);
            }else{
                $user = new User();
                $user->name = $row[1];
                $user->institute = $id;
                $user->streams = $row[3];
                $user->session_year = $row[4];
                $user->email = $row[5];
                $user->phone = $row[6];
                $user->password = Hash::make($row[7]);
                $user->is_verified = 1;
                $user->save();
                // dd($user);
              // Mail::to($row[5])->send(new WelcomeEmail($row[1], $row[5], $row[7]));
            }
        }

        return redirect()->back()->with('success', 'CSV uploaded and emails sent successfully.');
    }


    public function verifyAdmin(Request $request, $id)
{
    $admin = User::find($id);
    if ($admin) {
        $admin->is_verified = $request->verify;
        $admin->remark = $request->remark;
        $admin->save();
      // Mail::to($admin->email)->send(new VarifyEmail($admin->name));
        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false]);
}
}
