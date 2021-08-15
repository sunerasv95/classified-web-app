<?php


namespace App\Util;

final class HttpMessages {

    /*******************************
     *
     * SYSTEM MESSAGES
     *
    ********************************/

    //Common
    const RESPONSE_OKAY_MESSAGE                        = "OK";
    const CREATED_SUCCESS_MESSAGE                      = "Created successfully";

    /**************************
     ********* AUTH RELATED
     ****/

    const UNAUTHORIZED_MESSAGE                          = "Unauthorized";
    const UNAUTHORIZED_ACTION                           = "The action is unauthorized";
    const NOT_FOUND_USER_MESSAGE                        = "User not found";
    const NOT_FOUND_USER_WITH_EMAIL_USERNAME_MESSAGE    = "No user found with that email or username";
    const NOT_APPROVED_USER_MESSAGE                     = "User does not has any administration authorities";
    const NOT_ACTIVATEDD_USER_MESSAGE                   = "User is not activated";
    const INVALID_LOGIN_CREDENTIALS                     = "Login credential/s are not valid";

    const LOGIN_FAILED_MESSAGE                          = "Log in failed";
    const PASSWORDS_MISMATCHED_MESSAGE                  = "Passwords are not matched";
    const EMAIL_IS_ALREADY_EXISTS                       = "Email address is already taken, please try with different address";
    const BLOCKED_USER_MESSAGE                          = "User is currently blocked";
    const ALREADY_APPROVED_USER_MESSAGE                 = "User is already approved";
    const SUCCESSFULLY_APPROVED_MESSAGE                 = "Approved successfully";
    const LOGIN_SUCCESS_MESSAGE                         = "Logged in successfully";
    const REGISTER_SUCCESS_MESSAGE                      = "Registered successfully";
    const APPROVAL_REJECTED                             = "Approval request has been rejected";



    /**************************
     ********* RESOURCE RELATED
     ****/

    const UPDATED_SUCCESSFULLY              = "Updated Successfully";
    const CREATED_SUCCESSFULLY              = "Created Successfully";

    const RESOURCE_CREATION_FAILED          = "Creation Failed";
    const RESOURCE_UPDATION_FAILED          = "Creation Failed";

    const BAD_REQUEST                       = "Bad Request";
    const RESOURCE_NOT_FOUND                = "Resource Not Found";
    const RESOURCE_EXISTS                   = "Resource exists";


    /**************************
     ********* COMMON
     ****/

     const INTERNAL_SERVER_ERROR            = "Internal Server Error";

}
