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

