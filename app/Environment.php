<?php

namespace App;

use Illuminate\Support\Facades\App;

class Environment
{
    public static function shouldExecute()
    {
        return App::environment('production');
    }
}
