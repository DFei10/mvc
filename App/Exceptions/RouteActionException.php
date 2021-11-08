<?php

namespace App\Exceptions;

use Exception;

class RouteActionException extends Exception
{
    public function __construct(string $method)
    {
        $this->message = "Method {$method} does not exists";
    }
}
