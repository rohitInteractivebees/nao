<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestimonialMail;

class HomeController extends Controller
{
    public function index()
    {
        $query = Quiz::whereHas('questions')
             ->withCount('questions')
            ->when(auth()->guest() || !auth()->user()->is_admin, function ($query) {
                return $query->where('published', 1);
            })
            ->get();

        $public_quizzes = $query->where('public', 1);
        $registered_only_quizzes = $query->where('public', 0);

        $liveQuiz = null;
        if(auth()->check() && !auth()->user()->is_admin && is_null(auth()->user()->is_college))
        {
            $classIds = json_decode(auth()->user()->class, true);
            $matchedGroup = '';
        
            if (!empty($classIds)) {
                $classNames = \App\Models\Classess::whereIn('id', $classIds)->pluck('group')->toArray();
                $matchedGroup = implode(', ', $classNames);
            }
            if($matchedGroup)
            {
                $liveQuiz = Quiz::whereHas('questions')
                    ->withCount('questions')
                    ->when(auth()->check() && !auth()->user()->is_admin && is_null(auth()->user()->is_college), function ($query) {
                        $query->where('status', 1);
                    })
                    ->where('class_ids', $matchedGroup)
                    ->limit(1)
                    ->get();
            }
        }

        return view('home', compact('public_quizzes', 'registered_only_quizzes','liveQuiz'));
    }

    public function show(Quiz $quiz)
    {
        $test = Test::where('user_id', auth()->id())->where('quiz_id', $quiz->id)->first();

        if ($test) {
            return redirect()->route('home')->with('message', 'You have already attempted this quiz.');
        }

        if (auth()->check() && !auth()->user()->is_admin && is_null(auth()->user()->is_college)) {
            $classIds = json_decode(auth()->user()->class, true);
            $matchedGroup = '';
        
            if (!empty($classIds)) {
                $classNames = \App\Models\Classess::whereIn('id', $classIds)->pluck('group')->toArray();
                $matchedGroup = implode(', ', $classNames);
            }
            
            if (!$matchedGroup) {
                return redirect()->route('home')->with('message', 'This quiz is not assigned to your class.');
            }

            if ($quiz->status != 1 || !\Carbon\Carbon::now()->between(\Carbon\Carbon::parse($quiz->start_date),\Carbon\Carbon::parse($quiz->end_date)
                )
            ) {
                return redirect()->route('home')->with('message', 'This quiz is not currently available.');
            }

            return view('front.quizzes.show', compact('quiz'));
        }

        return redirect()->route('home');
    }
    public function testimonial_form()
    {
        
        return view('content.testimonial');
    }
    
    public function testimonial_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'school_name' => ['required'],
            'country_code' => ['required'],
            'mobile_number' => ['required', 'digits_between:7,12'],
            'email' => ['required', 'email'],
            'category' => ['required', 'regex:/^[a-zA-Z\s]+$/'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // 2MB
            'message' => ['required', 'string', 'min:50'],
        ], [
            'name.regex' => 'The name may only contain letters and spaces.',
            'category.regex' => 'The category may only contain letters and spaces.',
            'image.max' => 'The image must not be greater than 2MB.',
            'image.mimes' => 'Only JPG, JPEG, and PNG images are allowed.',
            'mobile_number.digits_between' => 'Mobile number must be between 7 to 12 digits.',
            'message.min' => 'The testimonial must be at least 50 characters.',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Handle image upload to public/testimonial
        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('testimonial');
            
            // Create directory if it doesn't exist
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
        
            $file->move($destinationPath, $fileName);
            $imagePath = 'testimonial/' . $fileName;
        }
    
        // Save to database
        $testimonial =Testimonial::create([
            'name' => $request->name,
            'school_name' => $request->school_name,
            'country_code' => $request->country_code,
            'mobile_number' => $request->mobile_number,
            'email' => $request->email,
            'category' => $request->category,
            'image' => $imagePath,
            'message' => $request->message,
        ]);
        try {
            Mail::to('nep@asdc.org.in')->send(new TestimonialMail($testimonial));
        } catch (Exception $e) {
            
        }    
        return redirect()->back()->with('success', 'Testimonial submitted successfully.');
    }
}
