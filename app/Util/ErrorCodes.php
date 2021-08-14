<?php


namespace App\Util;

final class ErrorCodes {

    const UNDEFINED_ERROR_CODE                  = 1001;

    /********************************
     *
     * AUTHENTICATION ERROR CODES
     *
    *********************************/

    const INVALID_TOKEN_ERROR_CODE              = 1020;
    const EXPIRED_TOKEN_ERROR_CODE              = 1024;

    const UNAUTHORIZED_ACTION_ERROR_CODE        = 4022;
    const INVALID_LOGIN_CREDENTIALS             = 4025;
    const INVALID_REQUEST                       = 4030;


    /********************************
     *
     * VALIDATION ERROR CODES
     *
    *********************************/

    const VALIDATION_ERROR_CODE                 = 3006;


     /********************************
     *
     * SERVER ERROR CODES
     *
    *********************************/

    const INTERNAL_SERVER_ERROR_CODE            = 5021;

    /********************************
     *
     * RESOURCE REALTED ERROR CODES
     *
    *********************************/

    const RESOURCE_NOT_FOUND_ERROR_CODE         = 2201;
    const RESOURCE_EXISTS_ERROR_CODE            = 2204;

}
