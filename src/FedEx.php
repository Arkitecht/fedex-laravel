<?php
/**
 * User: sutter
 * Date: 1/4/16
 * Time: 8:09 PM
 */

namespace Arkitecht\FedEx\Laravel;

use Arkitecht\FedEx\Services\RateService;
use Arkitecht\FedEx\Services\ShipService;
use Arkitecht\FedEx\Services\TrackService;
use Arkitecht\FedEx\Structs\ClientDetail;
use Arkitecht\FedEx\Structs\ProcessShipmentRequest;
use Arkitecht\FedEx\Structs\RateRequest;
use Arkitecht\FedEx\Structs\TrackRequest;
use Arkitecht\FedEx\Structs\WebAuthenticationCredential;
use Arkitecht\FedEx\Structs\WebAuthenticationDetail;
use Illuminate\Config\Repository;

class FedEx
{
    /**
     * @var array
     */
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function rateRequest()
    {
        $rateRequest = new RateRequest();
        $this->setDetails($rateRequest);

        return $rateRequest;
    }

    public function rateService(array $wsdlOptions = array(), $resetSoapClient = true)
    {
        $rateService = new RateService($wsdlOptions, $resetSoapClient, $this->config['beta']);

        return $rateService;
    }

    public function trackRequest()
    {
        $trackRequest = new TrackRequest();
        $this->setDetails($trackRequest);

        return $trackRequest;
    }

    function trackService(array $wsdlOptions = array(), $resetSoapClient = true)
    {
        $trackService = new TrackService($wsdlOptions, $resetSoapClient, $this->config['beta']);

        return $trackService;
    }

    public function shipRequest()
    {
        $shipRequest = new ProcessShipmentRequest();
        $this->setDetails($shipRequest);

        return $shipRequest;
    }

    function shipService(array $wsdlOptions = array(), $resetSoapClient = true)
    {
        $shipService = new ShipService($wsdlOptions, $resetSoapClient, $this->config['beta']);

        return $shipService;
    }


    public function setDetails(&$request)
    {
        $request->setWebAuthenticationDetail($this->getWebAuthenticationDetail());
        $request->setClientDetail($this->getClientDetail());
    }

    public function getWebAuthenticationDetail()
    {
        $webAuthenticationCredential = new WebAuthenticationCredential($this->config['key'], $this->config['password']);
        $webAuthenticationDetail = new WebAuthenticationDetail();
        $webAuthenticationDetail->setUserCredential($webAuthenticationCredential);

        return $webAuthenticationDetail;
    }

    public function getClientDetail()
    {
        $clientDetail = new ClientDetail($this->config['account'], $this->config['meter']);

        return $clientDetail;
    }

}