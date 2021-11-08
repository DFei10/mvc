<?php

namespace App;

class App
{
    private static DB $db;

    public function __construct(protected Router $router, Config $config)
    {
        static::$db = new DB($config->db);
    }

    public static function db(): DB
    {
        return static::$db;
    }

    public function run()
    {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            http_response_code(404);
            echo $e->getMessage();
        }
    }
}
