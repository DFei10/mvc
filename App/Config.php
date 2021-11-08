<?php

namespace App;

use Exception;

class Config
{
    protected array $config =  [];

    public function __construct()
    {
        $this->config['db'] = [
            'driver' => $_ENV['DB_DRIVER'],
            'host' => $_ENV['DB_HOST'],
            'database' => $_ENV['DB_DATABASE'],
            'username' => $_ENV['DB_USERNAME'],
            'password' => $_ENV['DB_PASSWORD'],
        ];
    }

    public function __get($name)
    {
        return isset($this->config[$name]) ? $this->config[$name] : throw new Exception("property {$name} does not exists");
    }
}
