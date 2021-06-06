<?php


namespace App\Util;

final class HttpMessages {

    /*******************************
     *
     * SYSTEM MESSAGES
     *
    ********************************/

    //Common
    const CREATED_SUCCESS_MESSAGE                      = "Created successfully";

    /**************************
     ********* USER RELATED
     ****/

    const NOT_FOUND_USER_MESSAGE                        = "User not found";
    const NOT_FOUND_USER_WITH_EMAIL_USERNAME_MESSAGE    = "No user found with that email or username";
    const NOT_APPROVED_USER_MESSAGE                     = "User does not has any administration authorities";

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


}
