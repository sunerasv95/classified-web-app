<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\GetRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Services\Contracts\RoleServiceInterface;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private $roleService;

    public function __construct(RoleServiceInterface $roleService)
    {
        $this->roleService = $roleService;
    }

    public function getAll(GetRoleRequest $request)
    {
        $validatedData = $request->validated();
        return $this->roleService->getAllRoles($validatedData);
    }

    public function getOne(string $roleCode)
    {
        return $this->roleService->getRoleByCode($roleCode);
    }

    public function search(GetRoleRequest $request)
    {
        $validatedData = $request->validated();
        return $this->roleService->filterRoles($validatedData);
    }

    public function create(CreateRoleRequest $request)
    {
        $validatedData = $request->validated();
        return $this->roleService->createRole($validatedData);
    }

    public function update(string $roleCode, UpdateRoleRequest $request)
    {
        $validatedData = $request->validated();
        return $this->roleService->updateRoleWithPermissionsByCode($roleCode, $validatedData);
    }

    public function delete(string $roleCode)
    {
        return $this->roleService->deleteRoleByCode($roleCode);
    }
}
