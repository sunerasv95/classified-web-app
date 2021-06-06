<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\CreateRoleRequest;
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

    public function getAll()
    {
        return $this->roleService->getAllRoles();
    }

    public function getOne($id)
    {
        return $this->roleService->getRoleById($id);
    }

    public function create(CreateRoleRequest $request)
    {
        $validatedData = $request->validated();
        return $this->roleService->createRole($validatedData);
    }

    public function update($id, UpdateRoleRequest $request)
    {
        $validatedData = $request->validated();
        return $this->roleService->updateRoleById($id, $validatedData);
    }

    public function delete($id)
    {
        return $this->roleService->deleteRoleById($id);
    }
}
