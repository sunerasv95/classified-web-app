<?php

namespace App\Http\Controllers;

use App\Http\Requests\Permission\CreatePermissionRequest;
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

    public function getAll()
    {
        return $this->permissionService->getAllPermissions();
    }

    public function getOne($id)
    {
        return $this->permissionService->getPermissionById($id);
    }

    public function create(CreatePermissionRequest $request)
    {
        $validatedData = $request->validated();
        return $this->permissionService->createPermission($validatedData);
    }

    public function update($id, UpdatePermissionRequest $request)
    {
        $validatedData = $request->validated();
        return $this->permissionService->updatePermissionById($id, $validatedData);
    }

    public function delete($id)
    {
        return $this->permissionService->deletePermissionById($id);
    }
}
