<?php

namespace App\Livewire;

use Livewire\Component;

class Registration extends Component
{
    public $firstName;
    public $lastName;
    public $emailAddress;
    public $phoneNumber;

    public function render()
    {
        return view('livewire.registration');
    }

    public function register()
    {
        dd($this);
    }
}
