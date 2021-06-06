<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ApproveAdminUserRequest;
use App\Http\Requests\Admin\CreateAdminRequest;
use App\Services\Contracts\AdminServiceInterface;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private $adminService;

    public function __construct(AdminServiceInterface $adminService)
    {
        $this->adminService = $adminService;
    }

    public function create(CreateAdminRequest $request)
    {
        $validatedData = $request->validated();
        return $this->adminService->createAdminUser($validatedData);
    }

    public function approveAdminUser($adminId, ApproveAdminUserRequest $request)
    {
        $validatedData = $request->validated();
        return $this->adminService->approveAdminUser($adminId, $validatedData);
    }
}
