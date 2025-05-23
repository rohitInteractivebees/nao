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
use App\Models\Instute;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Mail\OtpMail;
use App\Mail\OtpMailSchool;
use App\Mail\SignupMailSchool;
use App\Mail\SignupMail;

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
        $rules = [
            'student_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'parent_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'parent_email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'session_year' => ['required', 'string'],
            'parent_phone' => ['required', 'string', 'min:7', 'max:12','regex:/^\d{7,12}$/', 'unique:users,phone'],
            'school' => ['required'],
            'class' => ['required', 'integer', 'exists:classess,id'],
            'country' => ['required', 'string'],
            'state' => ['required', 'string'],
            'city' => ['required', 'string'],
            'school_name' => ['required_if:school,Other', 'nullable', 'string', 'max:255'],
            'otp' => ['required', 'string', 'min:6', 'max:6', 'in:' . Session::get('otp')],
            'pincode' => ['required', 'min:4', 'max:10','regex:/^\d{4,10}$/'],
        ];
    
        // Conditionally add 'exists' rule for 'school'
        if ($request->school != 'Other') {
            $rules['school'] = array_merge($rules['school'], ['integer', 'exists:instutes,id']);
        }
    
        $messages = [
            'student_name.regex' => 'The student name may only contain letters.',
            'parent_name.regex' => 'The parent name may only contain letters.',
            'school_name.required_if' => 'The other school name is required when "Other School" is selected.',
            'otp.in' => 'The OTP entered is incorrect.',
        ];
    
        $validator = Validator::make($request->all(), $rules, $messages);
        $validator->validate();


        //dd($request);

        // $idcardFile = $request->file('idcard');

        // $idcardPath = time() . '_' . $idcardFile->getClientOriginalName();
        // $idcardFile->move(public_path('idcards'), $idcardPath);

        $inputClassname = $request->class;

        // Ensure it's an array before encoding
        if (is_array($inputClassname)) {
            $encodedClassname = json_encode($inputClassname);
        } else {
            $encodedClassname = json_encode([(string) $inputClassname]);
        }

        if ($request->school != 'Other') {
            $schoolData = Instute::find($request->school);
            $schoolCode = $schoolData->code;
        }else{
            $schoolName = trim($request->school_name);
            $initials = collect(explode(' ', $schoolName))
            ->filter()
            ->map(fn($word) => strtoupper(substr($word, 0, 1)))
            ->implode('');

            $schoolCode = $initials.rand(10,99);
        }   
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
            'country' => $request->country,
            'state' =>$request->state,
            'city' =>$request->city,
            'session_year' => $request->session_year,
            'phone' => $request->parent_phone,
            //'idcard' => 'idcards/'.$idcardPath,
            //'password' => Hash::make($request->password),
            'password' => Hash::make($request->parent_phone),
            'reg_no' => $newRegNo,
            //'loginId' => $loginId,
            'loginId' => $request->parent_email,
            'is_verified' => 1,
            'school_name' => $request->school == 'Other' ? $request->school_name : null,
            'country_code' => $request->parent_country_code,
            'pincode' => $request->pincode,
        ]);

        // $loginId = $schoolCode . $user->id;

        // $user->loginId = $loginId;
        $user->save();

        event(new Registered($user));

        // Auth::login($user);

        // return redirect(RouteServiceProvider::HOME);
        try {
            Mail::to($request->parent_email)->cc('nep@asdc.org.in')->send(new SignupMail($request->student_name,$request->parent_email,$request->parent_phone));
        } catch (Exception $e) {
            
        }    
        session()->flash('password', $request->parent_phone);
        return redirect('/thankyou/'.$user->id);
    }
    public function school_store(Request $request): RedirectResponse
    {
        $request->validate([
            'principal_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'spoc_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'principal_email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'spoc_email' => ['required', 'string', 'email', 'max:255'],
            // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'principal_mobile' => ['required', 'string', 'min:7', 'max:12','regex:/^\d{7,12}$/','unique:users,phone','different:spoc_mobile'],
            'spoc_mobile' => ['required', 'string', 'min:7', 'max:12','regex:/^\d{7,12}$/','different:principal_mobile'],
            'school' => ['required', 'string', 'unique:instutes,name'],
            'state' => ['required', 'string'],
            'city' => ['required', 'string'],
            'country' => ['required', 'string'],
            'otp' => ['required', 'string', 'min:6', 'max:6', 'in:' . Session::get('school_otp')],
            'pincode' => ['required', 'min:4', 'max:10','regex:/^\d{4,10}$/'],
            
        ], [
            'principal_name.regex' => 'The name may only contain letters.',
            'spoc_name.regex' => 'The name may only contain letters.',
            'otp.in' => 'The OTP entered is incorrect.',
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
            'email' => $request->principal_email,
            'spoc_email' => $request->spoc_email,
            'institute' => $institute_id,
            'class' => $encodedClassname,
            'state' =>$request->state,
            'city' =>$request->city,
            'phone' => $request->principal_mobile,
            'spoc_mobile' => $request->spoc_mobile,
            'country' => $request->country,
            //'password' => Hash::make($request->password),
            'password' => Hash::make($request->principal_mobile),
            'is_college' => 1,
            'reg_no' => $newRegNo,
            //'loginId' => $loginId,
            'loginId' => $request->principal_email,
            'is_verified' => 1,
            'country_code' => $request->principal_country_code,
            'spoc_country_code' => $request->spoc_country_code,
            'pincode' => $request->pincode,
        ]);
        try {
            Mail::to($request->principal_email)->cc('nep@asdc.org.in')->send(new SignupMailSchool($schoolName,$request->principal_email,$request->principal_mobile,$code));
        } catch (Exception $e) {
            
        }    
        session()->flash('password', $request->principal_mobile);
        return redirect('/thankyou/'.$user->id);
    }
    
    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'parent_email' => 'required|email|string|max:255|unique:users,email',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Validation failed',
            ], 422);
        }
    
        // Generate OTP
        $otp = rand(100000, 999999);
    
        // Store OTP in session
        Session::put('otp', $otp);
    
        // Send OTP via email
        try {
            Mail::to($request->parent_email)->send(new OtpMail($otp,$request->student_name));
        } catch (Exception $e) {
            
        }
        return response()->json(['message' => 'OTP sent to your email']);
    }
    public function sendOtpSchool(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'principal_email' => 'required|email|string|max:255|unique:users,email',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Validation failed',
            ], 422);
        }
    
        // Generate OTP
        $otp = rand(100000, 999999);
    
        // Store OTP in session
        Session::put('school_otp', $otp);
    
        // Send OTP via email
        try {
            Mail::to($request->principal_email)->send(new OtpMailSchool($otp,$request->school));
        } catch (\Exception $e) {
            dd($e->getMessage());    
        }
        return response()->json(['message' => 'OTP sent to your email']);
    }

}
