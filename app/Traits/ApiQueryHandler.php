<?php

namespace App\Traits;

use App\Models\Listing;
use Illuminate\Support\Facades\Log;

trait ApiQueryHandler
{
    public function applySearchFilter(array $requestParams): string
    {
        $searchKey = "";

        if (!empty($requestParams['qry'])) $searchKey = $requestParams['qry'];

        return $searchKey;
    }

    public function applySort(array $requestParams): array
    {
        $orderby = [
            "sort" => "id",
            "order" => "asc"
        ];
        //dd($requestParams);
        if (
            (isset($requestParams['sort']) && !empty($requestParams['sort'])) &&
            (isset($requestParams['order']) && !empty($requestParams['order']))
        ) {
            $orderby['sort']  = $requestParams['sort'];
            $orderby['order'] = $requestParams['order'];
        }

        return $orderby;
    }

    public function applyPagination(array $requestParams): array
    {
        $pagination = [
            "limit" => 10,
            "offset" => 0
        ];
        //dd($requestParams);
        if (isset($requestParams['limit']) && isset($requestParams['offset'])) {
            if($requestParams['limit'] != "" && $requestParams['offset'] != ""){
                $pagination['limit']  = $requestParams['limit'];
                $pagination['offset'] = $requestParams['offset'];
            }
        }
        //dd($pagination);
        return $pagination;
    }


    public function applyListingFilters(array $requestParams): array
    {
        $filters = $listingFilters = [];

        $listingFilters = Listing::$filters;

        foreach($listingFilters as $keyFilter => $filter){
            foreach($requestParams as $keyParam => $param ){
                if($keyFilter === $keyParam) $filters[$filter] = $param;
            }
        }

        return $filters;
    }

}
