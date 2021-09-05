<?php

namespace App\Services\Contracts;

interface AuthServiceInterface {

    public function loginUserWithUsernamePassword(array $payload);

    public function loginWithSocialProvider(array $payload);

    public function registerMember(array $payload);

    public function registerMemberWithSocialProvider(array $payload);

}
