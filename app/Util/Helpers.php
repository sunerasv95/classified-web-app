<?php

use App\Enums\SystemPrefix;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Eloquent\Collection;


if (!function_exists('makeHashedPassword')) {
    function makeHashedPassword(string $string)
    {
        $hashed = Hash::make($string);
        return $hashed;
    }
}

if (!function_exists('checkHashedPassword')) {
    function checkHashedPassword(string $plainPass, string $hashedVal)
    {
        $checked = Hash::check($plainPass, $hashedVal);
        return $checked;
    }
}


//creates username wich has
// at least 6 characters
// numbers and letters
if (!function_exists('makeUniqueUsernameWithEmail')) {
    function makeUniqueUsernameWithEmail(string $email)
    {
        $fetchEmailUser = explode("@", trim($email));
        $getCharacters = substr($fetchEmailUser[0], 0, 6);
        $randomNumber = rand(199,999);

        $username = $getCharacters.$randomNumber;
        return $username;
    }
}

if (!function_exists('makeUsername')) {
    function makeUsername(string $text)
    {
        $text = ucfirst(strtolower(substr($text, 0, 5)));
        $randomNumber = rand(199,999);

        $username = $text.$randomNumber;
        return $username;
    }
}

if (!function_exists('makeMemberUserCode')) {
    function makeMemberUserCode()
    {
        $prefix = SystemPrefix::MEMBER_USER_CODE_PREFIX;
        $randomNumber = rand(1000000,9999999);

        $userCode = $prefix.$randomNumber;
        return $userCode;
    }
}




if (!function_exists('getCurrentDateTime')) {
    function getCurrentDateTime()
    {
        return Carbon::now();
    }
}


if (!function_exists('timeStampToDate')) {
    function timestampToDate($dateObj)
    {
        return date_format($dateObj,'Y/m/d');
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

