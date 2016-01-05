<?php
namespace Arkitecht\FedEx\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

class FedEx extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'FedEx';
    }
}