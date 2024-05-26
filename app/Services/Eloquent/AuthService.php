<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Interfaces\Eloquent\IAuthService;
use App\Interfaces\Eloquent\IUserService;
use App\Models\User;

class AuthService implements IAuthService
{

    public function login(string $email, string $password): ServiceResponse
    {
        $userService = app()->make(IUserService::class);

        $user = $userService->getByEmail($email);
        if ($user->isSuccess()) {
            $user = $user->getData();
            if (!password_verify($password, $user->password)) {
                return new ServiceResponse(false, 'Mail and password do not match', null, 401);
            }
            $token = $user->createToken('authToken')->plainTextToken;
            return new ServiceResponse(true, 'Login successful', ['token' => $token, 'user' => $user], 200);
        }
        return new ServiceResponse(false, 'Mail and password do not match', null, 401);
    }

    public function login__old(string $email, string $password): ServiceResponse
    {
        $userService = app()->make(IUserService::class);

        // $user = User::where('email', $email)->first();
        $user = $userService->getByEmail($email);
        // if (!$user) {
        if (!$user->isSuccess()) {
            // return new ServiceResponse(false, 'Mail and password do not match', null, 401);
        }

        $user = $user->getData();
        if (!password_verify($password, $user->password)) {
            return new ServiceResponse(false, 'Mail and password do not match', null, 401);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return new ServiceResponse(true, 'Login successful', ['token' => $token, 'user' => $user], 200);
    }
}
