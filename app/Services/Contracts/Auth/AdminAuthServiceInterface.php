<?php

namespace App\Services\Contracts;

interface AdminAuthServiceInterface {

    public function loginAdminWithUsernamePassword(array $payload);

}
