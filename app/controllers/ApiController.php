<?php

class ApiController extends Controller
{
    // Cliente
    public function add_cadastro(): void
    {
        $input = file_get_contents('php://input');
        $input = json_decode($input, true);

        header('Content-Type: application/json');

        $campos = ['nome', 'email', 'whatsapp', 'senha'];
        $erros = [];
        $camposTratados = [];

        if (count($input) <> count($campos)) {
            self::erro_servidor(400, 'Campo nao identificado foi incrementado no envio das informacoes, tentar novamente do jeito correto');
            return;
        }

        foreach ($campos as $valor) {
            if (empty(trim($input[$valor]))) {
                $erros['vazio'] = match($valor){
                    'nome' => "Preencha o seu nome",
                    'email' => "Preencha o seu E-mail",
                    'whatsapp' => "Preencha o seu whatsapp",
                    'senha' => "Preencha sua senha"
                };
                continue;
            }

            if (count($erros) > 0) {
                self::erro($erros);
                return;
            }

            match ($valor) {
                'nome' => $camposTratados[$valor] = self::tratar_nome($input[$valor]),
                'email' => $camposTratados[$valor] = self::tratar_email($input[$valor]),
                'whatsapp' => $camposTratados[$valor] = self::tratar_whatsapp($input[$valor]),
                'senha' => $camposTratados[$valor] = self::tratar_senha($input[$valor])
            };

            if (!$camposTratados[$valor]) {
                $erros[$valor] = match ($valor) {
                    'nome' => "O seu $valor precisa estar completo e ser valido",
                    'email' => "O seu $valor esta em um formato incorreto",
                    'whatsapp' => "O seu $valor esta no formato incorreto",
                    'senha' => "Sua $valor precia conter 5 digitos ou mais"
                };
                continue;
            }
        }

        if (count($erros) > 0) {
            self::erro($erros);
            return;
        }

        $camposTratados['email_hash'] = self::hash_email_whatsapp($camposTratados['email']);
        $camposTratados['whatsapp_hash'] = self::hash_email_whatsapp($camposTratados['whatsapp']);

        $getEmail = $this->db_cliente->getEmail($camposTratados['email_hash']);
        $getWhatsapp = $this->db_cliente->getWhatsapp($camposTratados['whatsapp_hash']);

        if ($getEmail <> false || $getWhatsapp <> false) {
            self::erro_servidor(409, 'E-mail ou whatsapp ja esta sendo utilizado');
            return;
        }

        $camposTratados['email'] = Controller::criptografia($camposTratados['email']);
        $camposTratados['whatsapp'] = Controller::criptografia($camposTratados['whatsapp']);

        $addCliente = $this->db_cliente->addCliente($camposTratados);

        if (!$addCliente) {
            self::erro_servidor(500, 'Erro ao adicionar cadastro');
            return;
        }

        self::sucesso(201, 'Cadastro realizado com sucesso');
        return;
    }

    public function login_whatsapp(): void
    {
        $input = file_get_contents('php://input');
        $input = json_decode($input, true);

        header('Content-Type: application/json');

        $campos = ['email', 'whatsapp'];
        $erros = [];
        $camposTratados = [];

        if (count($input) <> count($campos)) {
            self::erro_servidor(400, 'Campo invalido foi identificado, tente novamente do jeito correto');
            return;
        }

        foreach ($campos as $valor) {
            if (empty(trim($input[$valor]))) {
                $erros['vazio'] = match($valor){
                    'email' => "O E-mail precisa ser preenchido",
                    'whatsapp' => "O whatsapp precisa ser preenchido"
                };
                continue;
            }

            if (count($erros) > 0) {
                self::erro($erros);
                return;
            }

            match ($valor) {
                'email' => $camposTratados[$valor] = self::tratar_email($input[$valor]),
                'whatsapp' => $camposTratados[$valor] = self::tratar_whatsapp($input[$valor])
            };

            if (!$camposTratados[$valor]) {
                $erros[$valor] = match ($valor) {
                    'email' => "Insira um E-mail valido",
                    'whatsapp' => "Formato de whatsapp invalido"
                };
                continue;
            }
        }

        if (count($erros) > 0) {
            self::erro($erros);
            return;
        }

        $hashEmail = self::hash_email_whatsapp($camposTratados['email']);

        $getEmail = $this->db_cliente->getEmail($hashEmail);

        if (!$getEmail) {
            self::erro_servidor(404, 'Cadastro nao identificado');
            return;
        }

        $hashWhatsapp = self::hash_email_whatsapp($camposTratados['whatsapp']);

        if ($getEmail['whatsapp_hash'] !== $hashWhatsapp) {
            self::erro_servidor(404, 'Cadastro nao identificado');
            return;
        }

        self::sucesso(200, 'Login realizado com sucesso');
        return;
    }

    public function login_senha(): void
    {
        $input = file_get_contents('php://input');
        $input = json_decode($input, true);

        header('Content-Type: application/json');

        $campos = ['email', 'senha'];
        $erros = [];
        $camposTratados = [];

        if(count($campos) <> count($input)){
            self::erro_servidor(400, 'Campo invalido foi identificado, tentar novamente do jeito correto');
            return;
        }

        foreach($campos as $valor){
            if(empty(trim($input[$valor]))){
                $erros['vazio'] = match($valor){
                    'email' => "O E-mail precia ser preenchido",
                    'senha' => "A $valor precia ser preenchida"
                };
                continue;
            }

            if(count($erros) > 0){
                self::erro($erros);
                return;
            }

            if($valor === 'email'){
                $camposTratados[$valor] = self::tratar_email($input[$valor]);
                
                if(!$camposTratados[$valor]){
                    $erros[$valor] = "O E-mail esta no formato incorreto";
                    continue;
                }
            }

            if($valor === 'senha'){
                if(strlen($input[$valor]) < 5){
                    $erros[$valor] = "Sua senha precisa conter 5 digitos ou mais";
                    continue;
                } else{
                    $camposTratados[$valor] = $input[$valor];
                    continue;
                }
            }
        }

        if(count($erros) > 0){
            self::erro($erros);
            return;
        }

        $getEmail = $this->db_cliente->getEmail(self::hash_email_whatsapp($camposTratados['email']));

        if(!$getEmail){
            self::erro_servidor(404, 'Cadastro nao foi encontrado');
            return;
        }

        if(!password_verify($camposTratados['senha'], $getEmail['senha_cliente'])){
            self::erro_servidor(404, 'Cadastro nao foi encontrado');
            return;
        }

        self::sucesso(200, 'Login realizado com sucesso');
        return;
    }

    public function atu_cadastro($id): void
    {
        $input = file_get_contents('php://input');
        $input = json_decode($input, true);

        header('Content-Type: application/json');

        $campos = ['nome', 'email', 'whatsapp', 'senha'];
        $erros = [];
        $camposTratados = [];

        if(count($input) <> count($campos)){
            self::erro_servidor(400, 'Campo invalido foi identificado, tentar novamente do jeito correto');
            return;
        }

        foreach($campos as $valor){
            if(empty(trim($input[$valor]))){
                $erros['vazio'] = match($valor){
                    'nome' => "O seu nome esta vazio",
                    'email' => "O seu E-mail esta vazio",
                    'whatsapp' => "O seu whatsapp esta vazio",
                    'senha' => "Sua senha esta vazia"
                };
                continue;
            }

            if(count($erros) > 0){
                self::erro($erros);
                return;
            }

            match($valor){
                'nome' => $camposTratados[$valor] = self::tratar_nome($input[$valor]),
                'email' => $camposTratados[$valor] = self::tratar_email($input[$valor]),
                'whatsapp' => $camposTratados[$valor] = self::tratar_whatsapp($input[$valor]),
                'senha' => $camposTratados[$valor] = self::tratar_senha($input[$valor])
            };

            if(!$camposTratados[$valor]){
                $erros[$valor] = match($valor){
                    'nome' => "Insira o seu nome completo e que seja valido",
                    'email' => "Insira um E-mail valido",
                    'whatsapp' => "Insira o seu whatsapp no formato correto (00) 00000-0000",
                    'senha' => "Sua senha precisa conter 5 digitos ou mais"
                };
                continue;
            }
        }

        if(count($erros) > 0){
            self::erro($erros);
            return;
        }

        $camposTratados['email_hash'] = self::hash_email_whatsapp($camposTratados['email']);
        $camposTratados['whatsapp_hash'] = self::hash_email_whatsapp($camposTratados['whatsapp']);

        $getEmail = $this->db_cliente->getEmailTodos($camposTratados['email_hash']);

        if(count($getEmail) > 1){
            self::erro_servidor(409, 'E-mail ja esta sendo utilizado');
            return;
        }

        $getWhatsapp = $this->db_cliente->getWhatsappTodos($camposTratados['whatsapp_hash']);

        if(count($getWhatsapp) > 1){
            self::erro_servidor(409, 'Whatsapp ja esta sendo utilizado');
            return;
        }

        $camposTratados['email'] = Controller::criptografia($camposTratados['email']);
        $camposTratados['whatsapp'] = Controller::criptografia($camposTratados['whatsapp']);

        $updateCliente = $this->db_cliente->updateCliente($camposTratados, $id);

        if(!$updateCliente){
            self::erro_servidor(500, 'Erro ao atualizar os dados');
            return;
        }

        self::sucesso(200, 'Dados atualizados com sucesso');
        return;
    }

    public function listar_cadastro($id): void
    {
        header('Content-Type: application/json');

        $getCliente = $this->db_cliente->getDetailsCliente($id);

        if(!$getCliente){
            self::erro_servidor(500, 'Erro ao retornar os dados do banco');
            return;
        }

        $getCliente['email_cliente'] = Controller::descriptografia($getCliente['email_cliente']);
        $getCliente['whatsapp_cliente'] = Controller::descriptografia($getCliente['whatsapp_cliente']);

        self::exibir_dados($getCliente);
        return;
    }



    // Servicos
    public function listar_servicos(): void
    {
        header('Content-Type: application/json');

        $getServicos = $this->db_servico->getServicos();
        
        if(!$getServicos){
            self::erro_servidor(500, 'Erro ao retornar servicos');
            return;
        }

        $getCombos = $this->db_servico->getCombos();

        if(!$getCombos){
            self::erro_servidor(500, 'Erro ao retornar combos');
            return;
        }

        $todosServicos = array_merge($getServicos, $getCombos);

        self::exibir_dados($todosServicos);
        return;
    }

    public function listar_detalhe($id): void
    {
        header('Content-Type: application/json');

        $id = (int)$id;

        if($id > 3){
            $id -= 3;

            $getCombo = $this->db_servico->getDetalhe_combo($id);

            if(!$getCombo){
                self::erro_servidor(500, 'Erro ao retornar detalhes do combo');
                return;
            }

            self::exibir_dados($getCombo);
            return;
        } else{
            $getServico = $this->db_servico->getDetalhe_servico($id);

            if(!$getServico){
                self::erro_servidor(500, 'Erro ao retornar detalhes do servico');
                return;
            }

            self::exibir_dados($getServico);
            return;
        }
    }




    // Data
    public function listar_datas(): void
    {
        header('Content-Type: application/json');

        $exibirDatas = [];
        $diaAtual = date('d');

        $getDatas = $this->db_data->getDatas();

        if(!$getDatas){
            self::erro_servidor(500, 'Erro ao retornar todas as datas');
            return;
        }

        foreach($getDatas as $atributo){
            $data = explode('-', $atributo['nome_data']);

            if((int)$data[2] >= (int)$diaAtual){
                $exibirDatas[] = $atributo;
            }
        }

        self::exibir_dados($exibirDatas);
        return;
    }

    public function listar_horarios($data): void
    {
        header('Content-Type: application/json');

        $getHorarios = $this->db_data->getHorarios($data);

        if(!$getHorarios){
            self::erro_servidor(500, 'Erro ao retornar os horarios dessa data');
            return;
        }

        self::exibir_dados($getHorarios);
        return;
    }










    // ---------------------------- Metodos auxiliares ------------------------------------- //

    // Respostas
    private static function erro(array $mensagens): void
    {
        header('Content-Type: application/json');
        http_response_code(422);
        echo json_encode($mensagens, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    private static function sucesso(int $http, string $mensagem): void
    {
        header('Content-Type: application/json');
        http_response_code($http);
        echo json_encode([
            'sucesso' => $mensagem
        ]);
    }

    private static function exibir_dados(array $dados): void
    {
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode($dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
    }

    private static function erro_servidor(int $http, string $mensagem): void
    {
        header('Content-Type: application/json');
        http_response_code($http);
        echo json_encode([
            'erro' => $mensagem
        ]);
    }




    // Tratamento
    private static function tratar_nome(string $nome): string|bool
    {
        $nomeTratado = trim($nome);
        $nomeTratado = filter_var($nomeTratado, FILTER_SANITIZE_SPECIAL_CHARS);

        if (str_word_count($nomeTratado) < 2) {
            return false;
        }

        $nomeTratado = str_word_count($nomeTratado, 1);

        foreach ($nomeTratado as $valor) {
            if (strlen($valor) < 2) {
                return false;
            }
        }

        $nomeTratado = implode(' ', $nomeTratado);

        return $nomeTratado;
    }

    private static function tratar_email(string $email): string|bool
    {
        $emailTratado = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (!filter_var($emailTratado, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        return $emailTratado;
    }

    private static function tratar_whatsapp(string $whatsapp): string|bool
    {
        $whatsappTratado = filter_var($whatsapp, FILTER_SANITIZE_SPECIAL_CHARS);

        if (preg_match('/^\(\d{2}\) \d{5}-\d{4}$/', $whatsappTratado) !== 1) {
            return false;
        }

        return $whatsappTratado;
    }

    private static function tratar_senha(string $senha): string|bool
    {
        $senhaTratada = filter_var($senha, FILTER_SANITIZE_SPECIAL_CHARS);

        if (strlen($senhaTratada) < 5) {
            return false;
        }

        $senhaTratada = password_hash($senhaTratada, PASSWORD_DEFAULT);

        return $senhaTratada;
    }

    private static function hash_email_whatsapp(string $emailWhatsapp): string
    {
        $key = $_ENV['CRYPTO_KEY'];

        $hash = hash_hmac('sha256', $emailWhatsapp, $key);

        return $hash;
    }
}
