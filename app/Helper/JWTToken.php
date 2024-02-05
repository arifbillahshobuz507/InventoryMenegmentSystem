<?php

namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken
{

    public static function CreateToken($userEmail,$id)
    {
        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'Larave',
            'iat' => time(),
            'exp' => time() + 60*60*30,
            'userEmail' => $userEmail,
            'userid' => $id,
        ];
        return JWT::encode($payload, $key, 'HS256');
    }

    public static function CreateTokenForVerify($userEmail):string
    {
        $key = env('JWT_KEY');
        $payload = [
            'iss' => 'Larave',
            'iat' => time(),
            'exp' => time() + 60 * 60,
            'userEmail' => $userEmail,
            'userid' => "0"
        ];
        return JWT::encode($payload, $key, 'HS256');
    }

    public static function VerifyToken($token):string|object
    {
        try {
            if($token == null){
                return "unauthorized";
            } else{
                $key = env('JWT_KEY');
                $decode = JWT::decode($token, new Key($key, 'HS256'));
               return $decode;
            }
            
        } catch (Exception $e) {
            return "unauthorized";
        }
    }
}
