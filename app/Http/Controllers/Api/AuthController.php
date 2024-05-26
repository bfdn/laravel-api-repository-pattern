<?php

namespace App\Http\Controllers\Api;


use App\Core\HttpResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthController\LoginRequest;
use App\Interfaces\Eloquent\IAuthService;
use http\Env\Request;

class AuthController extends Controller
{
    use HttpResponse;
    private IAuthService $authService;

    public function __construct(IAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request)
    {
        $response = $this->authService->login(
            email: $request->email,
            password: $request->password
        );
        return $this->httpResponse($response);
    }
}
