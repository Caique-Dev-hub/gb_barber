<?php

class Controller {
    protected $db_cliente;
    protected $db_servico;
    protected $db_agendamento;
    protected $db_dashboard;
    protected $db_contato;
    protected $db_data;
    protected $db_reserva;

    public function __construct(){
        $this->db_cliente = new Cliente();  
        $this->db_servico = new Servico();
        $this->db_agendamento = new Agendamento();
        $this->db_dashboard = new Dashboard();
        $this->db_contato = new Contato();
        $this->db_data = new Data();
        $this->db_reserva = new Reserva();
    }




    // Metodos reutilizaveis
    public function view(string $pag, array $dados = []){
        extract($dados);

        require_once("../app/views/$pag.php");
    }

    public static function criptografia($text){
        $iv = random_bytes(openssl_cipher_iv_length($_ENV['METHOD']));

        $key = base64_decode($_ENV['CRYPTO_KEY']);

        $tag = '';

        $crypto = openssl_encrypt($text, $_ENV['METHOD'], $key, OPENSSL_RAW_DATA, $iv, $tag);

        return base64_encode($iv . $tag . $crypto);
    }
    
    public static function descriptografia($crypto){
        $bin = base64_decode($crypto);

        $iv = substr($bin, 0, openssl_cipher_iv_length($_ENV['METHOD']));

        $ivTag = openssl_cipher_iv_length($_ENV['METHOD']) + 16;

        $tag = substr($bin, openssl_cipher_iv_length($_ENV['METHOD']), 16);

        $text = substr($bin, $ivTag);

        $key = base64_decode($_ENV['CRYPTO_KEY']);

        return openssl_decrypt($text, $_ENV['METHOD'], $key, OPENSSL_RAW_DATA, $iv, $tag);
    }
}