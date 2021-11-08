<?php

namespace App\Exceptions;

use Exception;

class ControllerNotFoundException extends Exception
{
    public function __construct(string $class)
    {
        $this->message = "{$class} class not Found";
    }
}
