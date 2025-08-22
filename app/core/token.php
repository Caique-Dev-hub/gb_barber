<?php

class Token
{
    public static function gerar_token(array $payload): string
    {
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256'
        ];

        $header = self::base64Url_encode($header);

        $payload = self::base64Url_encode($payload);



        $key = base64_decode($_ENV['CRYPTO_KEY']);

        $hashSigne = hash_hmac('sha256', "$header.$payload", $key);

        $signe = self::base64Url_encode($hashSigne);


        return "$header.$payload.$signe";
    }

    public static function validar_token(string $token): ?array
    {
        $partesToken = explode('.', $token);

        if(count($partesToken) !== 3){
            return null;
        }

        list($header, $payload, $signe) = $partesToken;

        
        $key = base64_decode($_ENV['CRYPTO_KEY']);

        $signeNovo = hash_hmac('sha256', "$header.$payload", $key);

        $signeNovo = self::base64Url_encode($signeNovo);

        if(!hash_equals($signe, $signeNovo)){
            return null;
        }

        
        $payloadNormal = self::base64Url_decode($payload);
        $payloadNormal = json_decode($payloadNormal, true);

        if(!is_array($payloadNormal)){
            return null;
        }

        if(isset($payloadNormal['exp']) && time() > $payloadNormal['exp']){
            return null;
        }

        return $payloadNormal;
    }



    private static function base64Url_encode(array|string $dados): string
    {
        $base64 = json_encode($dados);

        $base64 = base64_encode($base64);

        $base64 = strtr($base64, '+/', '-_');

        $base64 = rtrim($base64, '=');

        return $base64;
    }

    private static function base64Url_decode(string $base64): string
    {
        $normal = strtr($base64, '-_', '+/');

        $sobra = strlen($normal) % 4;

        match($sobra){
            3 => $normal .= '=',
            2 => $normal .= '==',
            default => null
        };

        return base64_decode($normal);
    }
}