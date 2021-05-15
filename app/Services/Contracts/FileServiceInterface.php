<?php

namespace App\Services\Contracts;

interface FileServiceInterface {

    public function uploadImageFileToS3Bucket($file); // for listing image upload
}
