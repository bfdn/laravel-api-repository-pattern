<?php

namespace App\Interfaces\Eloquent;

use App\Core\ServiceResponse;

interface IUserService
{
    public function getPageAll(int $perPage): ServiceResponse;
    public function getAll(): ServiceResponse;
    public function getById(int $id): ServiceResponse;
    public function create(string $name, string $email, string $password): ServiceResponse;
    public function update(int $id, string $name, string $email, string $password = null): ServiceResponse;
    public function delete(int $id): ServiceResponse;
    public function getByEmail(string $email): ServiceResponse;
    public function getProfile(): ServiceResponse;
}
