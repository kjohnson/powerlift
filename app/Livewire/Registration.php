<?php

namespace App\Livewire;

use App\Models\Member;
use App\Models\MemberLead;
use Livewire\Component;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class Registration extends Component
{
    public $currentStep = 1;

    public $firstName;
    public $lastName;
    public $emailAddress;
    public $phoneNumber;

    public $creditCardNumber;
    public $creditCardExpiration;
    public $creditCardCVV;

    public MemberLead $memberLead;

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
                'firstName'=>'required|string',
                'lastName'=>'required|string',
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
    }

    public function register()
    {
        $this->createCustomerProfile();
    }

    protected function captureLead()
    {
        $this->memberLead = MemberLead::create([
            'name' => $this->firstName . ' ' . $this->lastName,
            'email' => $this->emailAddress,
            'phone' => $this->phoneNumber,
        ]);
    }

    protected function createCustomerProfile()
    {
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName('42SdZ9B5sgT');
        $merchantAuthentication->setTransactionKey('44H3Uf98772BpwxX');

        // Set the transaction's refId
        $refId = 'ref' . time();

        // Credit Card
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($this->creditCardNumber);
        $creditCard->setExpirationDate($this->creditCardExpiration); // 2038-12
        $creditCard->setCardCode($this->creditCardCVV);

        // Billing Information (Basic)
        $billTo = new AnetAPI\CustomerAddressType();
        $billTo->setFirstName($this->firstName);
        $billTo->setLastName($this->lastName);
        $billTo->setEmail($this->emailAddress);

        // Payment Profile
        $paymentProfile = new AnetAPI\CustomerPaymentProfileType();
        $paymentProfile->setCustomerType('individual');
        $paymentProfile->setBillTo($billTo);
        $paymentProfile->setPayment(
            (new AnetAPI\PaymentType())->setCreditCard($creditCard)
        );
        $paymentProfiles[] = $paymentProfile;

        $customerProfile = new AnetAPI\CustomerProfileType();
        $customerProfile->setDescription("Customer 2 Test PHP");
        $customerProfile->setMerchantCustomerId("M_" . time());
        $customerProfile->setEmail($this->emailAddress);
        $customerProfile->setpaymentProfiles($paymentProfiles);

        // Assemble the complete transaction request
        $request = new AnetAPI\CreateCustomerProfileRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setProfile($customerProfile);

        // Create the controller and get the response
        $controller = new AnetController\CreateCustomerProfileController($request);
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {

            $this->memberLead->captureCustomerProfileId($response->getCustomerProfileId());
            $this->memberLead->capturePaymentProfileId($response->getCustomerPaymentProfileIdList()[0]);
            $this->currentStep++;

        } else {
            dd('here', $response->getMessages()->getMessage());
        }
    }
}
