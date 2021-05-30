<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LoginWithSocialProviderRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\RegisterWithSocialProviderRequest;
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
        return $this->authService->registerMemberWithUsernamePassword($validatedData);
    }

    public function login(LoginRequest $request)
    {
        $validatedData = $request->validated();
        return $this->authService->loginUserWithUsernamePassword($validatedData);
    }

    public function socialResgister(RegisterWithSocialProviderRequest $request)
    {
        $validatedData = $request->validated();
        return $this->authService->registerMemberWithSocialProvider($validatedData);
    }

    public function socialLogin(LoginWithSocialProviderRequest $request)
    {
        $validatedData = $request->validated();
        return $this->authService->loginWithSocialProvider($validatedData);
    }
}
