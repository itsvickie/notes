<?php

namespace App\Helper;

class Helper
{
    public static function Jwt($payload)
    {
        $header = [
            'alg' => 'HS256',
            'typ' => 'JWT'
        ];
        $header = json_encode($header);
        $header = base64_encode($header);

        $payload = json_encode($payload);
        $payload = base64_encode($payload);

        $signature = hash_hmac('sha256', "$header.$payload", env('APP_KEY'), true);
        $signature = base64_encode($signature);

        $token = "$header.$payload.$signature";

        return $token;
    }

    public static function verifyJwt($token)
    {
        $part = explode('.', $token);
        $header = $part[0];
        $payload = $part[1];
        $signature = $part[2];

        $valid = hash_hmac('sha256', "$header.$payload", env('APP_KEY'), true);
        $valid = base64_encode($valid);

        if($valid !== $signature){
            http_response_code(401);
            die(json_encode(['message' => 'Token Informado Inválido!']));
        }

        $payload = base64_decode($payload);

        return json_decode($payload, true);
    }
}