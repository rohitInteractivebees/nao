<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\College;
use App\Models\Classess;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;
use App\Mail\InstituteLoginMail;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {


        return view('auth.register');
    }
    public function school_create(): View
    {


        return view('auth.school_register');
    }

    public function getColleges(Request $request)
    {
        $instituteId = $request->input('institute_id');
        $colleges = College::where('instute', $instituteId)->get();
        return response()->json($colleges);
    }


    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // public function store(Request $request): RedirectResponse
    // {


    //     $request->validate([
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
    //         'password' => ['required', 'confirmed', Rules\Password::defaults()],

    //     ]);

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'institute' => $request->institute,
    //         'college' => $request->college,
    //         'session_year' => $request->college,
    //         'streams' => $request->college,
    //         'phone'=> $request->phone,
    //         'password' => Hash::make($request->password),
    //     ]);

    //     event(new Registered($user));

    //     Auth::login($user);

    //     return redirect(RouteServiceProvider::HOME);
    // }


    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'student_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'parent_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'parent_email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'session_year' => ['required', 'string'],
            'phone' => ['required', 'string', 'min:10', 'max:10','unique:'.User::class],
            'idcard' => 'required|mimes:jpg,png,pdf|max:1024',  // 1024 KB = 1 MB
            'school' => ['required', 'integer', 'exists:instutes,id'],
            'class' => ['required', 'integer', 'exists:classess,id'],
            'state' => ['required', 'string'],
            'city' => ['required', 'string'],
        ], [
            'student_name.regex' => 'The name may only contain letters.',
            'parent_name.regex' => 'The name may only contain letters.',
        ]);


        //dd($request);

        $idcardFile = $request->file('idcard');

        $idcardPath = time() . '_' . $idcardFile->getClientOriginalName();
        $idcardFile->move(public_path('idcards'), $idcardPath);

        $inputClassname = $request->class;

        // Ensure it's an array before encoding
        if (is_array($inputClassname)) {
            $encodedClassname = json_encode($inputClassname);
        } else {
            $encodedClassname = json_encode([(string) $inputClassname]);
        }

        $user = User::create([
            'name' => $request->student_name,
            'parent_name' => $request->parent_name,
            'email' => $request->parent_email,
            'institute' => $request->school,
            'class' => $encodedClassname,
            'state' =>$request->state,
            'city' =>$request->city,
            'session_year' => $request->session_year,
            'phone' => $request->phone,
            'idcard' => 'idcards/'.$idcardPath,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        // Auth::login($user);

        // return redirect(RouteServiceProvider::HOME);
        return redirect('/thankyou');
    }
    public function school_store(Request $request): RedirectResponse
    {
        $request->validate([
            'principal_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'spoc_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'spoc_email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'mobile' => ['required', 'string', 'min:10', 'max:10','unique:users,phone'],
            'spoc_mobile' => ['required', 'string', 'min:10', 'max:10', 'unique:users,spoc_mobile'],
            'school' => ['required', 'integer', 'exists:instutes,id'],
            'state' => ['required', 'string'],
            'city' => ['required', 'string'],
            'country' => ['required', 'string'],
        ], [
            'principal_name.regex' => 'The name may only contain letters.',
            'spoc_name.regex' => 'The name may only contain letters.',
        ]);

        $inputClassname = Classess::pluck('id')->toArray();

        $encodedClassname = json_encode(array_map('strval', (array) $inputClassname));

        $user = User::create([
            'name' => $request->principal_name,
            'parent_name' => $request->spoc_name,
            'email' => $request->spoc_email,
            'institute' => $request->school,
            'class' => $encodedClassname,
            'state' =>$request->state,
            'city' =>$request->city,
            'phone' => $request->mobile,
            'spoc_mobile' => $request->spoc_mobile,
            'country' => $request->country,
            'password' => Hash::make($request->password),
            'is_college' => 1,
        ]);
        //Mail::to($request->spoc_email)->send(new InstituteLoginMail($request->spoc_name,$request->spoc_email,$request->password));

        return redirect('/thankyou');
    }

}
