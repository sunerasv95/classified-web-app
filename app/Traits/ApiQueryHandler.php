<?php

namespace App\Traits;

use App\Enums\Common;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Listing;
use App\Models\Permission;
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

    public function applyFilters(array $requestParams, $filterType=""): array
    {
        $entityFilters = $filters = [];

        switch($filterType){
            case Common::LISTING_FILTERS;
                $entityFilters = Listing::$filterable;
            break;

            case Common::BRAND_FILTERS;
                $entityFilters = Brand::$filterable;
            break;

            case Common::CATEGORY_FILTERS;
                $entityFilters = Category::$filterable;
            break;

            case Common::PERMISSION_FILTERS;
                $entityFilters = Permission::$filterable;
            break;

            case Common::ROLE_FILTERS;
                $entityFilters = Permission::$filterable;
            break;

            default:
                $entityFilters =[];
        }

        foreach($entityFilters as $keyFilter => $filter){
            foreach($requestParams as $keyParam => $param ){
                if($keyFilter === $keyParam) $filters[$filter] = $param;
            }
        }

        return $filters;
    }

}
