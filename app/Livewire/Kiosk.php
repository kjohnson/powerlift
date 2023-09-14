<?php

namespace App\Livewire;

use App\Models\Member;
use Livewire\Attributes\On;
use Livewire\Component;

class Kiosk extends Component
{
    public $message;

    public function render()
    {
        return view('livewire.kiosk')
            ->title('Kiosk');
    }

    #[On('scan')]
    public function onScan($code)
    {
        $member = Member::where('member_id', $code)->first();

        if($member) {
            $member->checkins()->create();
            $this->message = "Welcome back, $member->name!";
        } else {
            $this->message = 'Member not found';
        }
    }

    #[On('reset')]
    public function onReset()
    {
        $this->message = '';
    }
}
