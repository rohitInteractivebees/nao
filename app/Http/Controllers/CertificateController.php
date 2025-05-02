<?php
namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use PDF;

use App\Models\User;
use App\Models\Instute;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;


class CertificateController extends Controller
{
    public function download(Test $test)
{
    $user = auth()->user();
  
    
    
    // Define custom page size in points (1 inch = 72 points)
    $customPaper = array(0, 0, 800, 690);

    $pdf = PDF::loadView('certificates.certificates', compact('test', 'user'))
              ->setPaper($customPaper); // Set custom paper size

    return $pdf->download('certificate.pdf');
}




public function downloadUsers()
{
    $users = User::where(function ($query) {
        $query->where('is_admin', '!=', 1)
              ->orWhereNull('is_admin');
    })
    ->where(function ($query) {
        $query->where('is_college', '!=', 1)
              ->orWhereNull('is_college');
    })
    ->get(['id','name', 'email', 'phone', 'institute', 'is_verified','created_at']);

        // dd($users);
    $csvData = [];
    foreach ($users as $user) {
        $instituteName = Instute::where('id', $user->institute)->value('name');

        $TestAtmp = Test::where('user_id', $user->id)->first();
        

        if($TestAtmp)
        {
            $userquizatmp = 'Quiz attempt ';
        }
        else{
            $userquizatmp = 'Quiz Not attempt ';
        }
           

        if($user->is_verified == 1)
        {
            $userstatus = 'Verified';
        }
        else{
            $userstatus = 'Not Verified';
        }
        $csvData[] = [
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'institute_name' => $instituteName,
            'Status' => $userstatus,
            'Quiz status' => $userquizatmp,
            'created_at'=>  $user->created_at->format('d-m-Y h:i a')
        ];
    }

    $response = new StreamedResponse(function() use ($csvData) {
        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['Name', 'Email', 'Phone', 'Institute Name','Status','Quiz status', 'Registration Date']);

        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);
    });

    $response->headers->set('Content-Type', 'text/csv');
    $response->headers->set('Content-Disposition', 'attachment; filename="allStudent.csv"');

    return $response;
}

    
}
