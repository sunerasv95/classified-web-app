<?php

namespace App\Services\Contracts;

interface RoleServiceInterface {

    public function getAllRoles();

    public function getRoleById(int $roleId);

    public function createRole(array $payload);

    public function updateRoleById(int $roleId, array $payload);

    public function deleteRoleById(int $id);

}
