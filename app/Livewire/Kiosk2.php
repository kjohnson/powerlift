<?php

namespace App\Livewire;

use App\Models\Member;
use Livewire\Attributes\On;
use Livewire\Component;

class Kiosk2 extends Component
{
    public function render()
    {
        return view('livewire.kiosk2')
            ->title('Kiosk');
    }
}
