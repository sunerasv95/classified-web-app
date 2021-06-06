<?php

namespace App\Services;

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

    public function createAdminUser(array $payload)
    {
        $email = null;
        $adminData = array();

        $email = $payload['email'];

        $adminUser = $this->adminRepository->getAdminByEmail($email);
        if(isset($adminUser)) return $this->respondResourceAlreadyExistsError(HttpMessages::EMAIL_IS_ALREADY_EXISTS);

        $adminData['name']              = $payload['name'];
        $adminData['email']             = $email;
        $adminData['role_id']           = 0;
        $adminData['is_email_verified'] = Enums::STATUS_NO;
        $adminData['password']          = makeHashedPassword($payload['password']);
        $adminData['is_approved']       = Enums::STATUS_NO;
        $adminData['is_active']         = Enums::STATUS_NO;
        $adminData['is_blocked']        = Enums::NOT_BLOCKED;
        $adminData['is_deleted']        = Enums::NOT_DELETED;

        $this->adminRepository->create($adminData);
        return $this->respondSuccess(HttpMessages::CREATED_SUCCESS_MESSAGE);
    }


}
