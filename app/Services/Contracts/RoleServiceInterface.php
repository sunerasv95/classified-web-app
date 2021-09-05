<?php

namespace App\Services\Contracts;

interface RoleServiceInterface
{

    public function getAllRoles(array $reqParams);

    public function filterRoles(array $reqParams);

    public function getRoleById(int $roleId);

    public function getRoleByCode(string $roleCode);

    public function createRole(array $payload);

    //public function updateRoleById(int $roleId, array $payload);

    public function updateRoleWithPermissionsByCode(string $roleCode, array $payload);

    public function deleteRoleByCode(string $roleCode);

}
