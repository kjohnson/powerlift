<?php

namespace App\Livewire;

use App\Models\MemberLead;
use Livewire\Component;

class Registration extends Component
{
    public $currentStep = 1;

    public $name;
    public $emailAddress;
    public $phoneNumber;

    public $addressStreet;
    public $addressCity;
    public $addressState;
    public $addressZip;

    public $creditCardNumber;
    public $creditCardExpiration;
    public $creditCardCVV;

    public function mount(){
        $this->currentStep = 1;
    }

    public function render()
    {
        return view('livewire.registration');
    }

    public function nextStep(){
        $this->resetErrorBag();
        $this->validateData();

        if($this->currentStep == 1){
            $this->captureLead();
        }

        $this->currentStep++;
    }

    public function validateData(){
        if($this->currentStep == 1){
            $this->validate([
                'name'=>'required|string',
                'emailAddress'=>'required|email',
                'phoneNumber'=>'required',
            ]);
        }
        elseif($this->currentStep == 2){
            $this->validate([
                'creditCardNumber' => 'required',
                'creditCardExpiration' => 'required',
                'creditCardCVV' => 'required',
            ]);
        }
        elseif($this->currentStep == 3){
            $this->validate([
                'addressStreet' => 'required',
                'addressCity' => 'required',
                'addressState' => 'required',
                'addressZip' => 'required',
            ]);
        }
    }

    public function register()
    {
        dd($this);
    }

    protected function captureLead()
    {
        MemberLead::create([
            'name' => $this->name,
            'email' => $this->emailAddress,
            'phone' => $this->phoneNumber,
        ]);
    }
}
