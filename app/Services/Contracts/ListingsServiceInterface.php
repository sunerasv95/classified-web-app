<?php

namespace app\Services\Contracts;

interface ListingsServiceInterface {

    public function getAllListings();

    public function getListingById($id);
}
