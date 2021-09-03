<?php

namespace App\Services\Contracts;

interface ListingsServiceInterface {

    public function getAllListings(array $reqParams);

    public function filterListings(array $reqParams);

    public function getListingById(int $id);

    public function getListingBySlug(string $slug);

    public function createListing(array $payload);

    public function updateListingByReferenceId(string $referenceId, array $payload);

    // public function deleteListingById(int $id);

    public function deleteListingByReferenceId(string $referenceId);

}
