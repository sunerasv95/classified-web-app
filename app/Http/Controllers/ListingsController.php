<?php

namespace App\Http\Controllers;

use App\Services\Contracts\ListingsServiceInterface;
use App\Http\Requests\Listing\CreateListingRequest;
use App\Http\Requests\Listing\GetListingsRequest;
use App\Http\Requests\Listing\UpdateListingRequest;
use App\Http\Requests\Listing\UploadListingImageRequest;
use App\Services\Contracts\FileServiceInterface;

class ListingsController extends Controller
{
    private $listingService;

    public function __construct(ListingsServiceInterface $listingService)
    {
        $this->listingService = $listingService;
    }

    public function getAll(GetListingsRequest $request)
    {
        $validatedData = $request->validated();
        return $this->listingService->getAllListings($validatedData);
    }

    public function search(GetListingsRequest $request)
    {
        $validatedData = $request->validated();
        return $this->listingService->filterListings($validatedData);
    }

    public function getOne(string $listingSlug)
    {
        return $this->listingService->getListingBySlug($listingSlug);
    }

    public function create(CreateListingRequest $request)
    {
        $validatedData = $request->validated();
        //dd($validatedData);
        return $this->listingService->createListing($validatedData);
    }

    public function updateOne(string $listingReferenceId, UpdateListingRequest $request)
    {
        $validatedData = $request->validated();
        //dd($validatedData);
        return $this->listingService->updateListingByReferenceId($listingReferenceId, $validatedData);
    }

    public function deleteOne(string $listingReferenceId)
    {
        return $this->listingService->deleteListingByReferenceId($listingReferenceId);
    }

}
