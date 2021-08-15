<?php

namespace App\Services\Contracts;

interface PermissionServiceInterface {

    public function getAllPermissions(array $reqParams);

    public function filterPermissions(array $reqParams);

    public function getPermissionById(int $permissionId);

    public function getPermissionByCode(string $permissionCode);

    public function createPermission(array $payload);

    public function updatePermissionById(int $permissionId, array $payload);

    public function updatePermissionByCode(string $permissionCode, array $payload);

    public function deletePermissionById(int $id);

}
