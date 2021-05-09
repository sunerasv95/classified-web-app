<?php

namespace App\Http\Controllers;

use App\Http\Requests\PricingOption\CreateOptionRequest;
use App\Http\Requests\PricingOption\UpdateOptionRequest;
use App\Services\Contracts\PricingOptionServiceInterface;
use Illuminate\Http\Request;

class PricingOptionsController extends Controller
{
    private $pricingOptionService;

    public function __construct(PricingOptionServiceInterface $pricingOptionService)
    {
        $this->pricingOption = $pricingOptionService;
    }

    public function getAll()
    {
        return $this->pricingOption->getAllPricingOptions();
    }

    public function getOne($id)
    {
        return $this->pricingOption->getPricingOptionById($id);
    }

    public function create(CreateOptionRequest $request)
    {
        $validatedData = $request->validated();
        return $this->pricingOption->createPricingOption($validatedData);
    }

    public function updateOne($id, UpdateOptionRequest $request)
    {
        $validatedData = $request->validated();
        return $this->pricingOption->updatePricingOptionById($id, $validatedData);
    }

    public function deleteOne($id)
    {
        return $this->pricingOption->deletePricingOptionById($id);
    }
}
