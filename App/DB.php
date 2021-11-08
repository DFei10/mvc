<?php

namespace App;

use PDO;
use PDOException;
use Throwable;

class DB
{
    private PDO $pdo;
    private QueryBuilder $query;

    public function __construct($config)
    {
        try {
            $this->pdo = new PDO(
                "{$config['driver']}:host={$config['host']};dbname={$config['database']}",
                $config['username'],
                $config['password']
            );
        } catch (Throwable $e) {
            throw new PDOException($e->getMessage(), $e->getCode());
        }

        $this->query = new QueryBuilder();
    }

    public function __call($name, $arguments)
    {
        if (method_exists($this, $name)) {
            return call_user_func_array([$this->pdo, $name], $arguments);
        }
    }
}
