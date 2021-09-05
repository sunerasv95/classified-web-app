<?php

namespace App\Services;

use App\Http\Resources\Member\MemberResource;
use App\Repositories\Contracts\MemberRepositoryInterface;
use App\Services\Contracts\MemberServiceInterface;
use App\Traits\ApiQueryHandler;
use App\Traits\ApiResponser;
use App\Util\Enums;
use App\Util\ErrorCodes;
use App\Util\HttpMessages;
use Illuminate\Support\Str;

class MemberService implements MemberServiceInterface
{

    use ApiResponser;
    use ApiQueryHandler;

    private $memberRepository;

    public function __construct(MemberRepositoryInterface $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    public function getAllMembers(array $reqParams)
    {
        $paginate = $orderby = [];

        $orderby = $this->applySort($reqParams);
        $paginate = $this->applyPagination($reqParams);

        //dd($paginate, $orderby);

        $members = $this->memberRepository->getAll([],["*"],[],$paginate,$orderby);

        return $this->respondWithResource(
            new MemberResource($members),
            HttpMessages::RESPONSE_OKAY_MESSAGE
        );
    }

    public function filterMembers(array $reqParams)
    {
        $keyword = null;
        $filters = $paginate = $orderby = array();

        $paginate   = $this->applyPagination($reqParams);
        $orderby    = $this->applySort($reqParams);
        $keyword    = $this->applySearchFilter($reqParams);
        $filters    = $this->applyListingFilters($reqParams);

       //dd($filters, $paginate, $orderby, $keyword);

        $roles = $this->memberRepository
            ->applyFilters(
                $keyword,
                $filters,
                array("*"),
                array(),
                $paginate,
                $orderby,
                array()
            );

        return $this->respondWithResource(
            new MemberResource($roles),
            HttpMessages::RESPONSE_OKAY_MESSAGE
        );
    }

    // public function getRoleById(int $roleId)
    // {
    //     $role = $this->roleRepository->findById(
    //         $roleId,
    //         array(),
    //         array("*"),
    //         array("permissions")
    //     );

    //     if(empty($role)) return $this->respondNotFound(
    //         HttpMessages::RESOURCE_NOT_FOUND,
    //         ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
    //     );

    //     return $this->respondWithResource(
    //         new RoleResource($role),
    //         HttpMessages::RESPONSE_OKAY_MESSAGE
    //     );
    // }

    public function getMemberByCode(string $memberCode)
    {
        $member = $this->memberRepository->findByMemberCode($memberCode);

        if(empty($member)) return $this->respondNotFound(
            HttpMessages::RESOURCE_NOT_FOUND,
            ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
        );

        return $this->respondWithResource(
            new MemberResource($member),
            HttpMessages::RESPONSE_OKAY_MESSAGE
        );
    }

    // public function createRole(array $payload)
    // {
    //     $newRole = $this->roleRepository->create($payload);//->createWithRelationships($roleData, $relations);

    //     if ($newRole) {
    //         $data = array(
    //             "success" => true,
    //             "message" => HttpMessages::CREATED_SUCCESSFULLY,
    //             "result" => new RoleResource($newRole)
    //         );
    //         return $this->respondCreated($data);
    //     }

    //     return $this->respondInternalError(
    //         HttpMessages::INTERNAL_SERVER_ERROR,
    //         ErrorCodes::INTERNAL_SERVER_ERROR_CODE
    //     );
    // }

    // public function updateRoleById(int $roleId, array $payload)
    // {
    //     $updateRole = $relations = array();

    //     $role = $this->roleRepository->findById($roleId);
    //     if(!isset($role)) return $this->respondNotFound(
    //         HttpMessages::RESOURCE_NOT_FOUND,
    //         ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
    //     );

    //     $roleUpdated = $this->roleRepository
    //         ->updateWithRelationships($role, $updateRole, $relations);

    //     if($roleUpdated > 0) return $this->respondSuccess(HttpMessages::CREATED_SUCCESSFULLY);
    //     else return $this->respondInternalError(
    //         HttpMessages::RESOURCE_UPDATION_FAILED,
    //         ErrorCodes::INTERNAL_SERVER_ERROR_CODE
    //     );
    // }

    // public function updateRoleWithPermissionsByCode(string $roleCode, array $payload)
    // {
    //     //dd($roleCode, $payload);
    //     $permissions = array();

    //     $role = $this->roleRepository->findByRoleCode($roleCode);
    //     if(!isset($role)) return $this->respondNotFound(
    //         HttpMessages::RESOURCE_NOT_FOUND,
    //         ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
    //     );

    //     $roleUpdated = $this->roleRepository->update($role, $payload);
    //     if(!empty($payload['permissions'])){
    //         $permissions = $payload['permissions'];
    //         $this->roleRepository->updateRolePermissions($role, $permissions);
    //     }

    //     if($roleUpdated > 0) return $this->respondSuccess(HttpMessages::UPDATED_SUCCESSFULLY);
    //     else return $this->respondInternalError(
    //         HttpMessages::RESOURCE_UPDATION_FAILED,
    //         ErrorCodes::INTERNAL_SERVER_ERROR_CODE
    //     );
    // }


    public function updateMemberByCode(string $memberCode, array $payload)
    {
        if (empty($payload)) return $this->respondInvalidRequestError(
            HttpMessages::INVALID_PAYLOAD,
            ErrorCodes::INVALID_PAYLOAD_ERROR_CODE
        );

        $updateMember = $this->memberRepository->findByMemberCode($memberCode);

        if (empty($updateMember)) return $this->respondNotFound(
            HttpMessages::RESOURCE_NOT_FOUND,
            ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
        );

        $result = $this->memberRepository->update($updateMember, $payload);

        if ($result > 0) return $this->respondSuccess(HttpMessages::UPDATED_SUCCESSFULLY);
        else return $this->respondInternalError(
            HttpMessages::INTERNAL_SERVER_ERROR,
            ErrorCodes::INTERNAL_SERVER_ERROR_CODE
        );
    }


    // public function deleteMemberByMemberCode(string $memberCode)
    // {
    //     $deleteMember = $this->memberRepository->findByMemberCode($memberCode);

    //     if (empty($deleteMember)) return $this->respondNotFound(
    //         HttpMessages::RESOURCE_NOT_FOUND,
    //         ErrorCodes::RESOURCE_NOT_FOUND_ERROR_CODE
    //     );

    //     $result = $this->memberRepository->delete($deleteMember);

    //     if ($result > 0) return $this->respondSuccess(HttpMessages::DELETED_SUCCESSFULLY);
    //     else return $this->respondInternalError(
    //         HttpMessages::INTERNAL_SERVER_ERROR,
    //         ErrorCodes::INTERNAL_SERVER_ERROR_CODE
    //     );
    // }

}
