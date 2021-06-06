<?php

namespace App\Services;

use App\Repositories\Contracts\AdminRepositoryInterface;
use App\Services\Contracts\AdminAuthServiceInterface;
use App\Traits\ApiResponser;
use App\Util\Enums;
use App\Util\HttpMessages;

class AdminAuthService implements AdminAuthServiceInterface
{

    use ApiResponser;

    private $adminRepository;

    public function __construct(
        AdminRepositoryInterface $adminRepository
    )
    {
        $this->adminRepository  = $adminRepository;
    }


    public function loginAdminWithUsernamePassword(array $payload)
    {
        $email = $password = "";

        $email      = $payload['email'];
        $password   = $payload['password'];

        $adminUser = $this->adminRepository->getAdminByEmail($email); //todo: check whether user account is active/blocked/not email verified
        if(!isset($adminUser)) return $this->respondUnAuthorized(HttpMessages::NOT_FOUND_USER_WITH_EMAIL_USERNAME_MESSAGE);

        if(checkHashedPassword($password, $adminUser->password)) {
            $token = $adminUser->createToken(Enums::PASSPORT_CLIENT)->accessToken;
            return $this->respondWithAccessToken($token, HttpMessages::LOGIN_SUCCESS_MESSAGE);

        }else {
            return $this->respondUnAuthorized(HttpMessages::PASSWORDS_MISMATCHED_MESSAGE);
        }
    }
}
