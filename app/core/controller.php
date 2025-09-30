<?php

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


    
    public static function criptografia(string|int|float $text): string
    {
        $iv = random_bytes(openssl_cipher_iv_length($_ENV['METHOD']));

        $key = base64_decode($_ENV['CRYPTO_KEY']);

        $tag = '';

        $crypto = openssl_encrypt($text, $_ENV['METHOD'], $key, OPENSSL_RAW_DATA, $iv, $tag);

        return base64_encode($iv . $tag . $crypto);
    }

    public static function descriptografia(string $crypto): bool|string
    {
        $bin = base64_decode($crypto);

        $iv = substr($bin, 0, openssl_cipher_iv_length($_ENV['METHOD']));

        $ivTag = openssl_cipher_iv_length($_ENV['METHOD']) + 16;

        $tag = substr($bin, openssl_cipher_iv_length($_ENV['METHOD']), 16);

        $text = substr($bin, $ivTag);

        $key = base64_decode($_ENV['CRYPTO_KEY']);

        return openssl_decrypt($text, $_ENV['METHOD'], $key, OPENSSL_RAW_DATA, $iv, $tag);
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

        if(file_exists("upload/$nome")){
            return false;
        }

        move_uploaded_file($imagem['tmp_name'], "upload/$nome");

        return $nome;
    }
}
