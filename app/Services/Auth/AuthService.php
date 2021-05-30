<?php

namespace App\Services;

use App\Repositories\Contracts\MemberRepositoryInterface;
use App\Repositories\Contracts\SocialLoginRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\AuthServiceInterface;
use App\Traits\ApiResponser;
use App\Util\Enums;
use App\Util\HttpMessages;
use Illuminate\Support\Facades\Http;

class AuthService implements AuthServiceInterface
{

    use ApiResponser;

    private $userRepository;
    private $memberRepository;
    private $socialLoginsRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        MemberRepositoryInterface $memberRepository,
        SocialLoginRepositoryInterface $socialLoginsRepository
    )
    {
        $this->userRepository           = $userRepository;
        $this->memberRepository         = $memberRepository;
        $this->socialLoginsRepository   = $socialLoginsRepository;
    }


    public function loginUserWithUsernamePassword(array $payload)
    {
        $email = $password = "";

        $email = $payload['email'];
        $password = $payload['password'];

        $user = $this->memberRepository->getMemberByEmail($email); //todo: check whether user account is active/blocked/not email verified
        if(!isset($user)) return $this->respondUnAuthorized(HttpMessages::NOT_FOUND_USER_WITH_EMAIL_USERNAME_MESSAGE);

        if(checkHashedPassword($password, $user->password)) {
            $token = $user->createToken(Enums::PASSPORT_CLIENT)->accessToken;
            $data = array(
                "success" => true,
                "message" => HttpMessages::LOGIN_SUCCESS_MESSAGE,
                "result" => [
                    "access_token" => $token
                ]
            );
            return $this->respondCreated($data);
        }else {
            return $this->respondUnAuthorized(HttpMessages::PASSWORDS_MISMATCHED_MESSAGE);
        }
    }

    public function loginWithSocialProvider(array $payload)
    {
        $email = $provider = $memberId = null;

        $email      = $payload['email'];
        $provider   = $payload['provider'];

        //check member exists
        $member = $this->memberRepository->getMemberByEmail($email);
        if(!isset($member)) return $this->respondUnAuthorized(HttpMessages::NOT_FOUND_USER_WITH_EMAIL_USERNAME_MESSAGE);

        $memberId = $member->id;
        //check social login credentials are exists, and not revoked
        $socialLogin = $this->socialLoginsRepository->getSocialLoginByMemberId($memberId, array("provider"=>$provider, "is_revoked" => 0));
        if(!isset($socialLogin)) return $this->respondUnAuthorized(HttpMessages::LOGIN_FAILED_MESSAGE);

        $token = $member->createToken(Enums::PASSPORT_CLIENT)->accessToken;
        $data = array(
            "success" => true,
            "message" => HttpMessages::LOGIN_SUCCESS_MESSAGE,
            "result" => [
                "access_token" => $token
            ]
        );
        return $this->respondCreated($data);
    }


    public function registerMemberWithUsernamePassword(array $payload)
    {
        $email = $username = null;
        $memberData = array();

        $memberData['first_name']       = $payload['first_name'];
        $memberData['last_name']        = $payload['last_name'];
        $memberData['email']            = $payload['email'];
        $memberData['username']         = $payload['email']; //todo: make unique name with email and validate if it exists
        $memberData['password']         = makeHashedPassword($payload['password']);
        $memberData['avatar_url']       = $payload['avatar'];
        $memberData['member_type_id']   = Enums::REGULAR_MEMBER_TYPE;
        $memberData['is_active']        = Enums::STATUS_ACTIVE;
        $memberData['is_blocked']       = Enums::NOT_BLOCKED;
        $memberData['is_deleted']       = Enums::NOT_DELETED;

        $newMember = $this->memberRepository->create($memberData);
        return $this->respondSuccess(HttpMessages::REGISTER_SUCCESS_MESSAGE);
    }


    public function registerMemberWithSocialProvider(array $payload)
    {
        $memberData = $socialAuthData =  $relationhips = array();
        $email = $memberId = $provider = null;

        //check if email is exists in the system
        //if yes, log in user
        //if no, register as new user

        $email      = $payload['email'];
        $provider   = $payload['provider'];

        $member = $this->memberRepository->getMemberByEmail($email);
        if(!isset($member)) return $this->respondUnAuthorized(HttpMessages::NOT_FOUND_USER_WITH_EMAIL_USERNAME_MESSAGE);

        $memberId = $member->id;
        $socialLogin = $this->socialLoginsRepository->getSocialLoginByMemberId($memberId, array("provider"=>$provider, "is_revoked" => 0));
        if(isset($socialLogin)) {
            $token = $member->createToken(Enums::PASSPORT_CLIENT)->accessToken;
            $data = array(
                "success" => true,
                "message" => HttpMessages::LOGIN_SUCCESS_MESSAGE,
                "result" => [
                    "access_token" => $token
                ]
            );
            return $this->respondCreated($data);
        }

        $memberData['first_name']       = $payload['first_name'];
        $memberData['last_name']        = $payload['last_name'];
        $memberData['email']            = $payload['email'];
        $memberData['username']         = $payload['email']; //todo: make unique name with email and validate if it exists
        $memberData['password']         = "";
        $memberData['avatar_url']       = $payload['avatar'];
        $memberData['member_type_id']   = Enums::REGULAR_MEMBER_TYPE;
        $memberData['is_active']        = Enums::STATUS_ACTIVE;
        $memberData['is_blocked']       = Enums::NOT_BLOCKED;
        $memberData['is_deleted']       = Enums::NOT_DELETED;

        $socialAuthData['provider']     = $payload['provider'];
        $socialAuthData['provider_id']  = $payload['provider_id'];
        $socialAuthData['is_revoked']   = Enums::NOT_REVOKED;

        $relationhips['social_provider'] = $socialAuthData;

        $newMember = $this->memberRepository->createWithRelationships($memberData, $relationhips);
        return $newMember;
    }
}
