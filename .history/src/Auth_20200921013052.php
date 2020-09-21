<?php

namespace App;

use App\Security\ForbidenException;

class Auth
{
    public static function check()
    {
        if (!isset($_SESSION['auth'])) {
            throw new ForbidenException();
        }
    }
}