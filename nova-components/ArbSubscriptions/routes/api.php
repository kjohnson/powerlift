<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

Route::get('/', function (Request $request) {
    return Cache::remember('arb-subscriptions', 60, function() {
        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName('42SdZ9B5sgT');
        $merchantAuthentication->setTransactionKey('44H3Uf98772BpwxX');

        // Set the transaction's refId
        $refId = 'ref' . time();

        $request = new AnetAPI\ARBGetSubscriptionListRequest();
        $request->setMerchantAuthentication($merchantAuthentication);
        $request->setSearchType("subscriptionActive");
        $request->setRefId($refId);

        $controller = new AnetController\ARBGetSubscriptionListController($request);

        $response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);

        if (($response != null) && ($response->getMessages()->getResultCode() == "Ok")) {
            return $response->getSubscriptionDetails();
        }

        $errorMessages = $response->getMessages()->getMessage();
        return [];
    });
 });
