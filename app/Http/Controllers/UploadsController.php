<?php

namespace App\Http\Controllers;

use App\Http\Requests\Listing\UploadListingImageRequest;
use App\Services\Contracts\FileServiceInterface;
use Illuminate\Http\Request;

class UploadsController extends Controller
{
    public function uploadImage(UploadListingImageRequest $request, FileServiceInterface $fileService)
    {
        $validatedData = $request->validated();
        return $fileService->uploadImageFileToS3Bucket($validatedData);
    }
}
