<?php


namespace App\Enums;

final class ErrorCodes
{
    const UNDEFINED             = 1001;

    const INVALID_TOKEN         = 1020;
    const EXPIRED_TOKEN         = 1024;

    const UNAUTHORIZED_ACTION   = 4022;
    const INVALID_LOGIN         = 4025;
    const INVALID_REQUEST       = 4030;
    const BAD_REQUEST           = 4040;

    const VALIDATION_ERROR      = 3006;
    const INVALID_PAYLOAD       = 3009;

    const SERVER_ERROR          = 5021;

    const NOT_FOUND             = 2201;
    const ALREADY_EXISTS        = 2401;

}
