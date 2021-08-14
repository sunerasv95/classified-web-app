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
     ********* LISTING RELATED
     ****/

    const LISTING_CREATED                             = "Listing created successfully";


    /**************************
     ********* PERMISSION RELATED
     ****/
    const PERMISSION_NOT_FOUND                          = "Permission not found";
    const PERMISSION_ALREADY_EXISTS                     = "Permission aleardy exists";

    const PERMISSION_CREATED                            = "Permission created successfully";
    const PERMISSION_UPDATED                            = "Permission updated successfully";


    /**************************
     ********* PERMISSION RELATED
     ****/
    const ROLE_NOT_FOUND                          = "Role not found";
    const ROLE_ALREADY_EXISTS                     = "Role aleardy exists";

    const ROLE_CREATED                            = "Role created successfully";
    const ROLE_UPDATED                            = "Role updated successfully";


}
