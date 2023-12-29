<?php

namespace App\Nova\Actions;

use App\Models\Member;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class CreateAuthNetPaymentProfile extends Action
{
    public $name = 'Create Payment Profile';

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
        $merchantAuthentication->setName('42SdZ9B5sgT');
        $merchantAuthentication->setTransactionKey('44H3Uf98772BpwxX');

        // Set the transaction's refId
        $refId = 'ref' . time();

        // Credit Card
        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($fields->card_number);
        $creditCard->setExpirationDate($fields->expiration_date); // 2038-12
        $creditCard->setCardCode($fields->cvv);

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
            (new AnetAPI\PaymentType())->setCreditCard($creditCard)
        );
        $paymentProfiles[] = $paymentProfile;

        $customerProfile = new AnetAPI\CustomerProfileType();
        $customerProfile->setDescription("created via PowerList");
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
        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {

            $member->captureCustomerProfileId($response->getCustomerProfileId());
            $member->capturePaymentProfileId($response->getCustomerPaymentProfileIdList()[0]);

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
            Text::make('Credit Card Number', 'card_number'),
            Text::make('Expiration Date', 'expiration_date'),
            Text::make('CVV', 'cvv'),
        ];
    }
}
