<?php

namespace App\Services\Contracts;

interface AuthServiceInterface {

    public function loginUser(array $payload);

    public function registerUserWithUsernamePassword(array $payload);

}
