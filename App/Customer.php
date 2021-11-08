<?php

namespace App;

class Customer
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email
    ) {
    }
}