<?php

namespace App\Nova;

use Laravel\Nova\Fields\Email;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Powerlift\WebcamPhotoCapture\WebcamPhotoCapture;

use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

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
        'name',
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
            Text::make(__('Name'), 'name')
                ->sortable()
                ->rules('required', 'max:255'),
            Email::make('email'),
            Text::make(__('Membership ID'), 'member_id')
                ->sortable()
                ->rules('required'),
            Text::make(__('PIN'), 'pin')
                ->onlyOnForms()
                ->rules('max:4'),
            HasMany::make('Checkins', 'checkins', Checkin::class),
            WebcamPhotoCapture::make('Photo', 'photo')->hideFromIndex(),
            Text::make('Subscription', function() {

                $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
                $merchantAuthentication->setName('42SdZ9B5sgT');
                $merchantAuthentication->setTransactionKey('44H3Uf98772BpwxX');

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
        return [];
    }
}
