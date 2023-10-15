<?php

namespace Susheelbhai\Laratrack\Services\Facades;

use Illuminate\Support\Facades\Facade;

class Laratrack extends Facade{

    protected static function getFacadeAccessor()
    {
        
        return 'laratrack';
    }

}