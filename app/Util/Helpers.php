<?php

use Illuminate\Support\Facades\Hash;

if (!function_exists('makeHashedPassword')) {
    function makeHashedPassword($string)
    {
        $hashed = Hash::make($string);
        return $hashed;
    }
}

if (!function_exists('checkHashedPassword')) {
    function checkHashedPassword($plainPass, $hashedVal)
    {
        $checked = Hash::check($plainPass, $hashedVal);
        return $checked;
    }
}


//creates username wich has
// at least 6 characters
// numbers and letters
if (!function_exists('makeUniqueUsernameWithEmail')) {
    function makeUniqueUsernameWithEmail($email)
    {
        $fetchEmailUser = explode("@", trim($email));
        $getCharacters = substr($fetchEmailUser[0], 0, 6);
        $randomNumber = rand(199,999);

        $username = $getCharacters.$randomNumber;
        return $username;
    }
}

// if (!function_exists('makeUniqueFirstAndLastNames')) {
//     function makeUniqueFirstAndLastNames($fname, $lname)
//     {
//         $names = trim($fname).trim($lname);
//         $getCharacters = substr($fetchEmailUser[0], 0, 6);
//         $randomNumber = rand(199,999);

//         $username = $getCharacters.$randomNumber;
//         return $username;
//     }
// }

