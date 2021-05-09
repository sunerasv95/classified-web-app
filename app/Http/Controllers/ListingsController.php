<?php

namespace App\Http\Controllers;

use app\Services\Contracts\ListingsServiceInterface;
use App\Http\Requests\Listing\CreateListingRequest;
use App\Http\Requests\Listing\UpdateListingRequest;

class ListingsController extends Controller
{
    private $listingService;

    public function __construct(ListingsServiceInterface $listingService)
    {
        $this->listingService = $listingService;
    }

    public function getAll()
    {
        return $this->listingService->getAllListings();
    }

    public function getOne($listingId)
    {
        return $this->listingService->getListingById($listingId);
    }

    public function create(CreateListingRequest $request)
    {
        $validatedData = $request->validated();
        return $this->listingService->createListing($validatedData);
    }

    public function updateOne($id, UpdateListingRequest $request)
    {
        $validatedData = $request->validated();
        return $this->listingService->updateListingById($id, $validatedData);
    }

    public function deleteOne($id)
    {
        return $this->listingService->deleteListingById($id);
    }
}
