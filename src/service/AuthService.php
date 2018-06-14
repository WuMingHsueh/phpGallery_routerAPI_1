<?php
namespace GalleryAPI\service;

class AuthService
{
    public function generateToken($account)
    {
        return substr(bin2hex(openssl_random_pseudo_bytes(4)), 1);
    }
}
