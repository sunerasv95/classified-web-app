<?php


namespace App\Util;

final class Enums {

    /********************************
     *
     * SYSTEM CONFIGURATIONS
     *
    *********************************/

    const PASSPORT_CLIENT       = "Laravel Password Grant Client";


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
     * ROUTE PARAMTERS NAMES
     *
    *********************************/

    const PROVIDER_NAME_PARAMETER   = "providerName";

    /*******************************
     *
     * SYSTEM STATUS
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
     * SYSTEM MESSAGES
     *
    ********************************/

    const NOT_FOUND_USER_MESSAGE                        = "";
    const NOT_FOUND_USER_WITH_EMAIL_USERNAME_MESSAGE    = "No user found with that email or username";
    const LOGIN_FAILED_MESSAGE                          = "Logged in failed";


    const LOGIN_SUCCESS_MESSAGE                         = "Logged in successfully";



}
