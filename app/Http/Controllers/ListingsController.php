<?php

namespace App\Http\Controllers;

use app\Services\Contracts\ListingsServiceInterface;
use Illuminate\Http\Request;

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
}
