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

        if(count($campos) <> count($input)){
            self::erro('Envio do formulario foi corrompido, tentar novamente do jeito correto', 400);
            return;
        }

        foreach($input as $campo => $valor){
            if(empty(trim($valor))){
                match($campo){
                    'nome' => self::erro('Seu nome nao foi preenchido, tentar novamente com todos os campos preenchidos'),
                    'email' => self::erro('Seu E-mail nao foi preenchido, tentar novamente com todos os campos preenchidos'),
                    'whatsapp' => self::erro('Seu numero de whatsapp nao foi preenchido, tentar novamente com todos os campos preenchidos'),
                    'senha' => self::erro('Sua senha nao foi preenchida, tentar novamente com todos os campos preenchidos')
                };
                return;
            }

            match($campo){
                'nome' => $camposTratados['nome'] = self::tratar_nome($valor),
                'email' => $camposTratados['email'] = self::tratar_email($valor),
                'whatsapp' => $camposTratados['whatsapp'] = self::tratar_whatsapp($valor),
                'senha' => $camposTratados['senha'] = self::tratar_senha($valor)
            };

            if(!$camposTratados[$campo]){
                $erros[$campo] = match($campo){
                    'nome' => 'Insira o seu nome completo e valido',
                    'email' => 'Insira um E-mail valido',
                    'whatsapp' => 'Insira um numero de whatsapp no formato correto',
                    'senha' => 'Sua senha precisa conter 5 digitos ou mais'
                };
                continue;
            }
        }

        if(isset($erros)){
            self::erro($erros);
            return;
        }

        $camposTratados['email_hash'] = self::hash_email_whatsapp($camposTratados['email']);
        $camposTratados['whatsapp_hash'] = self::hash_email_whatsapp($camposTratados['whatsapp']);

        $getEmail = $this->db_cliente->getEmail($camposTratados['email_hash']);
        $getWhatsapp = $this->db_cliente->getWhatsapp($camposTratados['whatsapp_hash']);

        if($getEmail <> false || $getWhatsapp <> false){
            self::erro('E-mail ou whatsapp ja esta sendo utlizado', 409);
            return;
        }

        $camposTratados['email'] = Controller::criptografia($camposTratados['email']);
        $camposTratados['whatsapp'] = Controller::criptografia($camposTratados['whatsapp']);

        $addCadastro = $this->db_cliente->addCliente($camposTratados);

        if(!$addCadastro){
            self::erro('Erro ao realizar cadastro', 500);
            return;
        }

        self::sucesso('Cadastro realizado com sucesso', 201);
        return;
    }

    public function login_senha(): void
    {
        $input = file_get_contents('php://input');
        $input = json_decode($input, true);

        header('Content-Type: application/json');

        $campos = ['email', 'senha'];

        if(count($campos) <> count($input)){
            self::erro('Envio do formulario foi corrompido, tentar novamente do jeito correto', 400);
            return;
        }

        foreach($input as $campo => $valor){
            if(empty(trim($valor))){
                $erros[$campo] = match($campo){
                    'email' => "Seu E-mail nao foi preenchido, tentar novamente com todos os campos preenchidos",
                    'senha' => "Sua senha nao foi preenchida, tentar novamente com todos os campos preenchidos"
                };
                continue;
            }

            if(isset($erros)){
                self::erro($erros);
                return;
            }

            match($campo){
                'email' => $camposTratados['email'] = self::tratar_email($valor),
                'senha' => $camposTratados['senha'] = self::tratar_senha($valor)
            };

            if(!$camposTratados[$campo]){
                $erros[$campo] = match($campo){
                    'email' => "Insira um E-mail valido",
                    'senha' => "Sua senha precisa conter 5 digitos ou mais"
                };
                continue;
            }
        }

        if(isset($erros)){
            self::erro($erros);
            return;
        }

        $hashEmail = self::hash_email_whatsapp($camposTratados['email']);

        $getEmail = $this->db_cliente->getEmail($hashEmail);

        if(!$getEmail){
            self::erro('Cadastro nao encontrado', 404);
            return;
        }

        if(!password_verify($camposTratados['senha'], $getEmail['senha_cliente'])){
            self::erro('Cadastro nao encontrado', 404);
            return;
        }

        self::exibir_dados($getEmail);
        return;
    }

    public function listar_cadastro($id): void
    {
        header('Content-Type: application/json');

        $getCliente = $this->db_cliente->getDetailsCliente($id);

        if(!$getCliente){
            self::erro('Erro ao retornar detalhes do cliente');
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
            self::erro('Erro ao retornar todos os servicos', 500);
            return;
        }

        $getCombos = $this->db_servico->getCombos();

        if(!$getCombos){
            self::erro('Erro ao retornar todos os combos', 500);
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
            self::erro('Erro ao retornar todos os detalhes do combo', 500);
                return;
            }

            self::exibir_dados($getCombo);
            return;
        } else{
            $getServico = $this->db_servico->getDetalhe_servico($id);

            if(!$getServico){
            self::erro('Erro ao retornar todos os detalhes do servico', 500);
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
            self::erro('Erro ao retornar todos as datas', 500);
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
            self::erro('Erro ao retornar todos os horarios', 500);
            return;
        }

        self::exibir_dados($getHorarios);
        return;
    }










    // ---------------------------- Metodos auxiliares ------------------------------------- //

    // Respostas
    private static function erro(array|string $mensagem, int $http = 422): void
    {
        header('Content-Type: application/json');
        http_response_code($http);

        if(is_string($mensagem)){
            echo json_encode([
                'erro' => $mensagem
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        } else{
            echo json_encode($mensagem, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }
    }

    private static function sucesso(string $mensagem, int $http = 200): void
    {
        header('Content-Type: application/json');
        http_response_code($http);
        echo json_encode([
            'sucesso' => $mensagem
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    private static function exibir_dados(array $dados): void
    {
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode($dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK | JSON_UNESCAPED_UNICODE);
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

        return $senhaTratada;
    }

    private static function hash_email_whatsapp(string $emailWhatsapp): string
    {
        $key = $_ENV['CRYPTO_KEY'];

        $hash = hash_hmac('sha256', $emailWhatsapp, $key);

        return $hash;
    }
}
