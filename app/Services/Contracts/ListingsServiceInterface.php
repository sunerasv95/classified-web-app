<?php

namespace App\Services\Contracts;

interface ListingsServiceInterface {

    public function getAllListings();

    public function getListingById($id);

    public function createListing(array $data);

    public function updateListingById($id, array $data);

    public function deleteListingById($id);

}
