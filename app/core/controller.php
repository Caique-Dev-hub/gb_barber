<?php

use Random\RandomException;

class Controller
{
    protected $db_cliente;
    protected $db_servico;
    protected $db_agendamento;
    protected $db_dashboard;
    protected $db_contato;
    protected $db_data;
    protected $db_reserva;
    protected $db_notificacao;

    public function __construct()
    {
        $this->db_cliente = new Cliente();
        $this->db_servico = new Servico();
        $this->db_agendamento = new Agendamento();
        $this->db_dashboard = new Dashboard();
        $this->db_contato = new Contato();
        $this->db_data = new Data();
        $this->db_reserva = new Reserva();
        $this->db_notificacao = new Notificacao();
    }




    // Metodos reutilizaveis
    public function view(string $pag, array $dados = [])
    {
        extract($dados);

        require_once("../app/views/$pag.php");
    }




    // ----------------------------------------------------- Criptografia ----------------------------------------------------- //

    public static function criptografia(string|int $dados): ?string
    {
        if (empty($dados)) {
            return null;
        }

        try {
            $iv = random_bytes(openssl_cipher_iv_length(METHOD_CRYPTO));

            $tag = '';

            $key = base64_decode(CRYPTO_KEY);

            $crypto = openssl_encrypt($dados, METHOD_CRYPTO, $key, OPENSSL_RAW_DATA, $iv, $tag);

            if (!$crypto || empty($tag)) {
                return null;
            }

            $cryptoCompleta = $iv . $tag . $crypto;

            return $cryptoCompleta ?: null;
        } catch (RandomException $e) {
            return null;
        }
    }

    public static function descriptografia(string $crypto): string|int|null
    {
        if (empty($crypto)) {
            return null;
        }

        $iv = substr($crypto, 0, openssl_cipher_iv_length(METHOD_CRYPTO));

        if (empty($iv)) {
            return null;
        }

        $tag = substr($crypto, strlen($iv), 16);

        if (empty($tag)) {
            return null;
        }

        $dados = substr($crypto, (strlen($iv) + strlen($tag)));

        if (empty($dados)) {
            return null;
        }

        $key = base64_decode(CRYPTO_KEY);

        $normal = openssl_decrypt($dados, METHOD_CRYPTO, $key, OPENSSL_RAW_DATA, $iv, $tag);

        if (!$normal) {
            return null;
        }

        if(is_numeric($normal)){
            return (int)$normal ?: null;
        } else {
            return $normal ?: null;
        }
    }



    public static function tratar_url(string $texto): string
    {
        $textoUrl = trim(strtolower($texto));

        $caracter = [
            'á' => 'a',
            'à' => 'a',
            'â' => 'a',
            'ã' => 'a',
            'ä' => 'a',
            'å' => 'a',

            'Á' => 'a',
            'À' => 'a',
            'Â' => 'a',
            'Ã' => 'a',
            'Ä' => 'a',
            'Å' => 'a',

            'é' => 'e',
            'è' => 'e',
            'ê' => 'e',
            'ë' => 'e',

            'É' => 'e',
            'È' => 'e',
            'Ê' => 'e',
            'Ë' => 'e',

            'í' => 'i',
            'ì' => 'i',
            'î' => 'i',
            'ï' => 'i',

            'Í' => 'i',
            'Ì' => 'i',
            'Î' => 'i',
            'Ï' => 'i',

            'ó' => 'o',
            'ò' => 'o',
            'ô' => 'o',
            'õ' => 'o',
            'ö' => 'o',

            'Ó' => 'o',
            'Ò' => 'o',
            'Ô' => 'o',
            'Õ' => 'o',
            'Ö' => 'o',

            'ú' => 'u',
            'ù' => 'u',
            'û' => 'u',
            'ü' => 'u',

            'Ú' => 'u',
            'Ù' => 'u',
            'Û' => 'u',
            'Ü' => 'u',

            'ç' => 'c',
            'Ç' => 'c',

            'ñ' => 'n',
            'Ñ' => 'n',
            '+' => ''
        ];

        $textoUrl = str_replace(' ', '-', $textoUrl);

        $textoUrl = strtr($textoUrl, $caracter);

        return $textoUrl;
    }

    public static function tratar_imagem(array $imagem, string $nomeNovo): string|bool
    {
        $nome = pathinfo($imagem['name'], PATHINFO_BASENAME);

        $nome = explode('.', $nome);

        $nomeNovo = strtolower($nomeNovo);

        $nomeNovo = self::tratar_url($nomeNovo);

        $nome[0] = $nomeNovo;

        $nome = implode('.', $nome);

        if (file_exists("upload/$nome")) {
            return false;
        }

        move_uploaded_file($imagem['tmp_name'], "upload/$nome");

        return $nome;
    }
}
