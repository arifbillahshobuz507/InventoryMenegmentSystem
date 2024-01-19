<?php

namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken
{

    public static function CreateToken($userEmail)
    {
        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'Larave',
            'iat' => time(),
            'exp' => time() + 60 * 60,
            'userEmail' => $userEmail,
        ];
        return JWT::encode($payload, $key, 'HS256');
    }

    public static function CreateTokenForVerify($userEmail)
    {
        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'Larave',
            'iat' => time(),
            'exp' => time() + 60 * 60,
            'userEmail' => $userEmail,
        ];
        return JWT::encode($payload, $key, 'HS256');
    }

    public static function VerifyToken($token)
    {
        try {
            $key = env('JWT_KEY');
            $decode = JWT::decode($token, new Key($key, 'HS256'));
           return $decode->userEmail;
        } catch (Exception $e) {
            return "unauthorized";
        }
    }
}
