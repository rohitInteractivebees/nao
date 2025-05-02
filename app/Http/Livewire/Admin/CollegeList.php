<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use App\Models\Instute;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;

class CollegeList extends Component
{
    public function delete(User $admin)
    {
        abort_if(!auth()->user()->is_admin, Response::HTTP_FORBIDDEN, 403);

        $admin->delete();
    }

    public function render(): View
    {
        $admins = User::where('is_college',1)->paginate();

        return view('livewire.admin.college-list', [
            'admins' => $admins
        ]);
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
}
