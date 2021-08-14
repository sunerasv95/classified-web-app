<?php

namespace App\Services\Contracts;

interface AdminServiceInterface
{
    public function getAdminUserByCode(string $userCode);
    
    public function getApprovedAdminUserByCode(string $userCode);

    public function createAdminUser(array $payload);

    public function approveAdminUser(int $userId, array $payload);

}
