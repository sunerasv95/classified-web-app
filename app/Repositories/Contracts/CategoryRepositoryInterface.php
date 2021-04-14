<?php

namespace App\Repositories\Contracts;

interface CategoryRepositoryInterface {

    public function getAll();

    public function getCategory($id);
}
