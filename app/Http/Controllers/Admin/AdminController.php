<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ApproveAdminUserRequest;
use App\Http\Requests\Admin\CreateAdminRequest;
use App\Http\Requests\Admin\FilterAdminRequest;
use App\Http\Requests\Admin\GetAdminUserRequest;
use App\Http\Requests\Admin\GetAllAdminUsers;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Services\Contracts\AdminServiceInterface;

class AdminController extends Controller
{
    private $adminService;

    public function __construct(AdminServiceInterface $adminService)
    {
        $this->adminService = $adminService;
    }

    public function getAll(GetAllAdminUsers $request)
    {
        $validatedData = $request->validated();
        return $this->adminService->getAllAdminUsers($validatedData);
    }

    public function getOne($userCode, GetAdminUserRequest $request)
    {
        $validatedData = $request->validated();
        if(isset($validatedData['approved']) && $validatedData['approved'] == 1) {
            return $this->adminService->getApprovedAdminUserByCode($userCode);
        }
        return $this->adminService->getAdminUserByCode($userCode);
    }

    public function search(FilterAdminRequest $request)
    {
        $validatedData = $request->validated();
        return $this->adminService->filterCategories($validatedData);
    }

    public function create(CreateAdminRequest $request)
    {
        $validatedData = $request->validated();
        return $this->adminService->createAdminUser($validatedData);
    }

    public function update(string $userCode, UpdateAdminRequest $request)
    {
        $validatedData = $request->validated();
        return $this->adminService->updateAdminUser($userCode, $validatedData);
    }

    public function approveAdminUser($adminId, ApproveAdminUserRequest $request)
    {
        $validatedData = $request->validated();
        return $this->adminService->approveAdminUser($adminId, $validatedData);
    }
}
