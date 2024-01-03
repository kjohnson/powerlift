<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/nova');
});

Route::get('/kiosk', \App\Livewire\Kiosk::class);
Route::get('/registration', \App\Livewire\Registration::class);
Route::get('/fitness-class/{fitnessClass}/sessions/', \App\Livewire\Sessions::class);

use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
Route::get('arb', function() {

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
        echo "SUCCESS: Subscription Details:" . "\n";
        foreach ($response->getSubscriptionDetails() as $subscriptionDetails) {
            echo "Subscription ID: " . $subscriptionDetails->getId() . "\n";
        }
        echo "Total Number In Results:" . $response->getTotalNumInResultSet() . "\n";
    } else {
        echo "ERROR :  Invalid response\n";
        $errorMessages = $response->getMessages()->getMessage();
        echo "Response : " . $errorMessages[0]->getCode() . "  " .$errorMessages[0]->getText() . "\n";
    }

    dd($response->getSubscriptionDetails());
});
