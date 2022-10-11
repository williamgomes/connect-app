<?php

namespace App\Exceptions;

use Exception;

class BaseModelValidationException extends Exception
{
    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        return true;
    }
}
