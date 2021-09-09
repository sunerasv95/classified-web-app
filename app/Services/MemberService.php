<?php

namespace App\Services;

use App\Enums\Common;
use App\Http\Resources\Member\MemberResource;
use App\Repositories\Contracts\MemberRepositoryInterface;
use App\Services\Contracts\MemberServiceInterface;
use App\Traits\ApiQueryHandler;
use App\Traits\ApiResponser;
use App\Util\Enums;
use App\Enums\ErrorCodes;
use App\Util\Messages;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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

       try {
        $orderby = $this->applySort($reqParams);
        $paginate = $this->applyPagination($reqParams);

        $members = $this->memberRepository->getAll(
            array(),
            array("*"),
            array(),
            $paginate,
            $orderby
        );

        return $this->respondWithResource(
            new MemberResource($members),
            Messages::OKAY
        );
       } catch (\Throwable $th) {
           throw $th;
       }
    }

    public function filterMembers(array $reqParams)
    {
        $keyword = null;
        $filters = $paginate = $orderby = array();

        try {
            $paginate   = $this->applyPagination($reqParams);
        $orderby    = $this->applySort($reqParams);
        $keyword    = $this->applySearchFilter($reqParams);
        $filters    = $this->applyFilters($reqParams, Common::MEMBER_FILTERS);

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
            Messages::OKAY
        );
        } catch (\Throwable $th) {
            throw $th;
        }
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
    //         Messages::RESOURCE_NOT_FOUND,
    //         ErrorCodes::NOT_FOUND
    //     );

    //     return $this->respondWithResource(
    //         new RoleResource($role),
    //         Messages::OKAY
    //     );
    // }

    public function getMemberByCode(string $memberCode)
    {
        try {
            $member = $this->memberRepository->findByMemberCode($memberCode);
        if(empty($member)) return $this->respondNotFound(
            Messages::RESOURCE_NOT_FOUND,
            ErrorCodes::NOT_FOUND
        );

        return $this->respondWithResource(
            new MemberResource($member),
            Messages::OKAY
        );
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    // public function createRole(array $payload)
    // {
    //     $newRole = $this->roleRepository->create($payload);//->createWithRelationships($roleData, $relations);

    //     if ($newRole) {
    //         $data = array(
    //             "success" => true,
    //             "message" => Messages::CREATED_SUCCESSFULLY,
    //             "result" => new RoleResource($newRole)
    //         );
    //         return $this->respondCreated($data);
    //     }

    //     return $this->respondInternalError(
    //         Messages::SERVER_ERROR,
    //         ErrorCodes::SERVER_ERROR
    //     );
    // }

    // public function updateRoleById(int $roleId, array $payload)
    // {
    //     $updateRole = $relations = array();

    //     $role = $this->roleRepository->findById($roleId);
    //     if(!isset($role)) return $this->respondNotFound(
    //         Messages::RESOURCE_NOT_FOUND,
    //         ErrorCodes::NOT_FOUND
    //     );

    //     $roleUpdated = $this->roleRepository
    //         ->updateWithRelationships($role, $updateRole, $relations);

    //     if($roleUpdated > 0) return $this->respondSuccess(Messages::CREATED_SUCCESSFULLY);
    //     else return $this->respondInternalError(
    //         Messages::RESOURCE_UPDATION_FAILED,
    //         ErrorCodes::SERVER_ERROR
    //     );
    // }

    // public function updateRoleWithPermissionsByCode(string $roleCode, array $payload)
    // {
    //     //dd($roleCode, $payload);
    //     $permissions = array();

    //     $role = $this->roleRepository->findByRoleCode($roleCode);
    //     if(!isset($role)) return $this->respondNotFound(
    //         Messages::RESOURCE_NOT_FOUND,
    //         ErrorCodes::NOT_FOUND
    //     );

    //     $roleUpdated = $this->roleRepository->update($role, $payload);
    //     if(!empty($payload['permissions'])){
    //         $permissions = $payload['permissions'];
    //         $this->roleRepository->updateRolePermissions($role, $permissions);
    //     }

    //     if($roleUpdated > 0) return $this->respondSuccess(Messages::UPDATED_SUCCESSFULLY);
    //     else return $this->respondInternalError(
    //         Messages::RESOURCE_UPDATION_FAILED,
    //         ErrorCodes::SERVER_ERROR
    //     );
    // }


    public function updateMemberByCode(string $memberCode, array $payload)
    {
        DB::beginTransaction();
        try {
            if (empty($payload)) return $this->respondInvalidRequestError(
                Messages::INVALID_PAYLOAD,
                ErrorCodes::INVALID_PAYLOAD
            );

            $updateMember = $this->memberRepository->findByMemberCode($memberCode);
            if (empty($updateMember)) return $this->respondNotFound(
                Messages::RESOURCE_NOT_FOUND,
                ErrorCodes::NOT_FOUND
            );

            $result = $this->memberRepository->update($updateMember, $payload);
            if ($result > 0){
                DB::commit();
                return $this->respondSuccess(Messages::UPDATED_SUCCESSFULLY);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

    }


    // public function deleteMemberByMemberCode(string $memberCode)
    // {
    //     $deleteMember = $this->memberRepository->findByMemberCode($memberCode);

    //     if (empty($deleteMember)) return $this->respondNotFound(
    //         Messages::RESOURCE_NOT_FOUND,
    //         ErrorCodes::NOT_FOUND
    //     );

    //     $result = $this->memberRepository->delete($deleteMember);

    //     if ($result > 0) return $this->respondSuccess(Messages::DELETED_SUCCESSFULLY);
    //     else return $this->respondInternalError(
    //         Messages::SERVER_ERROR,
    //         ErrorCodes::SERVER_ERROR
    //     );
    // }

}
