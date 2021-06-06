<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginAdminRequest;
use App\Services\Contracts\AdminAuthServiceInterface;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    private $adminAuthService;

    public function __construct(AdminAuthServiceInterface $adminAuthService)
    {
        $this->adminAuthService = $adminAuthService;
    }

    public function login(LoginAdminRequest $request)
    {
        $validatedData = $request->validated();
        return $this->adminAuthService->loginAdminWithUsernamePassword($validatedData);
    }
}
