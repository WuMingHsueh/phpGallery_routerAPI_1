<?php
namespace GalleryAPI\service;

class AuthService
{
    public function generateToken()
    {
        return substr(bin2hex(openssl_random_pseudo_bytes(4)), 1);
    }

    public function tokenAuth($authorizationString)
    {
        $element = explode(' ', $authorizationString);
        return ($element[0] == 'Token' and $element[1] == 'WxhZGRp');
        // return ($element[0] == 'token' and $element[1] == $_SESSION['token']);
    }

    public function getLoginUser()
    {
        session_start();
        return $_SESSION['user'];
    }
}
