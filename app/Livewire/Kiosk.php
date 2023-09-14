<?php

namespace App\Livewire;

use App\Models\Member;
use Livewire\Attributes\On;
use Livewire\Component;

class Kiosk extends Component
{
    public $memberName;

    public function render()
    {
        return view('livewire.kiosk')
            ->title('Kiosk');
    }

    #[On('scanned')]
    public function onScanned($code)
    {
        $member = Member::where('member_id', $code)->first();
        $member->checkins()->create();
        $this->memberName = $member->name;
    }

    #[On('reset')]
    public function onReset()
    {
        $this->memberName = '';
    }
}
