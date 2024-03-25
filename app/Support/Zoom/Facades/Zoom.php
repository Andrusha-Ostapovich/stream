<?php

namespace App\Support\Zoom\Facades;

use App\Support\Zoom\ZoomManager;
use Illuminate\Support\Facades\Facade;

class Zoom extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return ZoomManager::class;
    }
}
