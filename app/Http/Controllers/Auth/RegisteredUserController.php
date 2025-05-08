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
use App\Models\Instute;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create($code = null): View
    {
        $institude_data = null;

        if (!empty($code)) {
            $institude_data = Instute::where('code', $code)->where('status',1)->first();
        }

        return view('auth.register', compact('institude_data'));
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


        $schoolData = Instute::find($request->school);
        $schoolCode = $schoolData->code;

        $lastUser = User::where('reg_no', 'LIKE', $schoolCode . '_%')
        ->orderByRaw("CAST(SUBSTRING_INDEX(reg_no, '_', -1) AS UNSIGNED) DESC")
        ->first();

        $lastNumber = 0;
        if ($lastUser && preg_match('/_(\d+)$/', $lastUser->reg_no, $matches)) {
        $lastNumber = (int) $matches[1];
        }

        $newRegNo = $schoolCode . '_' . ($lastNumber + 1);

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
            'reg_no' => $newRegNo,
        ]);

        $loginId = $schoolCode . $user->id;

        $user->loginId = $loginId;
        $user->save();

        event(new Registered($user));

        // Auth::login($user);

        // return redirect(RouteServiceProvider::HOME);
        session()->flash('password', $request->password);
        return redirect('/thankyou/'.$user->id);
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
            'school' => ['required', 'string', 'unique:instutes,name'],
            'state' => ['required', 'string'],
            'city' => ['required', 'string'],
            'country' => ['required', 'string'],
        ], [
            'principal_name.regex' => 'The name may only contain letters.',
            'spoc_name.regex' => 'The name may only contain letters.',
        ]);

        $inputClassname = Classess::pluck('id')->toArray();

        $encodedClassname = json_encode(array_map('strval', (array) $inputClassname));

        $schoolName = trim($request->school);
        // Create the institute
        $institute = Instute::create([
            'name' => $schoolName,
            'status' => 1,
        ]);

        // Generate code: first letter of each word + ID
        $initials = collect(explode(' ', $schoolName))
            ->filter()
            ->map(fn($word) => strtoupper(substr($word, 0, 1)))
            ->implode('');

        $code = $initials . $institute->id;

        // Update the record with the generated code
        $institute->code = $code;
        $institute->save();

        $institute_id = $institute->id;

        $newRegNo = $code;
        $loginId = $code.rand(1000,9999);

        $user = User::create([
            'name' => $request->principal_name,
            'parent_name' => $request->spoc_name,
            'email' => $request->spoc_email,
            'institute' => $institute_id,
            'class' => $encodedClassname,
            'state' =>$request->state,
            'city' =>$request->city,
            'phone' => $request->mobile,
            'spoc_mobile' => $request->spoc_mobile,
            'country' => $request->country,
            'password' => Hash::make($request->password),
            'is_college' => 1,
            'reg_no' => $newRegNo,
            'loginId' => $loginId,
            'is_verified' => 1,
        ]);
        //Mail::to($request->spoc_email)->send(new InstituteLoginMail($request->spoc_name,$request->spoc_email,$request->password));
        session()->flash('password', $request->password);
        return redirect('/thankyou/'.$user->id);
    }

}
