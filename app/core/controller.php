<?php

class Controller {
    protected $db_cliente;
    protected $db_servico;
    protected $db_agendamento;
    protected $db_dashboard;
    protected $db_contato;

    public function __construct(){
        $this->db_cliente = new Cliente();  
        $this->db_servico = new Servico();
        $this->db_agendamento = new Agendamento();
        $this->db_dashboard = new Dashboard();
        $this->db_contato = new Contato();
    }




    // Metodos reutilizaveis
    public function view(string $pag, array $dados = []){
        extract($dados);

        require_once("../app/views/$pag.php");
    }

    public static function criptografia($text){
        $iv = random_bytes(openssl_cipher_iv_length($_ENV['METHOD']));

        $cripto = openssl_encrypt($text, $_ENV['METHOD'], $_ENV['CRIPTO_KEY'], 0, $iv);

        return base64_encode($iv . $cripto);
    }

    public static function descriptografia($cripto){
        $resultado = base64_decode($cripto);

        $iv = substr($resultado, 0, openssl_cipher_iv_length($_ENV['METHOD']));

        $text = substr($resultado, openssl_cipher_iv_length($_ENV['METHOD']));

        return openssl_decrypt($text, $_ENV['METHOD'], $_ENV['CRIPTO_KEY'], 0, $iv);
    }
}