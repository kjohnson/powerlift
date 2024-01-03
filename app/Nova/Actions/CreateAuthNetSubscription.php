<?php

namespace App\Nova\Actions;

use App\Models\Member;
use App\Models\MemberLead;
use App\Models\MembershipPlan;
use DateTime;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class CreateAuthNetSubscription extends Action
{
    public $name = 'Create Subscription';

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

        $plan = MembershipPlan::find($fields->membership_plan);

        // Create subscription from customer/payment profile.
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName('42SdZ9B5sgT');
        $merchantAuthentication->setTransactionKey('44H3Uf98772BpwxX');

        // Set the transaction's refId
        $refId = 'ref' . time();

        // Subscription Type Info
        $subscription = new AnetAPI\ARBSubscriptionType();
        $subscription->setName($plan->name);

        $interval = new AnetAPI\PaymentScheduleType\IntervalAType();
        $interval->setLength(1);
        $interval->setUnit("months");

        $paymentSchedule = new AnetAPI\PaymentScheduleType();
        $paymentSchedule->setInterval($interval);
        $paymentSchedule->setStartDate(new DateTime);
        $paymentSchedule->setTotalOccurrences("9999");

        $subscription->setPaymentSchedule($paymentSchedule);
        $subscription->setAmount($plan->price);

        $profile = new AnetAPI\CustomerProfileIdType();
        $profile->setCustomerProfileId($member->authnet_customer_profile_id);
        $profile->setCustomerPaymentProfileId($member->authnet_customer_payment_profile_id);

        $subscription->setProfile($profile);

        $request = new AnetAPI\ARBCreateSubscriptionRequest();
        $request->setmerchantAuthentication($merchantAuthentication);
        $request->setRefId($refId);
        $request->setSubscription($subscription);
        $controller = new AnetController\ARBCreateSubscriptionController($request);

        $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);

        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok") ) {
            echo "SUCCESS: Subscription ID : " . $response->getSubscriptionId() . "\n";

            $member->update([
                'authnet_subscription_id' => $response->getSubscriptionId(),
            ]);

            return Action::message('Subscription created.');
        } else {
            $errorMessages = $response->getMessages()->getMessage();
            $errorMessageText = $errorMessages[0]->getText();
            $errorMessageCode = $errorMessages[0]->getCode();
            return Action::danger("Error: $errorMessageText ($errorMessageCode)");
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
            Select::make('Plan', 'membership_plan')->options(
                MembershipPlan::all()->pluck('name', 'id')
            ),
        ];
    }
}
