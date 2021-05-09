<?php

namespace App\Services\Contracts;

interface PricingOptionServiceInterface {

    public function getAllPricingOptions();

    public function getPricingOptionById($id);

    public function createPricingOption(array $data);

    public function updatePricingOptionById($id, array $data);

    public function deletePricingOptionById($id);

}
