<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\User;
class UpdateQuizStatus extends Controller
{
public function updateQuizStatus(Request $request)
{
    $status = $request->input('status');

    // Assuming you have a Quiz model
    $quiz = Quiz::first(); // Modify this to select the correct quiz if needed
    $quiz->published = $status;
    $quiz->save();

    return response()->json(['success' => true]);
}

public function updateLevel2Status(Request $request)
{
    $status = $request->input('status');
    $enddate = $request->input('endDate');
    // Assuming you have a Level2 model
    $level2 = User::find(1); // Modify this to select the correct level if needed
    $level2->level2show = $status;
    $level2->level2enddate = $enddate;
    $level2->save();

    return response()->json(['success' => true]);
}

public function updateLevel3Status(Request $request)
{
    $status = $request->input('status');
    $enddate = $request->input('endDate');

    // Assuming you have a Level3 model
    $level3 = User::find(1); // Modify this to select the correct level if needed
    $level3->level3show = $status;
    $level3->level3enddate = $enddate;
    $level3->save();

    return response()->json(['success' => true]);
}
}