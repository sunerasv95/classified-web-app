<?php

namespace App\Services\Contracts;

interface AdminServiceInterface {

    public function createAdminUser(array $payload);

    public function approveAdminUser(int $userId, array $payload);

}
