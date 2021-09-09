<?php

namespace App\Services;

use App\Http\Resources\Admin\AdminAuthResource;
use App\Http\Resources\Admin\AdminResource;
use App\Repositories\Contracts\AdminRepositoryInterface;
use App\Services\Contracts\AdminServiceInterface;
use App\Traits\ApiResponser;
use App\Util\Enums;
use App\Enums\ErrorCodes;
use App\Enums\SystemStatus;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Util\Messages;
use Illuminate\Support\Facades\DB;

class AdminService implements AdminServiceInterface
{

    use ApiResponser;

    private $adminRepository;
    private $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository,
        AdminRepositoryInterface $adminRepository
    )
    {
        $this->adminRepository  = $adminRepository;
        $this->userRepository   = $userRepository;
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
            Messages::OKAY
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
            Messages::NOT_FOUND_USER_MESSAGE,
            ErrorCodes::NOT_FOUND
        );

        return $this->respondWithResource(
            new AdminResource($adminUser),
            Messages::OKAY
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
            Messages::NOT_FOUND_USER_MESSAGE,
            ErrorCodes::NOT_FOUND
        );

        return $this->respondWithResource(
            new AdminAuthResource($adminUser),
            Messages::OKAY
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
            Messages::OKAY
        );
    }

    public function createAdminUser(array $payload)
    {
        $adminUser = $email = null;
        $userAttr = $adminAttr =  [];
        DB::beginTransaction();
        try {
            $email = $payload['email'];
            $adminUser = $this->userRepository->findByEmail($email, ['is_top_level_user' => 1]);
            //dd($adminUser);
            if (isset($adminUser)) return $this->respondResourceAlreadyExistsError(
                Messages::RESOURCE_EXISTS,
                ErrorCodes::ALREADY_EXISTS
            );

            $adminAttr['first_name']          = $payload['first_name'];
            $adminAttr['last_name']           = $payload['last_name'];
            $adminAttr['role_id']             = 1;

            $userAttr['email']                = $payload['email'];
            $userAttr['username']             = $payload['username'];
            $userAttr['user_code']            = $payload['user_code'];
            $userAttr['password']             = makeHashedPassword($payload['password']);
            $userAttr['is_top_level_user']    = SystemStatus::YES_STATUS;
            $userAttr['is_email_verified']    = SystemStatus::NO_STATUS;
            $userAttr['status']               = SystemStatus::NO_STATUS;
            $userAttr['is_deleted']           = SystemStatus::NOT_DELETED;
            $userAttr['email_verified_at']    = null;

            $newUser = $this->userRepository->create($userAttr);

            $adminAttr['user_code'] = $newUser->user_code;
            $this->adminRepository->create($adminAttr);

            DB::commit();
            return $this->respondSuccess(Messages::SUCCESS);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function updateAdminUser(string $userCode, array $payload)
    {
        if(empty($payload)) return $this->respondInvalidRequestError(
            Messages::BAD_REQUEST,
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

        if ($result > 0) return $this->respondSuccess(Messages::UPDATED_SUCCESSFULLY);
        else return $this->respondInternalError(null, ErrorCodes::SERVER_ERROR);
    }


    public function approveAdminUser(int $userId, array $payload)
    {
        $approvalData = array();
        $adminUser = $approvedByUser = null;

        $approvedByUser = $payload['approved_user_id'];
        if($userId === $approvedByUser) return $this->respondInvalidRequestError(
            Messages::APPROVAL_REJECTED,
            ErrorCodes::INVALID_REQUEST
        );

        $adminUser = $this->adminRepository->findById($userId, array("is_approved" => 0, "role_id" => 0));
        if(empty($adminUser)) return $this->respondNotFound(
            Messages::NOT_FOUND_USER_MESSAGE,
            ErrorCodes::INVALID_REQUEST
        );

        $approvalData['is_approved']    = Enums::APPROVED_YES;
        $approvalData['approved_date']  = getCurrentDateTime();
        $result = $this->adminRepository->update($adminUser, $approvalData);

        if($result > 0) return $this->respondSuccess(Messages::SUCCESSFULLY_APPROVED_MESSAGE);
        else return $this->respondInternalError(null, ErrorCodes::SERVER_ERROR);
    }


    // public function checkAdminUserStatus(array $user)
    // {

    //     switch($user){
    //         case($user['is_approved'] == 1):
    //             return $this->respondInvalidRequestError(Messages::ALREADY_APPROVED_USER_MESSAGE);
    //         case($user['is_blocked'] == 1):
    //                 return $this->respondInvalidRequestError(Messages::ALREADY_APPROVED_USER_MESSAGE);
    //     }
    // }

}
