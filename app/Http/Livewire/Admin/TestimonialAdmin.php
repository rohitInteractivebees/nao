<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Testimonial;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class TestimonialAdmin extends Component
{
    use WithPagination;

    protected $listeners = ['post','hide'];

    public function confirmPost($id)
    {
        $this->dispatchBrowserEvent('confirmPost', ['id' => $id]);
    }
    public function post($id)
    {
        $user = Testimonial::find($id);
        if ($user) {
            $user->status = 1;
            $user->save();

            session()->flash('success', 'Testimonial post successfully!');
        }
    }
    public function confirmHide($id)
    {
        $this->dispatchBrowserEvent('confirmHide', ['id' => $id]);
    }
    public function hide($id)
    {
        $user = Testimonial::find($id);
        if ($user) {
            $user->status = null;
            $user->save();

            session()->flash('success', 'Testimonial hide successfully!');
        }
    }

    public function render()
    {
        $is_login = auth()->user();

        if ($is_login->is_admin) {
            $query = Testimonial::orderBy('id','desc');

            $data = $query->paginate(10);

            return view('livewire.admin.testimonial-list-admin', [
                'data' => $data,
            ]);
        } else {
            Auth::logout();
            return redirect()->route('login');
        }
    }
}
