<?php

namespace App\Repositories\Contracts;

interface ListingRepositoryInterface {

    public function getAll();

    public function getListing($id);
}
