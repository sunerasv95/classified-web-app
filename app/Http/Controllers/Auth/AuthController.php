<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\LoginWithSocialProviderRequest;
use App\Http\Requests\Auth\RegisterWithSocialProviderRequest;
use App\Http\Requests\Member\CreateMemberRequest;
use App\Services\Contracts\AuthServiceInterface;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function register(CreateMemberRequest $request)
    {
        $validatedData = $request->validated();
        //dd($validatedData);
        return $this->authService->registerMember($validatedData);
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
