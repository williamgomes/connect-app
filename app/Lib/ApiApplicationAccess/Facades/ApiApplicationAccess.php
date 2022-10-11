<?php

namespace App\Lib\ApiApplicationAccess\Facades;

use Illuminate\Support\Facades\Facade;

class ApiApplicationAccess extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ApiApplicationAccess';
    }
}
