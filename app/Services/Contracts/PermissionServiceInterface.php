<?php

namespace App\Services\Contracts;

interface PermissionServiceInterface {

    public function getAllPermissions();

    public function getPermissionById(int $permissionId);

    public function createPermission(array $payload);

    public function updatePermissionById(int $permissionId, array $payload);

    public function deletePermissionById(int $id);

}
