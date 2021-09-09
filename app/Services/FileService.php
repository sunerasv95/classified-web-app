<?php

namespace App\Services;

use App\Services\Contracts\FileServiceInterface;
use App\Services\Contracts\ListingImageServiceInterface;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Storage;

class FileService implements FileServiceInterface
{
    use ApiResponser;

    private $listingImageRepository;

    public function __construct(ListingImageServiceInterface $listingImageRepository)
    {
        $this->listingImageRepository = $listingImageRepository;
    }

    public function uploadImageFileToS3Bucket($file)
    {
        $path = "listing_images";
        $content = $file['file'];

        $result = Storage::disk('s3')->put($path, $content);
        return $result;
    }


}
