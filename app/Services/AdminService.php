<?php

namespace App\Services;

use App\Http\Resources\Admin\AdminAuthResource;
use App\Http\Resources\Admin\AdminResource;
use App\Http\Resources\Brand\BrandResource;
use App\Repositories\Contracts\AdminRepositoryInterface;
use App\Services\Contracts\BrandServiceInterface;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Services\Contracts\AdminServiceInterface;
use App\Traits\ApiResponser;
use App\Util\Enums;
use App\Util\ErrorCodes;
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

    public function getAllAdminUsers(array $reqParams)
    {
        $paginate =  $orderby = array();
        //dd($reqParams);
        if (
            isset($reqParams[Enums::SORT_QUERY_PARAM]) &&
            isset($reqParams[Enums::SORT_ORDER_QUERY_PARAM])
        ) {
            $orderby[Enums::SORT_QUERY_PARAM]       = $reqParams[Enums::SORT_QUERY_PARAM];
            $orderby[Enums::SORT_ORDER_QUERY_PARAM] = $reqParams[Enums::SORT_ORDER_QUERY_PARAM];
        }
        if (
            isset($reqParams[Enums::LIMIT_QUERY_PARAM]) &&
            isset($reqParams[Enums::OFFSET_QUERY_PARAM])
        ) {
            $paginate[Enums::LIMIT_QUERY_PARAM]  = $reqParams[Enums::LIMIT_QUERY_PARAM];
            $paginate[Enums::OFFSET_QUERY_PARAM] = $reqParams[Enums::OFFSET_QUERY_PARAM];
        }

        $adminUsers = $this->adminRepository
            ->getAll(
                array(),
                array("*"),
                array("role:id,name"),
                $paginate,
                $orderby
            );

        return $this->respondWithResource(
            new AdminResource($adminUsers),
            HttpMessages::RESPONSE_OKAY_MESSAGE
        );
    }

    public function getAdminUserByCode(string $userCode)
    {
        $adminUser = null;
        //dd($userCode);
        $adminUser = $this->adminRepository
            ->findByUserCode(
                $userCode,
                array(),
                array("*"),
                array("role")
            );
        //dd($adminUser);
        if(empty($adminUser)) return $this->respondNotFound(
            HttpMessages::NOT_FOUND_USER_MESSAGE,
            ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
        );

        return $this->respondWithResource(
            new AdminResource($adminUser),
            HttpMessages::RESPONSE_OKAY_MESSAGE
        );
    }

    public function getApprovedAdminUserByCode(string $userCode)
    {
        $adminUser = null;
        //dd($userCode);
        $adminUser = $this->adminRepository
            ->findByUserCode(
                $userCode,
                array("is_approved" => 1),
                array("*"),
                array("role:id,name", "role.permissions:id,slug")
            );
        //dd($adminUser);
        if(empty($adminUser)) return $this->respondNotFound(
            HttpMessages::NOT_FOUND_USER_MESSAGE,
            ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
        );

        return $this->respondWithResource(
            new AdminAuthResource($adminUser),
            HttpMessages::RESPONSE_OKAY_MESSAGE
        );
    }

    public function filterCategories(array $reqParams)
    {
        //dd($reqParams);
        $keyword = null;
        $filters = $paginate = $orderby = array();

        if (isset($reqParams[Enums::SEARCH_QUERY_PARAM])) {
            $keyword = $reqParams[Enums::SEARCH_QUERY_PARAM];
        }
        if (isset($reqParams[Enums::ADMIN_IS_ACTIVE_PARAM])) {
            $filters["is_active"] = $reqParams[Enums::ADMIN_IS_ACTIVE_PARAM];
        }
        if (isset($reqParams[Enums::ADMIN_ROLE_PARAM])) {
            $filters["role_id"] = $reqParams[Enums::ADMIN_ROLE_PARAM];
        }
        if (isset($reqParams[Enums::SORT_QUERY_PARAM]) &&
            isset($reqParams[Enums::SORT_ORDER_QUERY_PARAM])
        ) {
            $orderby[Enums::SORT_QUERY_PARAM]       = $reqParams[Enums::SORT_QUERY_PARAM];
            $orderby[Enums::SORT_ORDER_QUERY_PARAM] = $reqParams[Enums::SORT_ORDER_QUERY_PARAM];
        }
        if (isset($reqParams[Enums::LIMIT_QUERY_PARAM]) &&
            isset($reqParams[Enums::OFFSET_QUERY_PARAM])
        ) {
            $paginate[Enums::LIMIT_QUERY_PARAM]  = $reqParams[Enums::LIMIT_QUERY_PARAM];
            $paginate[Enums::OFFSET_QUERY_PARAM] = $reqParams[Enums::OFFSET_QUERY_PARAM];
        }

        $adminUsers = $this->adminRepository
            ->applyFilters(
                $keyword,
                $filters,
                array("*"),
                array("role:id,name"),
                $paginate,
                $orderby,
                array()
            );

        return $this->respondWithResource(
            new AdminResource($adminUsers),
            HttpMessages::RESPONSE_OKAY_MESSAGE
        );
    }

    public function createAdminUser(array $payload)
    {
        $adminUser = $email = null;
        $adminData = array();

        $email = $payload['email'];

        $adminUser = $this->adminRepository->findByEmail($email);
        if(!empty($adminUser)) return $this->respondResourceAlreadyExistsError(
            HttpMessages::EMAIL_IS_ALREADY_EXISTS,
            ErrorCodes::RESOURCE_EXISTS_ERROR_CODE
        );

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

    public function updateAdminUser(string $userCode, array $payload)
    {
        if(empty($payload)) return $this->respondInvalidRequestError(
            HttpMessages::BAD_REQUEST,
            ErrorCodes::BAD_REQUEST
        );

        $adminUser = $this->adminRepository
            ->findByUserCode(
                $userCode,
                array("is_approved" => 1),
                array("*"),
                array("role:id,name", "role.permissions:id,slug")
            );

        $result = $this->adminRepository->update($adminUser, $payload);

        if ($result > 0) return $this->respondSuccess(HttpMessages::UPDATED_SUCCESSFULLY);
        else return $this->respondInternalError(null, ErrorCodes::INTERNAL_SERVER_ERROR_CODE);
    }


    public function approveAdminUser(int $userId, array $payload)
    {
        $approvalData = array();
        $adminUser = $approvedByUser = null;

        $approvedByUser = $payload['approved_user_id'];
        if($userId === $approvedByUser) return $this->respondInvalidRequestError(
            HttpMessages::APPROVAL_REJECTED,
            ErrorCodes::INVALID_REQUEST
        );

        $adminUser = $this->adminRepository->findById($userId, array("is_approved" => 0, "role_id" => 0));
        if(empty($adminUser)) return $this->respondNotFound(
            HttpMessages::NOT_FOUND_USER_MESSAGE,
            ErrorCodes::INVALID_REQUEST
        );

        $approvalData['is_approved']    = Enums::APPROVED_YES;
        $approvalData['approved_date']  = getCurrentDateTime();
        $result = $this->adminRepository->update($adminUser, $approvalData);

        if($result > 0) return $this->respondSuccess(HttpMessages::SUCCESSFULLY_APPROVED_MESSAGE);
        else return $this->respondInternalError(null, ErrorCodes::INTERNAL_SERVER_ERROR_CODE);
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
