<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Contracts\AuthServiceInterface;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    private $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();
        return $this->authService->registerUserWithUsernamePassword($validatedData);
    }

    public function login(LoginRequest $request)
    {
        $validatedData = $request->validated();
        return $this->authService->loginUser($validatedData);
    }
}
