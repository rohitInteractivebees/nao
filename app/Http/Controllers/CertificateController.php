<?php
namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use PDF;

use App\Models\User;
use App\Models\Instute;
use App\Models\Classess;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;


class CertificateController extends Controller
{
    public function download(Test $test)
    {
        $user = auth()->user();
        if($user->institute == 'Other')
        {
            $school_name = $user->school_name;
            $school_code = explode("_",$user->reg_no)[0];
        }else{
            $schoolData = Instute::where('id',$user->institute)->first();
            $school_name = $schoolData->name;
            $school_code = $schoolData->code;
        }
        $class = Classess::where('id',json_decode($user->class,true)[0])->value('name');
        // Define custom page size in points (1 inch = 72 points)
        //return view('certificates.certificates', compact('test', 'user'));
        $customPaper = array(0, 0, 800, 700);
        $pdf = PDF::loadView('certificates.certificates', compact('test', 'user','school_code','school_name','class'))
                ->setPaper($customPaper); // Set custom paper size

        return $pdf->download('certificate.pdf');
    }




    public function downloadUsers()
    {
        $users = User::where('is_admin', '!=', 1)
        ->where(function ($query) {
            $query->where('is_college', '!=', 1)
                ->orWhereNull('is_college');
        })
        ->get(['id','name', 'email', 'phone', 'institute', 'created_at','parent_name','state','city','class','school_name']);

            // dd($users);
        $csvData = [];
        foreach ($users as $user) {
            if($user->institute != 'Other')
            {
                $instituteName = Instute::where('id', $user->institute)->value('name');
            }else {
                $instituteName = $user->institute.'('.$user->school_name.')';
            }
            $TestAtmp = Test::where('user_id', $user->id)->first();

            $class = Classess::whereIn('id', json_decode($user->class))->pluck('name')->join(', ');

            if($TestAtmp)
            {
                $userquizatmp = 'Attempt';
            }
            else{
                $userquizatmp = 'Pending';
            }


            $csvData[] = [
                'created_at'=>  $user->created_at->format('d-m-Y h:i a'),
                'name' => $user->name,
                'parent_name' => $user->parent_name,
                'email' => $user->email,
                'phone' => $user->phone,
                'city' => $user->city,
                'state' => $user->state,
                'class' => $class,
                'school' => $instituteName,
                'status' => $userquizatmp,


            ];
        }

        $response = new StreamedResponse(function() use ($csvData) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Register Date','Student Name','Parent Name', 'Parent Email', 'Parent Mobile', 'City','State','Class', 'School','Status']);

            foreach ($csvData as $row) {
                fputcsv($handle, $row);
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="StudentList.csv"');

        return $response;
    }


}
