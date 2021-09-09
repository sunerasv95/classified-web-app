<?php

namespace App\Services;

use App\Enums\Common;
use App\Enums\ErrorCodes;
use App\Enums\SystemStatus;
use App\Http\Resources\Member\AuthenticatedMember;
use App\Repositories\Contracts\MemberRepositoryInterface;
use App\Repositories\Contracts\SocialLoginRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\Contracts\AuthServiceInterface;
use App\Traits\ApiResponser;
use App\Util\Enums;
use App\Util\Messages;
use Illuminate\Support\Facades\DB;

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
    ) {
        $this->userRepository           = $userRepository;
        $this->memberRepository         = $memberRepository;
        $this->socialLoginsRepository   = $socialLoginsRepository;
    }


    public function loginUserWithUsernamePassword(array $payload)
    {
        $email = $password = "";

        try {
            $email      = $payload['email'];
            $password   = $payload['password'];

            $user = $this->userRepository->findByEmail($email);
            if (!isset($user)) return $this->respondUnAuthorized(
                Messages::INVALID_LOGIN,
                ErrorCodes::INVALID_LOGIN
            );

            if (checkHashedPassword($password, $user->password)) {
                $token = $user->createToken(Common::PASSPORT_PASSWORD_GRANT_CLIENT)->accessToken;
                return $this->respondWithAccessToken($token, Messages::OKAY);
            } else {
                return $this->respondUnAuthorized(Messages::INVALID_LOGIN, ErrorCodes::INVALID_LOGIN);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function loginWithSocialProvider(array $payload)
    {
        $email = $provider = $memberId = null;

        $email      = $payload['email'];
        $provider   = $payload['provider'];

        $member = $this->memberRepository->findByEmail($email);
        if (!isset($member)) return $this->respondUnAuthorized(Messages::INVALID_LOGIN, ErrorCodes::INVALID_LOGIN);

        $memberId = $member->id;
        //check social login credentials are exists, and not revoked
        $socialLogin = $this->socialLoginsRepository
            ->getSocialLoginByMemberId($memberId, array("provider" => $provider, "is_revoked" => 0));
        if (!isset($socialLogin)) return $this->respondUnAuthorized(Messages::INVALID_LOGIN, ErrorCodes::INVALID_LOGIN);

        $token = $member->createToken(Common::PASSPORT_PASSWORD_GRANT_CLIENT)->accessToken;
        return $this->respondWithAccessToken($token, Messages::LOGIN_SUCCESS_MESSAGE);
    }

    public function registerMember(array $payload)
    {
        DB::beginTransaction();
        try {
            $memberAttr = $userAttrr = [];

            $memberAttr['first_name']           = $payload['first_name'];
            $memberAttr['last_name']            = $payload['last_name'];
            $memberAttr['member_type_id']       = 1;

            $userAttrr['email']                = $payload['email'];
            $userAttrr['username']             = $payload['username'];
            $userAttrr['user_code']            = $payload['user_code'];
            $userAttrr['password']             = makeHashedPassword($payload['password']);
            $userAttrr['country_code']         = $payload['country_code'];
            $userAttrr['mobile_number']        = $payload['mobile_number'];
            $userAttrr['is_email_verified']    = SystemStatus::NO_STATUS;
            $userAttrr['is_mobile_verified']   = SystemStatus::NO_STATUS;
            $userAttrr['status']               = SystemStatus::NO_STATUS;
            $userAttrr['is_deleted']           = SystemStatus::NOT_DELETED;
            $userAttrr['email_verified_at']    = null;

            $newUser = $this->userRepository->create($userAttrr);

            $memberAttr['user_code'] = $newUser->user_code;
            $this->memberRepository->create($memberAttr);
            $token = $newUser->createToken('Laravel Password Grant Client')->accessToken;

            DB::commit();

            $data = array(
                "success" => true,
                "message" => Messages::CREATED_SUCCESSFULLY,
                "result" => new AuthenticatedMember($newUser, $token)
            );
            return $this->respondCreated($data);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
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

        $member = $this->memberRepository->findByEmail($email);
        if (!isset($member)) return $this->respondUnAuthorized(
            Messages::INVALID_LOGIN,
            ErrorCodes::INVALID_LOGIN
        );

        $memberId = $member->id;
        $socialLogin = $this->socialLoginsRepository
            ->getSocialLoginByMemberId($memberId, array("provider" => $provider, "is_revoked" => 0));
        if (isset($socialLogin)) {
            $token = $member->createToken(Enums::PASSPORT_PASSWORD_GRANT_CLIENT)->accessToken;
            return $this->respondWithAccessToken($token, Messages::LOGIN_SUCCESS_MESSAGE);
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
