<?php

namespace App\Livewire;

use App\Models\Member;
use Livewire\Attributes\On;
use Livewire\Component;

class MemberSignature extends Component
{
    public Member $member;

    public $signature;

    public function render()
    {
        return view('livewire.member-signature');
    }

    #[On('set-signature')]
    public function setSignature($signature)
    {
        $this->signature = $signature;
    }

    public function saveSignature()
    {
        $this->member->update([
            'waiver_signature' => $this->signature,
        ]);

        return redirect()->route('waiver.success');
    }
}
