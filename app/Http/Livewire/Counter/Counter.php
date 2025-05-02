<?php
 
namespace App\Http\Livewire\Counter;
 
use Livewire\Component;
 
class Counter extends Component
{
    public $count = 0;
    public $ravi = "interactivebees";
 
    public function increment()
    {
        $this->count++;
    }
 
    public function render()
    {
        return view('livewire.counter.counter');
    }
}