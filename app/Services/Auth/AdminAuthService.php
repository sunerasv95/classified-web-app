<?php

namespace App\Services;

use App\Http\Resources\Admin\AdminAuthResource;
use App\Http\Resources\Admin\AdminResource;
use App\Models\Role;
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
        //dd(Role::find(1)->permissions()->get()->toArray());
        if (!isset($adminUser)) return $this->respondUnAuthorized(HttpMessages::INVALID_LOGIN_CREDENTIALS);

        if (checkHashedPassword($password, $adminUser->password)) {
            $token = $adminUser->createToken(Enums::PASSPORT_PASSWORD_GRANT_CLIENT)->accessToken;
            return $this->respondWithAccessToken($token, HttpMessages::LOGIN_SUCCESS_MESSAGE);
            // if (!$adminUser->is_active) return $this->respondUnAuthorized(HttpMessages::NOT_ACTIVATEDD_USER_MESSAGE);
            // elseif (!$adminUser->is_approved) return $this->respondUnAuthorized(HttpMessages::NOT_APPROVED_USER_MESSAGE);
            // elseif ($adminUser->is_blocked) return $this->respondUnAuthorized(HttpMessages::BLOCKED_USER_MESSAGE);
            // else return $this->respondWithResource(new AdminAuthResource($adminUser), HttpMessages::RESPONSE_OKAY_MESSAGE);
        } else {
            return $this->respondUnAuthorized(HttpMessages::INVALID_LOGIN_CREDENTIALS);
        }
    }
}
