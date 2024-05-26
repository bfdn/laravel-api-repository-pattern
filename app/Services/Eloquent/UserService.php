<?php

namespace App\Services\Eloquent;

use App\Core\ServiceResponse;
use App\Interfaces\Eloquent\IUserService;
use App\Models\User;

class UserService implements IUserService
{
    public function getAll(): ServiceResponse
    {
        $users = User::latest()->get();
        return new ServiceResponse(true, 'Users found', $users, 200);
    }

    public function getById(int $id): ServiceResponse
    {
        $user = User::find($id);
        if ($user) {
            return new ServiceResponse(true, 'User found', $user, 200);
        }
        return new ServiceResponse(false, 'User not found', null, 404);
    }

    public function create(string $name, string $email, string $password): ServiceResponse
    {
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);
        if ($user) {
            return new ServiceResponse(true, 'User created', $user, 200);
        }
        return new ServiceResponse(false, 'User not created', null, 500);
    }

    public function update(int $id, string $name, string $email, string $password = null): ServiceResponse
    {
        $user = $this->getById($id);
        if ($user->isSuccess()) {
            $user = $user->getData();
            $user->name = $name;
            $user->email = $email;
            if ($password) {
                $user->password = $password;
            }
            $user->save();
            return new ServiceResponse(true, 'User updated', $user, 200);
        }
        return $user;
    }

    public function delete(int $id): ServiceResponse
    {
        $user = $this->getById($id);
        if ($user->isSuccess()) {
            $user = $user->getData();
            $user->delete();
            return new ServiceResponse(true, 'User updated', $user, 200);
        }
        return $user;
    }

    public function getByEmail(string $email): ServiceResponse
    {
        $user = User::where('email', $email)->first();
        if ($user) {
            return new ServiceResponse(true, 'User found', $user, 200);
        }
        return new ServiceResponse(false, 'User not found', null, 404);
    }

    public function getProfile(): ServiceResponse
    {
        $user = auth()->user();
        if ($user) {
            return new ServiceResponse(true, 'User found', $user, 200);
        }
        return new ServiceResponse(false, 'User not found', null, 404);
    }
}
