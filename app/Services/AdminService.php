<?php

namespace App\Services;

use App\Http\Resources\Admin\AdminResource;
use App\Http\Resources\Brand\BrandResource;
use App\Repositories\Contracts\AdminRepositoryInterface;
use App\Services\Contracts\BrandServiceInterface;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Services\Contracts\AdminServiceInterface;
use App\Traits\ApiResponser;
use App\Util\Enums;
use App\Util\HttpMessages;
use Illuminate\Support\Facades\Http;

class AdminService implements AdminServiceInterface
{

    use ApiResponser;

    private $adminRepository;

    public function __construct(AdminRepositoryInterface $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function getAdminUserByCode(string $userCode)
    {
        $adminUser = null;
        //dd($userCode);
        $adminUser = $this->adminRepository
            ->getAdminByUserCode(
                $userCode,
                array(),
                array("*"),
                array("role")
            );
        //dd($adminUser);
        if(empty($adminUser)) return $this->respondNotFound(HttpMessages::NOT_FOUND_USER_MESSAGE);

        return $this->respondWithResource(new AdminResource($adminUser), HttpMessages::RESPONSE_OKAY_MESSAGE);
    }

    public function getApprovedAdminUserByCode(string $userCode)
    {
        $adminUser = null;
        //dd($userCode);
        $adminUser = $this->adminRepository
            ->getAdminByUserCode(
                $userCode,
                array("is_approved" => 1),
                array("*"),
                array("role:id,name", "role.permissions:id,slug")
            );
        //dd($adminUser);
        if(empty($adminUser)) return $this->respondNotFound(HttpMessages::NOT_FOUND_USER_MESSAGE);

        return $this->respondWithResource(new AdminResource($adminUser), HttpMessages::RESPONSE_OKAY_MESSAGE);
    }

    public function createAdminUser(array $payload)
    {
        $adminUser = $email = null;
        $adminData = array();

        $email = $payload['email'];

        $adminUser = $this->adminRepository->getAdminByEmail($email);
        if(empty($adminUser)) return $this->respondResourceAlreadyExistsError(HttpMessages::EMAIL_IS_ALREADY_EXISTS);

        $adminData['name']              = $payload['name'];
        $adminData['email']             = $email;
        $adminData['user_code']         = Enums::ADMIN_CODE_PREFIX. rand(1000, 5000);
        $adminData['role_id']           = $payload['role_id'];
        $adminData['is_email_verified'] = Enums::STATUS_NO;
        $adminData['password']          = makeHashedPassword($payload['password']);
        $adminData['is_approved']       = Enums::STATUS_NO;
        $adminData['is_active']         = Enums::STATUS_NO;
        $adminData['is_blocked']        = Enums::NOT_BLOCKED;
        $adminData['is_deleted']        = Enums::NOT_DELETED;

        $this->adminRepository->create($adminData);
        return $this->respondSuccess(HttpMessages::CREATED_SUCCESS_MESSAGE);
    }

    public function approveAdminUser(int $userId, array $payload)
    {
        $approvalData = array();
        $adminUser = $approvedByUser = null;

        $approvedByUser = $payload['approved_user_id'];
        if($userId === $approvedByUser) return $this->respondInvalidRequestError(HttpMessages::APPROVAL_REJECTED);

        $adminUser = $this->adminRepository->getAdminById($userId, array("is_approved" => 0, "role_id" => 0));
        if(empty($adminUser)) return $this->respondNotFound(HttpMessages::NOT_FOUND_USER_MESSAGE);

        $approvalData['is_approved']    = Enums::APPROVED_YES;
        $approvalData['approved_date']  = getCurrentDateTime();
        $result = $this->adminRepository->update($adminUser, $approvalData);

        if($result > 0) return $this->respondSuccess(HttpMessages::SUCCESSFULLY_APPROVED_MESSAGE);
        else return $this->respondInternalError();
    }


    // public function checkAdminUserStatus(array $user)
    // {

    //     switch($user){
    //         case($user['is_approved'] == 1):
    //             return $this->respondInvalidRequestError(HttpMessages::ALREADY_APPROVED_USER_MESSAGE);
    //         case($user['is_blocked'] == 1):
    //                 return $this->respondInvalidRequestError(HttpMessages::ALREADY_APPROVED_USER_MESSAGE);
    //     }
    // }

}
