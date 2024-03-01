<?php

namespace App\Nova\Actions;

use App\Models\Member;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class AddPaymentBankAccount extends Action
{
    public $name = 'Add Bank Account';

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        /** @var Member $member */
        $member = $models->first();

        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName(config('services.authnet.login_id'));
        $merchantAuthentication->setTransactionKey(config('services.authnet.transaction_key'));

        // Set the transaction's refId
        $refId = 'ref' . time();

        // Bank Account
        $bank_account = new AnetAPI\BankAccountType();
        $bank_account->setNameOnAccount($fields->account_name);
        $bank_account->setRoutingNumber($fields->routing_number);
        $bank_account->setAccountNumber($fields->account_number);
        $bank_account->setAccountType($fields->account_type);
        $bank_account->setBankName($fields->bank_name);
//        $bank_account->setEcheckType('WEB');

        // Billing Information (Basic)
        $billTo = new AnetAPI\CustomerAddressType();
        [$firstName, $lastName] = explode(' ', $member->name);
        $billTo->setFirstName($firstName);
        $billTo->setLastName($lastName);
        $billTo->setEmail($member->email);

        // Payment Profile
        $paymentProfile = new AnetAPI\CustomerPaymentProfileType();
        $paymentProfile->setCustomerType('individual');
        $paymentProfile->setBillTo($billTo);
        $paymentProfile->setPayment(
            (new AnetAPI\PaymentType())->setBankAccount($bank_account)
        );
        $paymentProfiles[] = $paymentProfile;

        $customerProfile = new AnetAPI\CustomerProfileType();
        $customerProfile->setDescription("created via PowerLift");
        $customerProfile->setMerchantCustomerId("M_" . time());
        $customerProfile->setEmail($member->email);
        $customerProfile->setpaymentProfiles($paymentProfiles);

        // Assemble the complete transaction request
        $request = new AnetAPI\CreateCustomerProfileRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setProfile($customerProfile);

        // Create the controller and get the response
        $controller = new AnetController\CreateCustomerProfileController($request);
        $response = $controller->executeWithApiResponse(config('services.authnet.env'));

        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {

            $member->captureCustomerProfileId($response->getCustomerProfileId());
            $member->capturePaymentProfileIdBankAccount($response->getCustomerPaymentProfileIdList()[0]);

        } else {
            dd('here', $response->getMessages()->getMessage());
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Text::make('Name on Account', 'account_name'),
            Text::make('Routing Number', 'routing_number'),
            Text::make('Account Number', 'account_number'),
            Text::make('Bank Name', 'bank_name'),
            Select::make('Account Type', 'account_type')->options([
                'checking' => 'Checking',
                'savings' => 'Savings',
                'business' => 'Business Checking',
            ]),
        ];
    }
}
