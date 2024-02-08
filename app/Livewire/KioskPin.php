<?php

namespace App\Livewire;

use App\Models\Member;
use Livewire\Attributes\On;
use Livewire\Component;

class KioskPin extends Component
{
    public $pin;

    public $message;

    public function render()
    {
        return view('livewire.kiosk-pin');
    }


    public function pinAsPassword()
    {
        return str_repeat('●', strlen($this->pin));
    }

    public function input($number)
    {
        $this->pin .= $number;
        if(strlen($this->pin) === 4) {

            $member = Member::where('pin', $this->pin)->first();

            if($member) {
                $member->checkins()->create();
                $this->message = "Welcome back, $member->first_name!";
            } else {
                $this->message = 'Member not found';
            }

            $this->dispatch('flash-message');
        }
    }

    public function backspace()
    {
        $this->pin = substr($this->pin, 0, -1);
    }

    #[On('reset')]
    public function clear()
    {
        $this->pin = '';
        $this->message = '';
    }
}
