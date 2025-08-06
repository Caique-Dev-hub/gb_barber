<?php

class Geral
{
    public static function criptografia($texto)
    {
        $chave = file_get_contents('../config/chave.key');
        $iv = random_bytes(openssl_cipher_iv_length(metodo));

        $resultado = openssl_encrypt($texto, metodo, $chave, 0, $iv);
        return base64_encode($iv . $resultado);
    }

    public static function descriptografia($cripto)
    {
        $iv = substr(base64_decode($cripto), 0, openssl_cipher_iv_length(metodo));
        $chave = file_get_contents('../config/chave.key');
        $texto = substr(base64_decode($cripto), openssl_cipher_iv_length(metodo));

        return openssl_decrypt($texto, metodo, $chave, 0, $iv);
    }

    public static function texto_url($texto)
    {
        $texto = strtolower($texto);

        $caracteres = [
            'á' => 'a',
            'à' => 'a',
            'ã' => 'a',
            'â' => 'a',
            'ä' => 'a',
            'Á' => 'A',
            'À' => 'A',
            'Ã' => 'A',
            'Â' => 'A',
            'Ä' => 'A',
            'é' => 'e',
            'è' => 'e',
            'ê' => 'e',
            'ë' => 'e',
            'É' => 'E',
            'È' => 'E',
            'Ê' => 'E',
            'Ë' => 'E',
            'í' => 'i',
            'ì' => 'i',
            'î' => 'i',
            'ï' => 'i',
            'Í' => 'I',
            'Ì' => 'I',
            'Î' => 'I',
            'Ï' => 'I',
            'ó' => 'o',
            'ò' => 'o',
            'õ' => 'o',
            'ô' => 'o',
            'ö' => 'o',
            'Ó' => 'O',
            'Ò' => 'O',
            'Õ' => 'O',
            'Ô' => 'O',
            'Ö' => 'O',
            'ú' => 'u',
            'ù' => 'u',
            'û' => 'u',
            'ü' => 'u',
            'Ú' => 'U',
            'Ù' => 'U',
            'Û' => 'U',
            'Ü' => 'U',
            'ç' => 'c',
            'Ç' => 'C',
            ' ' => '-',
            '!' => '',
            '@' => '',
            '#' => '',
            '$' => '',
            '%' => '',
            '^' => '',
            '&' => '',
            '*' => '',
            '(' => '',
            ')' => '',
            '+' => '',
            '=' => '',
            '{' => '',
            '}' => '',
            '[' => '',
            ']' => '',
            ':' => '',
            ';' => '',
            '"' => '',
            '\'' => '',
            '<' => '',
            '>' => '',
            ',' => '',
            '.' => '',
            '?' => '',
            '/' => '',
            '\\' => '',
            '|' => '',
            '~' => '',
            '`' => ''
        ];

        $texto = strtr($texto, $caracteres);

        return $texto;
    }
}
