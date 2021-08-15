<?php

namespace App\Http\Controllers;

use App\Http\Requests\Permission\CreatePermissionRequest;
use App\Http\Requests\Permission\GetPermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use App\Services\Contracts\PermissionServiceInterface;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    private $permissionService;

    public function __construct(PermissionServiceInterface $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function getAll(GetPermissionRequest $request)
    {
        $validatedData = $request->validated();
        return $this->permissionService->getAllPermissions($validatedData);
    }

    public function getOne(string $permissionCode)
    {
        return $this->permissionService->getPermissionByCode($permissionCode);
    }

    public function search(GetPermissionRequest $request)
    {
        $validatedData = $request->validated();
        return $this->permissionService->filterPermissions($validatedData);
    }

    public function create(CreatePermissionRequest $request)
    {
        $validatedData = $request->validated();
        return $this->permissionService->createPermission($validatedData);
    }

    public function update(string $permissionCode, UpdatePermissionRequest $request)
    {
        $validatedData = $request->validated();
        return $this->permissionService->updatePermissionByCode($permissionCode, $validatedData);
    }

    public function delete($permissionCode)
    {
        return $this->permissionService->deletePermissionById($permissionCode);
    }
}
