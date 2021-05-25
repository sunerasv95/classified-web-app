<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\AuthServiceInterface;
use App\Traits\ApiResponser;

class AuthService implements AuthServiceInterface
{

    use ApiResponser;

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function loginUser(array $payload)
    {
        $email = $password = "";

        $email = $payload['email'];
        $password = $payload['password'];

        $user = $this->userRepository->getUserByEmail($email);
        if(!isset($user)){
            return $this->respondUnAuthorized("No user with that email/username");
        }

        if(checkHashedPassword($password, $user->password)) {
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            $data = array(
                "success" => true,
                "message" => "Login Successfully",
                "result" => [
                    "access_token" => $token
                ]
            );
            return $this->respondCreated($data);
        }else {
            return $this->respondUnAuthorized("Password doesn't matched");
        }
    }

    public function registerUserWithUsernamePassword(array $payload)
    {
        $hashedPassword = makeHashedPassword($payload['password']);
        $payload['password'] =  $hashedPassword;

        $newUser = $this->userRepository->create($payload);
        return $newUser;
    }

}
