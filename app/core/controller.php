<?php

class Controller {
    protected $db_cliente;
    protected $db_servico;
    protected $db_agendamento;
    protected $db_dashboard;
    protected $db_contato;
    protected $db_data;

    public function __construct(){
        $this->db_cliente = new Cliente();  
        $this->db_servico = new Servico();
        $this->db_agendamento = new Agendamento();
        $this->db_dashboard = new Dashboard();
        $this->db_contato = new Contato();
        $this->db_data = new Data();
    }




    // Metodos reutilizaveis
    public function view(string $pag, array $dados = []){
        extract($dados);

        require_once("../app/views/$pag.php");
    }

    public static function criptografia($text){
        $nonce = random_bytes(SODIUM_CRYPTO_BOX_NONCEBYTES);
        
        $key = base64_decode($_ENV['CRYPTO_KEY']);

        $crypto = sodium_crypto_secretbox($text, $nonce, $key);

        return base64_encode($nonce . $crypto);
    }
    
    public static function descriptografia($crypto){
        $bin = base64_decode($crypto);

        $key = base64_decode($_ENV['CRYPTO_KEY']);

        $nonce = substr($bin, 0, SODIUM_CRYPTO_BOX_NONCEBYTES);
        $text = substr($bin, SODIUM_CRYPTO_BOX_NONCEBYTES);

        return sodium_crypto_secretbox_open($text, $nonce, $key);
    }
}