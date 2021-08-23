<?php


namespace App\Util;

final class Enums {

    /********************************
     *
     * SYSTEM CONFIGURATIONS
     *
    *********************************/

    const PASSPORT_PASSWORD_GRANT_CLIENT        = "Laravel Password Grant Client";
    const PASSPORT_TOKEN_TYPE                   = "Bearer";


    /********************************
     *
     * BUSINESS LOGIC RELATED TYPES
     *
    *********************************/

    const BOARD_LISTING         = "BOARD_LISTING";
    const ACCESSORIES_LISTING   = "ACCESSORIES_LISTING";

    const REGULAR_MEMBER_TYPE   = 1;

    /********************************
     *
     * PREFIXES
     *
    *********************************/

    const ADMIN_CODE_PREFIX     = "ADM";
    const BRAND_CODE_PREFIX     = "CBR";
    const CATEGORY_CODE_PREFIX  = "CAT";

    /********************************
     *
     * ROUTE PARAMTERS NAMES
     *
    *********************************/

    const PROVIDER_NAME_PARAMETER   = "providerName";

    /*******************************
     *
     *  STATUS
     *
    *******************************/

    const STATUS_ACTIVE         = 1;
    const STATUS_YES            = 1;
    const APPROVED_YES          = 1;

    const STATUS_NO             = 0;
    const NOT_DELETED           = 0;
    const NOT_BLOCKED           = 0;
    const NOT_REVOKED           = 0;



    /*******************************
     *
     *  MESSAGES
     *
    ********************************/

    const NOT_FOUND_USER_MESSAGE                        = "";
    const NOT_FOUND_USER_WITH_EMAIL_USERNAME_MESSAGE    = "No user found with that email or username";
    const LOGIN_FAILED_MESSAGE                          = "Logged in failed";


    const LOGIN_SUCCESS_MESSAGE                         = "Logged in successfully";


    /*******************************
     *
     *  HTTP REQUESTS
     *
    ********************************/

    const SEARCH_QUERY_PARAM            = "qry";
    const SORT_QUERY_PARAM              = "sort";
    const SORT_ORDER_QUERY_PARAM        = "order";
    const LIMIT_QUERY_PARAM             = "limit";
    const OFFSET_QUERY_PARAM            = "offset";
    const START_DATE_QUERY_PARAM        = "startDate";
    const END_DATE_QUERY_PARAM          = "endDate";

    const CATEGORY_STATUS_PARAM         = "status";

    const BRAND_STATUS_PARAM            = "status";

    const ROLES_STATUS_PARAM            = "status";

    const PERMISSION_STATUS_PARAM       = "status";

    const ADMIN_IS_ACTIVE_PARAM         = "active";
    const ADMIN_ROLE_PARAM              = "role";

}
