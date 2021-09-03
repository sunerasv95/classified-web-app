<?php

namespace App\Repositories;

use App\Models\Listing;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\ListingRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ListingRepository extends BaseRepository implements ListingRepositoryInterface  {

    private $listingSearchAttributes;

    public function __construct(Listing $model)
    {
        parent::__construct($model);
        $this->listingSearchAttributes = $model::$defaultSearchQueryColumns;
    }


    public function findById(
        int $id,
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): ?Model
    {
        $criteria['id'] = $id;
        return $this->getOne($criteria, $columns, $relations);
    }

    public function findBySlug(
        string $slug,
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): ?Model
    {
        $criteria['listing_slug'] = $slug;
        return $this->getOne($criteria, $columns, $relations);
    }

    public function findByReferenceId(
        string $referenceId,
        array $criteria = [],
        array $columns = ["*"],
        array $relations = []
    ): ?Model
    {
        $criteria['listing_ref_number'] = $referenceId;
        return $this->getOne($criteria, $columns, $relations);
    }


    public function applyFilters(
        string $query,
        array $filters = [],
        array $columns = ["*"],
        array $relations = [],
        array $paginate = [],
        array $orderBy = [],
        array $groupByCols = []
    ): Collection
    {
        $queryCols = $this->listingSearchAttributes;
        return $this->filterCriteria(
            $query,
            $queryCols,
            $filters,
            $columns,
            $relations,
            $paginate,
            $orderBy,
            $groupByCols
        );
    }

    public function updateDeletedStatus(
        Listing $listing
    ): bool
    {
        return $this->update($listing, ["is_deleted" => 1]);
    }
}
