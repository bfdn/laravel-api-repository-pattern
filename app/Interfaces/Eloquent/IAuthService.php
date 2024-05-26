<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface IAuthService
{

    public function login(string $email, string $password):ServiceResponse;

}
