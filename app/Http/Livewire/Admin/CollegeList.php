<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use App\Models\Instute;
use Livewire\Component;
use App\Models\Classess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class CollegeList extends Component
{
    use WithPagination;

    public $search = '';

    public function mount()
    {
        $this->search = request()->query('search', $this->search);
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete(User $admin)
    {
        abort_if(!auth()->user()->is_admin, HttpResponse::HTTP_FORBIDDEN, 403);

        $admin->delete();
    }

    public function render(): View
    {
        $query = User::where('is_college', 1)
            ->leftJoin('instutes', 'users.institute', '=', 'instutes.id')
            ->select('users.*', 'instutes.name as schoolname','instutes.code','instutes.id as schoolID');

        if (!empty($this->search)) {
            $searchTerm = '%' . $this->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('users.name', 'like', $searchTerm)
                    ->orWhere('users.email', 'like', $searchTerm)
                    ->orWhere('users.phone', 'like', $searchTerm)
                    ->orWhere('users.school_name', 'like', $searchTerm)  // for institute = Other
                    ->orWhere('instutes.name', 'like', $searchTerm)  // for institute != Other
                    ->orWhere('instutes.code', 'like', $searchTerm);
            });
        }

        $admins = $query->paginate();

        return view('livewire.admin.college-list', [
            'admins' => $admins
        ]);
    }

    public function export()
    {
        $is_login = auth()->user();
        if (auth()->user()->is_admin) {
            $students = User::where('is_college',1)->get();

            $csvData = [];
            $csvData[] = ['Sr.No', 'School Name', 'Code', 'Register Link', 'Principal Name', 'Principal Mobile', 'Principal Email', 'Spoc Name', 'Spoc Eamil', 'Spoc Mobile', 'Country', 'State', 'City', 'Pincode', 'Registration Date'];

            foreach ($students as $index => $student) {
                $instituteData = Instute::where('id', $student->institute)->first();

                $instituteName = $instituteData->name;
                $instituteCode = $instituteData->code;
                $registerLink = url('/register/').'/'.$instituteCode;
                $email = !empty($student->email) ? $student->email : 'N/A';

                $csvData[] = [
                    $index + 1,
                    $instituteName,
                    $instituteCode,
                    $registerLink,
                    $student->name,
                    ($student->country_code || $student->phone) ? '+' . trim($student->country_code . ' ' . $student->phone) : 'N/A',
                    $email,
                    $student->parent_name,
                    $student->spoc_email,
                    ($student->spoc_country_code || $student->spoc_mobile) ? '+' . trim($student->spoc_country_code . ' ' . $student->spoc_mobile) : 'N/A',
                    $student->country,
                    $student->state,
                    $student->city,
                    $student->pincode,
                    $student->created_at->format('d-m-Y'),
                ];
            }

            // Convert array to CSV
            $filename = 'school_export_' . now()->format('Y_m_d_H_i_s') . '.csv';
            $handle = fopen('php://temp', 'r+');

            foreach ($csvData as $row) {
                fputcsv($handle, $row);
            }

            rewind($handle);
            $csvOutput = stream_get_contents($handle);
            fclose($handle);

            return Response::make($csvOutput, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ]);
        } else {
            Auth::logout();
            return redirect()->route('login');
        }
    }

    public function verifySchool(Request $request, $id)
    {
        $admin = User::find($id);
        if ($admin) {
            $admin->is_verified = $request->verify;
            $admin->save();
            if ($admin->institute) {
                $institute = Instute::find($admin->institute);
                if ($institute) {
                    $institute->status = 1;
                    $institute->save();
                }
            }
          // Mail::to($admin->email)->send(new VarifyEmail($admin->name));
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    public function uploadCsv(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt',
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();

        $csvData = array_filter(array_map('str_getcsv', file($path)), function ($row) {
            // Remove rows where all values are empty or contain only whitespace
            return array_filter($row, function ($value) {
                return trim($value) !== '';
            });
        });

        if (empty($csvData) || count($csvData) < 2) {
            return response()->json([
                'success' => false,
                'message' => 'CSV file is empty or improperly formatted.'
            ]);
        }
        $headerData = $csvData[0];
        if(!($headerData[1] == 'school_name') || !($headerData[2] == 'principal_name') || !($headerData[3] == 'principal_mobile') || !($headerData[4] == 'principal_email') || !($headerData[5] == 'country') || !($headerData[6] == 'state') || !($headerData[7] == 'city') || !($headerData[8] == 'spoc_name') || !($headerData[9] == 'spoc_email') || !($headerData[10] == 'spoc_mobile') || !($headerData[11] == 'principal_country_code') || !($headerData[12] == 'spoc_country_code') || !($headerData[13] == 'pincode')){
            return response()->json([
                'success' => false,
                'message' => 'CSV file is improperly formatted.'
            ]);
        }
        $classIds = Classess::pluck('id')->toArray();
        $encodedClassIds = json_encode(array_map('strval', $classIds));

        foreach ($csvData as $key => $row) {
            if ($key === 0) continue; // Skip header

            // Ensure minimum column count
            if (count($row) < 14) continue;

            // Trim all values
            $row = array_map('trim', $row);

            [
                $index, $schoolName, $principalName, $mobile, $email, $country,
                $state, $city, $spocName, $spocEmail, $spocMobile, $principalCountryCode, $spocCountryCode, $pincode
            ] = $row;

            // Check for any empty value
            if (
                $schoolName === '' || $principalName === '' || $mobile === '' || $email === '' ||
                $country === '' || $state === '' || $city === '' || $spocName === '' ||
                $spocEmail === '' || $spocMobile === '' || $principalCountryCode === '' ||
                $spocCountryCode === '' || $pincode === ''
            ) {
                continue; // Skip row with any blank value
            }
            // Check if already exists
            $exists = User::where('email', $email)->exists() ||
                    User::where('phone', $mobile)->exists() ||
                    Instute::where('name', $schoolName)->exists();
            if ($exists) {
                continue; // Skip duplicate entry
            }

            // Create institute
            $institute = Instute::create([
                'name' => $schoolName,
                'status' => 1,
            ]);
            // 1. Remove all special characters except letters and spaces
            $cleanedName = preg_replace('/[^a-zA-Z\s]/', '', $schoolName);

            // 2. Replace multiple spaces with a single space
            $cleanedName = preg_replace('/\s+/', ' ', $cleanedName);

            // 3. Extract initials
            $initials = collect(explode(' ', $cleanedName))
                ->filter()
                ->map(fn($word) => strtoupper(substr($word, 0, 1)))
                ->implode('');

            // 4. Generate the final school code with a random 2-digit number
            $code = $initials . $institute->id;
            // Generate institute code: initials + ID

            $institute->code = $code;
            $institute->save();

            // Create user
            User::create([
                'name' => $principalName,
                'parent_name' => $spocName,
                'email' => $email,
                'institute' => $institute->id,
                'class' => $encodedClassIds,
                'state' => $state,
                'city' => $city,
                'phone' => $mobile,
                'spoc_mobile' => $spocMobile,
                'country' => $country,
                //'password' => Hash::make($request->password),
                'password' => Hash::make($mobile),
                'is_college' => 1,
                'reg_no' => $code,
                //'loginId' => $loginId,
                'loginId' => $email,
                'is_verified' => 1,
                'spoc_email' => $spocEmail,
                'country_code' => $principalCountryCode,
                'spoc_country_code' => $spocCountryCode,
                'pincode' => $pincode
            ]);

            // Optional: send email
            // Mail::to($spocEmail)->send(new WelcomeEmail($schoolName, $spocEmail, $spocName));
        }

        return response()->json([
            'success' => true,
            'message' => 'CSV uploaded and schools created successfully.'
        ]);
    }
}
