<?php

namespace App\Livewire;

use App\Models\Member;
use Livewire\Attributes\On;
use Livewire\Component;

class KioskLookup extends Component
{
    public $search;

    public $members;

    public $message;

    public function render()
    {
        return view('livewire.kiosk-lookup');
    }

    public function checkin($member_id)
    {
        $member = Member::find($member_id);

        if($member) {
            $member->checkins()->create();
            $this->message = "Welcome back, $member->first_name!";
        } else {
            $this->message = 'Member not found';
        }

        $this->search = '';
        $this->dispatch('flash-message');
    }

    #[On('reset')]
    public function clear()
    {
        $this->search = '';
        $this->message = '';
    }
}
