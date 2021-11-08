<?php

namespace App\Controllers;

use App\View;

class UsersController
{
    public function index()
    {
        return View::make('users.index');
    }

    public function create()
    {
        return View::make('users.create');
    }

    public function store()
    {
        // Grab $email, $username
        // $user = new User(),
        // $user->create(['email' => $email, 'username' => $name]);
    }
}
