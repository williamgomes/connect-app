<?php

namespace App\Helpers\DuoSecurity;

interface Requester
{
    public function options($options);

    public function execute($url, $methods, $headers, $body);
}
