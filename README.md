FedEx Laravel
=================
A service provider to integrate FedEx services into your Laravel Project


Quick Installation
------------------
You can install the package most easily through composer

#### Laravel 5.x
```
composer require arkitecht/fedex-laravel
```

Using it in your project
------------------
**Add the service provider to your config/app.php**

```php
<?php

...
'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        //Illuminate\Foundation\Providers\ArtisanServiceProvider::class,
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,

...
       Arkitecht\FedEx\Laravel\Providers\FedExServiceProvider::class,
    ],
?>
```

**Add the Facade to your config/app.php**

```php
<?php

...
    'aliases' => [

        'FedEx'     => Arkitecht\FedEx\Laravel\Facades\FedEx::class

    ],
?>
```

**Publish the config file**

```artisan vendor:publish```

**Set up your environment**

Add values for the following setting keys in your .env or in config/fedex.php

* FEDEX_API_KEY - Your FedEx API Key
* FEDEX_API_PASSWORD - Your FedEx API Password
* FEDEX_ACCOUNT_NO - Your FedEx Account Number
* FEDEX_METER_NO - Your FedEx Meter Number
* FEDEX_USE_BETA - (Bool) Use the FedEx beta/test system instead of production

Example of Usage
------------------

**Get FedEx Rates**

```php
<?php

$rateRequest = FedEx::rateRequest();

$shipment = new \Arkitecht\FedEx\Structs\RequestedShipment();
$shipment->TotalWeight = new \Arkitecht\FedEx\Structs\Weight(\Arkitecht\FedEx\Enums\WeightUnits::VALUE_LB, $weight);

$shipment->Shipper = new \Arkitecht\FedEx\Structs\Party();
$shipment->Shipper->Address = new \Arkitecht\FedEx\Structs\Address(
    $shipper->address,
    $shipper->city,
    $shipper->state,
    $shipper->zip,
    null, 'US');

$shipment->Recipient = new \Arkitecht\FedEx\Structs\Party();
$shipment->Recipient->Address = new \Arkitecht\FedEx\Structs\Address(
    $recipient->address,
    $recipient->city,
    $recipient->state,
    $recipient->zip,
    null, 'US');

$lineItem = new \Arkitecht\FedEx\Structs\RequestedPackageLineItem();
$lineItem->Weight = new \Arkitecht\FedEx\Structs\Weight(\Arkitecht\FedEx\Enums\WeightUnits::VALUE_LB, $weight);
$lineItem->GroupPackageCount = 1;
$shipment->PackageCount = 1;

$shipment->RequestedPackageLineItems = [
    $lineItem
];

$rateRequest->Version = FedEx::rateService()->version;

$rateRequest->setRequestedShipment($shipment);

$rate = FedEx::rateService();

$response = $rate->getRates($rateRequest);

$rates = [];

if ($response->HighestSeverity == 'SUCCESS') {
    foreach ($response->RateReplyDetails as $rate) {
        $rates[$rate->ServiceType] = $rate->RatedShipmentDetails[0]->ShipmentRateDetail->TotalNetCharge->Amount;
    }
}