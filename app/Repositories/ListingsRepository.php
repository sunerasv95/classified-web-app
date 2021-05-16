<?php

namespace App\Repositories;

use App\Models\Listing;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\ListingRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ListingRepository extends BaseRepository implements ListingRepositoryInterface  {

    public function __construct(Listing $model)
    {
        parent::__construct($model);
    }

    public function createWithRelationships(array $attributes, array $relations): Model
    {
        $detail_attr = null;

        $newListing = $this->create($attributes);
        $listingId  = $newListing->id;

        if (isset($relations["details_attributes"])) $detail_attr = $relations["details_attributes"];

        if (isset($newListing) && isset($detail_attr)) {
            foreach ($detail_attr as $k => $attr) {
                $detail_attr[$k]["listing_id"] = $listingId;
            }
            $newListing->detail_attributes()->attach($detail_attr);
        }

        return $newListing;
    }

    public function updateWithRelationships(Model $model, array $attributes, array $relations): bool
    {
        $update_attr = null;
        $listingUpdated = $this->update($model, $attributes);

        if (isset($relations["details_attributes"])) $update_attr = $relations["details_attributes"];

        if (isset($listingUpdated) && isset($update_attr)) {
            foreach ($update_attr as $k => $attr) {
                $update_attr[$k]["listing_id"] = $model->id;
            }
            $model->detail_attributes()->sync($update_attr);
        }

        return $listingUpdated;
    }

}
