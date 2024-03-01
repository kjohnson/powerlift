<?php

namespace App\Nova;

use App\Nova\Actions\AddPaymentBankAccount;
use App\Nova\Actions\AddPaymentCreditCard;
use App\Nova\Actions\CreateAuthNetSubscription;
use App\Nova\Actions\Kisi as Kisi;
use App\Nova\Actions\SendWaiverSignatureRequest;
use Illuminate\Support\Facades\Http;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Email;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use Powerlift\WebcamPhotoCapture\WebcamPhotoCapture;

class Member extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\App\Models\Member>
     */
    public static $model = \App\Models\Member::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'first_name',
        'last_name',
        'member_id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Date::make(__('Member Since'), 'member_since')
                ->sortable(),
            Text::make(__('First Name'), 'first_name')
                ->sortable()
                ->rules('required'),
            Text::make(__('Last Name'), 'last_name')
                ->sortable(),
            Email::make(__('Email'), 'email'),
            Text::make(__('Phone'), 'phone'),
            Text::make(__('Membership ID'), 'member_id')->hideFromIndex(),
            Text::make(__('PIN'), 'pin')
                ->hideFromIndex()
                ->rules('max:4'),
            WebcamPhotoCapture::make('Photo', 'photo')->hideFromIndex(),
//            Text::make('Subscription', 'authnet_subscription_id')->onlyOnIndex(),
            new Panel('Subscription', [
                Text::make('Subscription', function() {

                    $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
                    $merchantAuthentication->setName('42SdZ9B5sgT');
                    $merchantAuthentication->setTransactionKey('44H3Uf98772BpwxX');

                    if($this->authnet_subscription_id){
                        $request = new AnetAPI\ARBGetSubscriptionRequest();
                        $request->setMerchantAuthentication($merchantAuthentication);
                        $request->setRefId('ref' . time());
                        $request->setSubscriptionId($this->authnet_subscription_id);
                        $request->setIncludeTransactions(true);

                        $controller = new AnetController\ARBGetSubscriptionController($request);
                        $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
                        $subscription = $response->getSubscription();
                        return $subscription->getName() . ' (' . $subscription->getStatus(). ')';
                    }

                    $request = new AnetAPI\GetCustomerProfileRequest();
                    $request->setMerchantAuthentication($merchantAuthentication);
                    $request->setEmail($this->email);
                    $controller = new AnetController\GetCustomerProfileController($request);
                    $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);

                    return $response->getSubscriptionIds() ? json_encode(array_map(function($subscriptionId) use ($merchantAuthentication) {
                        $request = new AnetAPI\ARBGetSubscriptionRequest();
                        $request->setMerchantAuthentication($merchantAuthentication);
                        $request->setRefId('ref' . time());
                        $request->setSubscriptionId($subscriptionId);
                        $request->setIncludeTransactions(true);

                        $controller = new AnetController\ARBGetSubscriptionController($request);
                        $response = $controller->executeWithApiResponse( \net\authorize\api\constants\ANetEnvironment::SANDBOX);
                        $subscription = $response->getSubscription();
                        return $subscription->getName() . ' (' . $subscription->getStatus(). ')';
                    }, array_values($response->getSubscriptionIds()))) : 'No subscription';
                })->onlyOnDetail(),
            ]),
            new Panel('Address', [
                Text::make(__('Address'), 'address')->hideFromIndex(),
                Text::make(__('City'), 'city')->hideFromIndex(),
                Text::make(__('State'), 'state')->hideFromIndex(),
                Text::make(__('Zip'), 'zip')->hideFromIndex(),
                Text::make(__('Country'), 'country')->hideFromIndex(),
            ]),
            HasMany::make('Checkins', 'checkins', Checkin::class),
            new Panel('Payment Information', [
                Text::make(__('Customer Profile ID'), 'authnet_customer_profile_id')->onlyOnDetail(),
                Text::make(__('Credit Card Profile ID'), 'authnet_customer_payment_profile_id__credit_card')->onlyOnDetail(),
                Text::make(__('Bank Account Profile ID'), 'authnet_customer_payment_profile_id__bank_account')->onlyOnDetail(),
            ]),
            new Panel('Waiver', [
                Text::make(__('Waiver Signature'), function() {
                    return "<div style='background-color: white;'><img src='$this->waiver_signature' /></div>";
                })
                    ->onlyOnDetail()
                    ->asHtml(),
            ]),
            Boolean::make('Door Access', function() {

                if(!$this->email) return false;

                $members = Http::withHeaders([
                    'Authorization' => 'KISI-LOGIN ' . env('KISI_API_KEY'),
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ])->get('https://api.kisi.io/members', [
                    'query' => $this->email,
                    'limit' => 1,
                ])->json();

                return $members[0]['access_enabled'] ?? false;
            })->onlyOnDetail(),
            new Panel('Notes', [
                Textarea::make(__('Notes'))
                    ->alwaysShow()
                    ->hideFromIndex(),
            ]),
            new Panel('Contacts', [
                Textarea::make(__('Contacts'))
                    ->alwaysShow()
                    ->hideFromIndex(),
            ]),
            Date::make(__('Date of Birth'), 'date_of_birth')
                ->hideFromIndex(),
            Text::make(__('Gender'), 'gender')
                ->hideFromIndex(),
            Email::make(__('2nd Email'), 'email2')
                ->hideFromIndex(),
            Text::make(__('2nd Phone'), 'phone2')
                ->hideFromIndex(),
        ];
    }

    public function subtitle()
    {
        return "Member ID: $this->member_id";
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        $actions = [
            AddPaymentCreditCard::make()
                ->confirmText('Add a credit card for this member?')
                ->confirmButtonText('Create'),
            AddPaymentBankAccount::make()
                ->confirmText('Add a bank account for this member?')
                ->confirmButtonText('Save'),
        ];

        if(
            $this->authnet_customer_profile_id
            && $this->authnet_customer_payment_profile_id__credit_card || $this->authnet_customer_payment_profile_id__bank_account
        ) {
            $actions[] = CreateAuthNetSubscription::make();
        }

        $actions[] = SendWaiverSignatureRequest::make();

        $actions[] = Kisi\AddUser::make()->sole();
        $actions[] = Kisi\SendAccess::make()->sole();
        $actions[] = Kisi\ToggleAccess::make()->sole();

        return $actions;
    }
}
