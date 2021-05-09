<?php

namespace App\Services;

use App\Http\Resources\PricingOption\PricingOptionResource;
use App\Repositories\Contracts\PricingOptionRepositoryInterface;
use App\Services\Contracts\PricingOptionServiceInterface;
use App\Traits\ApiResponser;

class PricingOptionService implements PricingOptionServiceInterface
{
    use ApiResponser;

    private $pricingOptionRepository;

    public function __construct(PricingOptionRepositoryInterface $pricingOptionRepository)
    {
        $this->pricingOptionRepository = $pricingOptionRepository;
    }

    public function getAllPricingOptions()
    {
        $pricingOptions = $this->pricingOptionRepository->getAll(array(), array("*"), array());
        return $this->respondWithResource(new PricingOptionResource($pricingOptions), "OK");
    }

    public function getPricingOptionById($id)
    {
        $pricingOption = $this->pricingOptionRepository->getOneById($id, array(), array("*"), array());
        return $this->respondWithResource(new PricingOptionResource($pricingOption), "OK");
    }

    public function createPricingOption(array $data)
    {
        $newPricingOption = $this->pricingOptionRepository->create($data)->toArray();
        if ($newPricingOption) {
            $data = array(
                "success" => true,
                "message" => "Pricing Option created successfully",
                "result" => $newPricingOption
            );
        } else {
            $data = array(
                "success" => false,
                "message" => "Pricing Option creation failed",
                "result" => null
            );
        }

        return $this->respondCreated($data);
    }

    public function updatePricingOptionById($id, array $data)
    {
        $pricingOption = $this->pricingOptionRepository->getOneById($id, array(), array("*"), array());
        $result = $this->pricingOptionRepository->update($pricingOption, $data);

        if ($result > 0) return $this->respondSuccess("Pricing Option updated successfully");
        else return $this->respondInternalError();
    }

    public function deletePricingOptionById($id)
    {
        $pricingOption = $this->pricingOptionRepository->getOneById($id, array(), array("*"), array());
        $updateDeleted = $this->pricingOptionRepository->update($pricingOption, array("is_deleted" => 1));
        $result = $this->pricingOptionRepository->delete($pricingOption);

        if ($updateDeleted && $result) return $this->respondSuccess("Pricing Option deleted successfully");
        else return $this->respondInternalError();
    }
}
