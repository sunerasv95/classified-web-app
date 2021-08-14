<?php

namespace App\Services\Contracts;

interface AdminServiceInterface
{
    public function getAllAdminUsers(array $requestParams);

    public function getAdminUserByCode(string $userCode);

    public function getApprovedAdminUserByCode(string $userCode);

    public function filterCategories(array $reqParams);

    public function createAdminUser(array $payload);

    public function updateAdminUser(string $userCode, array $payload);

    public function approveAdminUser(int $userId, array $payload);

}
