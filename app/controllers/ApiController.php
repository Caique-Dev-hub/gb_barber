<?php

class ApiController extends Controller{

    // Cliente
    public function add_cadastro(){
        $input = file_get_contents('php://input');
        $input = json_decode($input, true);

        header('Content-Type: application/json');

        $nome = '';
        $email = '';
        $email_hash = '';
        $whatsapp = '';
        $whatsapp_hash = '';
        $senha = '';

        foreach($input as $campo => $valor){
            if(empty(trim($valor))){
                self::error(400, 'Preencha todos os campos');
                return;
            }

            switch($campo){
                case 'nome':
                    $nome = filter_var(trim($valor), FILTER_SANITIZE_SPECIAL_CHARS);

                    $nome = explode(' ', $nome);

                    if(count($nome) < 2){
                        self::error(400, 'Insira o seu nome completo');
                        return;
                    }

                    foreach($nome as $n){
                        if(strlen($n) < 2){
                            self::error(400, 'Nome invalido');
                            return;
                        }
                    }

                    $nome = implode(' ', $nome);
                    break;

                case 'email':
                    $email = filter_var($valor, FILTER_SANITIZE_EMAIL);

                    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                        self::error(400, 'Digite um E-mail valido');
                        return;
                    }

                    $key = base64_decode($_ENV['CRYPTO_KEY']);

                    $email_hash = hash_hmac('sha256', $email, $key);

                    unset($key);

                    $getEmail = $this->db_cliente->getEmail($email_hash);

                    if($getEmail <> false){
                        self::error(404, 'E-mail ja registrado');
                        return;
                    }

                    $email = Controller::criptografia($email);
                    break;

                case 'whatsapp':
                    $whatsapp = filter_var($valor, FILTER_SANITIZE_SPECIAL_CHARS);

                    if(strlen($whatsapp) <> 15){
                        self::error(400, 'Insira o whatsapp valido');
                        return;
                    }

                    if(preg_match('/^\(\d{2}\) \d{5}-\d{4}$/', $whatsapp) === 0){
                        self::error(404, 'Whatsapp formatado incorretamente, insira o seu numero no formato (xx) xxxxx-xxxx');
                        return;
                    }

                    $key = base64_decode($_ENV['CRYPTO_KEY']);

                    $whatsapp_hash = hash_hmac('sha256', $whatsapp, $key);

                    unset($key);

                    $getWhatsapp = $this->db_cliente->getWhatsapp($whatsapp_hash);

                    if($getWhatsapp <> false){
                        self::error(409, 'Whatsapp ja esta registrado');
                        return;
                    }

                    $whatsapp = Controller::criptografia($whatsapp);
                    break;

                case 'senha':
                    $senha = filter_var($valor, FILTER_SANITIZE_SPECIAL_CHARS);

                    if(strlen($senha) < 5){
                        self::error(400, 'Sua senha precisa conter 5 digitos ou mais');
                        return;
                    }

                    $senha = password_hash($senha, PASSWORD_DEFAULT);
                    break;
            }
        }

        $verify = [
            $nome,
            $email,
            $email_hash,
            $whatsapp,
            $whatsapp_hash,
            $senha
        ];

        foreach($verify as $valor){
            if(empty($valor)){
                self::error(404, 'Erro ao fazer tratamento dos dados');
                return;
            }
        }

        $input['nome'] = $nome;
        $input['email'] = $email;
        $input['email_hash'] = $email_hash;
        $input['whatsapp'] = $whatsapp;
        $input['whatsapp_hash'] = $whatsapp_hash;
        $input['senha'] = $senha;

        $addCliente = $this->db_cliente->addCliente($input);

        if(!$addCliente){
            self::error(404, 'Erro ao adicionar cliente');
            return;
        }

        self::success(202, 'Cadastro realizado com sucesso');
        return;
    }



    // Servicos
    public function listar_servicos(){
        header('Content-Type: application/json');

        $getServicos = $this->db_servico->getservico();

        if(!$getServicos){
            self::error(404, 'Erro ao retornar servicos');
            return;
        }

        $getCombos = $this->db_servico->getcombo();

        if(!$getCombos){
            self::error(404, 'Erro ao retornar os combos de servicos');
            return;
        }

        $getAll = array_merge($getServicos, $getCombos);

        self::display(200, $getAll);
    }

    public function listar_detalhe_servico($id){
        header('Content-Type: application/json');

        $id = (int)$id;

        if($id > 3){
            $combo = $id - 3;

            $getCombo = $this->db_servico->getDetalhe_combo($combo);

            if(!$getCombo){
                self::error(404, 'Erro ao retornar o detalhe do combo');
                return;
            }

            self::display(200, $getCombo);
            return;
        } else{
            $getServico = $this->db_servico->getDetalhe_servico($id);

            if(!$getServico){
                self::error(400, 'Erro ao retornar o detalhe do servico');
                return;
            }

            self::display(200, $getServico);
            return;
        }
    }



    // Data
    public function listar_datas(){
        header('Content-Type: application/json');

        $getData = $this->db_data->getDatas();

        if(!$getData){
            self::error(404, 'Erro ao retornar todas as datas');
            return;
        }

        self::display(200, $getData);
        return;
    }

    public function listar_horarios($data){
        header('Content-Type: application/json');

        $getHorario = $this->db_data->getHorarios($data);

        if(!$getHorario){
            self::error(404, 'Erro ao retornar os horarios dessa data');
            return;
        }

        self::display(200, $getHorario);
        return;
    }

    



    // Respostas
    private static function error(int $http, string $mensagem){
        header('Content-Type: application/json');
        http_response_code($http);
        echo json_encode([
            'erro' => $mensagem
        ]);
    }

    private static function success(int $http, string $mensagem){
        header('Content-Type: application/json');
        http_response_code($http);
        echo json_encode([
            'sucesso' => $mensagem
        ]);
    }

    private static function display(int $http, array $table){
        header('Content-Type: application/json');
        http_response_code($http);
        echo json_encode($table, JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}