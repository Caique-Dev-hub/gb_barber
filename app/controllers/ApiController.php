<?php

class ApiController extends Controller{

    // Cliente
    public function add_cadastro(){
        $input = file_get_contents('php://input');
        $input = json_decode($input, true);

        header('Content-Type: application/json');

        $verify = [];

        foreach($input as $campo => $valor){
            if(empty(trim($valor))){
                self::error(422, 'Preencha todos os campos');
                return;
            }

            switch($campo){
                case 'nome':
                    $verify['nome'] = filter_var($valor, FILTER_SANITIZE_SPECIAL_CHARS);

                    if(str_word_count($verify['nome']) < 2){
                        self::error(422, 'Insira o seu nome completo');
                        return;
                    }

                    $nome = str_word_count($verify['nome'], 1);

                    foreach($nome as $n){
                        if(strlen($n) < 2){
                            self::error(422, 'Cada parte do seu nome precisa conter 2 digitos ou mais');
                            return;
                        }
                    }

                    break;

                case 'email':
                    $verify['email'] = filter_var($valor, FILTER_SANITIZE_EMAIL);

                    if(!filter_var($verify['email'], FILTER_VALIDATE_EMAIL)){
                        self::error(422, 'Insira um E-mail valido');
                        return;
                    }

                    $key = base64_decode($_ENV['CRYPTO_KEY']);

                    $verify['email_hash'] = hash_hmac('sha256', $verify['email'], $key);

                    unset($key);

                    $getEmail = $this->db_cliente->getEmail($verify['email_hash']);

                    if($getEmail <> false){
                        self::error(409, 'E-mail ja esta sendo utilizado');
                        return;
                    }

                    $verify['email'] = Controller::criptografia($verify['email']);
                    break;

                case 'whatsapp':
                    $verify['whatsapp'] = filter_var($valor, FILTER_SANITIZE_SPECIAL_CHARS);

                    if(strlen($verify['whatsapp']) <> 15){
                        self::error(422, 'Whatsapp precisa conter 15 digitos');
                        return;
                    }

                    if(preg_match('/^\(\d{2}\) \d{5}-\d{4}$/', $verify['whatsapp']) === 0){
                        self::error(422, 'Formato de numero invalido');
                        return;
                    }

                    $key = base64_decode($_ENV['CRYPTO_KEY']);

                    $verify['whatsapp_hash'] = hash_hmac('sha256', $verify['whatsapp'], $key);

                    unset($key);

                    $getWhatsapp = $this->db_cliente->getWhatsapp($verify['whatsapp_hash']);

                    if($getWhatsapp <> false){
                        self::error(409, 'Whatsapp ja esta sendo utilizado');
                        return;
                    }

                    $verify['whatsapp'] = Controller::criptografia($verify['whatsapp']);
                    break;

                case 'senha':
                    $verify['senha'] = filter_var($valor, FILTER_SANITIZE_SPECIAL_CHARS);

                    if(strlen($verify['senha']) < 5){
                        self::error(422, 'Sua senha precisa conter 5 digitos ou mais');
                        return;
                    }

                    $verify['senha'] = password_hash($verify['senha'], PASSWORD_DEFAULT);
                    break;
            }
        }

        if(count($verify) <> 6){
            self::error(500, 'Erro ao fazer tratamento');
            return;
        }

        foreach($verify as $valor){
            if(empty(trim($valor))){
                self::error(500, 'Campo tratado esta vazio');
                return;
            }
        }

        $addCliente = $this->db_cliente->addCliente($verify);

        if(!$addCliente){
            self::error(500, 'Erro ao fazer cadastro dos dados do cliente');
            return;
        }

        self::success(201, 'Cadastro feito com sucesso');
        return;
    }

    public function listar_cadastro($id){
        header('Content-Type: application/json');

        $getDetails = $this->db_cliente->getDetailsCliente($id);

        if(!$getDetails){
            self::error(404, 'Erro ao retornar os detalhes do cliente');
            return;
        }

        foreach($getDetails as $atributo => $valor){
            if($atributo === 'email_cliente'){
                $email = Controller::descriptografia($valor);
            }

            if($atributo === 'whatsapp_cliente'){
                $whatsapp = Controller::descriptografia($valor);
            }
        }

        $getDetails['email_cliente'] = $email;
        $getDetails['whatsapp_cliente'] = $whatsapp;

        self::display(200, $getDetails);
        return;
    }

    public function atu_cadastro($id){
        $input = file_get_contents('php://input');
        $input = json_decode($input, true);

        header('Content-Type: application/json');

        $verify = [];

        foreach($input as $campo => $valor){
            if(empty(trim($valor))){
                self::error(422, 'Preencha todos os campos');
                return;
            }

            switch($campo){
                case 'nome':
                    $verify['nome'] = filter_var($valor, FILTER_SANITIZE_SPECIAL_CHARS);

                    if(str_word_count($verify['nome']) < 2){
                        self::error(422, 'Insira o seu nome completo');
                        return;
                    }

                    $nome = str_word_count($verify['nome'], 1);

                    foreach($nome as $n){
                        if(strlen($n) < 2){
                            self::error(422, 'Cada parte do seu nome precisa conter 2 digitos ou mais');
                            return;
                        }
                    }

                    break;

                case 'email':
                    $verify['email'] = filter_var($valor, FILTER_SANITIZE_EMAIL);

                    if(!filter_var($verify['email'], FILTER_VALIDATE_EMAIL)){
                        self::error(422, 'Insira um E-mail valido');
                        return;
                    }

                    $key = base64_decode($_ENV['CRYPTO_KEY']);

                    $verify['email_hash'] = hash_hmac('sha256', $verify['email'], $key);

                    unset($key);

                    $getEmail = $this->db_cliente->getEmail($verify['email_hash']);

                    if(count($getEmail) > 1){
                        self::error(409, 'E-mail ja esta registrado');
                        return;
                    }

                    $verify['email'] = Controller::criptografia($verify['email']);
                    
                    break;

                case 'whatsapp':
                    $verify['whatsapp'] = filter_var($valor, FILTER_SANITIZE_SPECIAL_CHARS);

                    if(strlen($verify['whatsapp']) <> 15){
                        self::error(422, 'Numero de Whatsapp precisa conter 15 digitos');
                        return;
                    }

                    if(preg_match('/^\(\d{2}\) \d{5}-\d{4}$/', $verify['whatsapp']) === 0){
                        self::error(422, 'Formato do numero invalido');
                        return;
                    }

                    $key = base64_decode($_ENV['CRYPTO_KEY']);

                    $verify['whatsapp_hash'] = hash_hmac('sha256', $verify['whatsapp'], $key);

                    unset($key);

                    $getWhatsapp = $this->db_cliente->getWhatsapp($verify['whatsapp_hash']);

                    if(count($getWhatsapp) > 1){
                        self::error(409, 'Whatsapp ja esta registrado');
                        return;
                    }

                    $verify['whatsapp'] = Controller::criptografia($verify['whatsapp']);

                    break;

                case 'senha':
                    $verify['senha'] = filter_var($valor, FILTER_SANITIZE_SPECIAL_CHARS);

                    if(strlen(trim($verify['senha'])) < 5){
                        self::error(422, 'Sua senha precisa conter 5 digitos ou mais');
                        return;
                    }

                    $verify['senha'] = password_hash($verify['senha'], PASSWORD_DEFAULT);

                    break;
            }
        }

        if(count($verify) < 6){
            self::error(500, 'Erro ao fazer tratamento');
            return;
        }

        foreach($verify as $valor){
            if(empty(trim($valor))){
                self::error(500, 'Erro ao tratar algum campo');
                return;
            }
        }

        $updateCliente = $this->db_cliente->updateCliente($verify, $id);

        if(!$updateCliente){
            self::error(500, 'Erro ao fazer update na tabela do cliente');
            return;
        }

        self::success(204, 'Dados atualizados com sucesso');
    }

    public function del_cadastro($id){
        header('Content-Type: application/json');

        $getCliente = $this->db_cliente->getDetailsCliente($id);

        if(!$getCliente){
            self::error(500, 'Esse cadastro nao existe');
            return;
        }

        $getAgeCom = $this->db_cliente->getAgendamentoComentario($id);

        if(count($getAgeCom) === 0){
            $delOne = $this->db_cliente->deleteClienteOne($id);

            if(!$delOne){
                self::error(500, 'Erro ao deletar cadastro');
                return;
            }

            self::success(200, 'Cadastro deletado com sucesso');
            return;

        } else{
            $delFull = $this->db_cliente->deleteClienteFull($id);

            if(!$delFull){
                self::error(500, 'Erro ao deletar dados do cadastro');
                return;
            }

            self::success(200, 'Cadastro deletado com sucesso');
            return;
        }
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