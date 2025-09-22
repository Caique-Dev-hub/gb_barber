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

        foreach($campos as $valor){
            if(!isset($input[$valor])){
                self::erro('Campo obrigatório não identificado, tentar novamente pelo formulário', 400);
                return;
            }
        }

        if(count($input) !== count($campos)){
            self::erro('Envio formulário corrompido', 400);
            return;
        }

        foreach($input as $campo => $valor){
            match($campo){
                'nome' => $tratado['nome'] = self::tratar_nome($valor),
                'email' => $tratado['email'] = self::tratar_email($valor),
                'whatsapp' => $tratado['whatsapp'] = self::tratar_whatsapp($valor),
                'senha' => $tratado['senha'] = self::tratar_senha($valor)
            };

            if(!$tratado[$campo]){
                $erros['erro'] = match($campo){
                    'nome' => 'Insira o seu nome completo',
                    'email' => 'Insira um E-mail válido',
                    'whatsapp' => 'Insira um numero de Whatsapp no formato (xx) xxxxx-xxxx ou (xx) xxxx-xxxx',
                    'senha' => 'Sua senha precisa conter 5 dígitos ou mais'
                };
            }
        }

        if(isset($erros)){
            self::erro($erros);
            return;
        }

        $tratado['email_hash'] = self::hash_email_whatsapp($tratado['email']);

        $getEmail = $this->db_cliente->getEmail($tratado['email_hash']);

        if($getEmail !== false){
            self::erro('Dados inseridos já estão sendo utilizados', 409);
            return;
        }

        $tratado['whatsapp_hash'] = self::hash_email_whatsapp($tratado['whatsapp']);

        $getWhatsapp = $this->db_cliente->getWhatsapp($tratado['whatsapp_hash']);

        if($getWhatsapp !== false){
            self::erro('Dados inseridos já estão sendo utilizados', 409);
            return;
        }

        $tratado['email'] = Controller::criptografia($tratado['email']);
        $tratado['whatsapp'] = Controller::criptografia($tratado['whatsapp']);
        $tratado['senha'] = password_hash($tratado['senha'], PASSWORD_DEFAULT);

        $addCadastro = $this->db_cliente->addCadastro($tratado);

        if(!$addCadastro){
            self::erro('Erro ao realizar cadastro', 500);
            return;
        }

        $getCliente = $this->db_cliente->getDetalheCliente((int)$addCadastro);

        if(!$getCliente){
            self::erro('Erro ao retornar dados do cadastro', 500);
            return;
        }

        $dadosToken = [
            'id' => $getCliente['id_cliente'],
            'nome' => $getCliente['nome_cliente'],
            'email' => $getCliente['email_cliente'],
            'exp' => time() + 3600
        ];

        $token = Token::gerar_token($dadosToken);

        self::sucesso($token, 201);
        return;
    }

    public function login_whatsapp(): void
    {
        $input = file_get_contents('php://input');
        $input = json_decode($input, true);

        header('Content-Type: application/json');

        $campos = ['email', 'whatsapp'];

        foreach($campos as $valor){
            if(!isset($input[$valor])){
                self::erro('Não identificamos um campo obrigatório na requisição, tentar novamente pelo formulário de Login', 400);
                return;
            }
        }

        if(count($input) !== count($campos)){
            self::erro('Envio do formulário corrompido', 400);
            return;
        }

        foreach($input as $campo => $valor){
            match($campo){
                'email' => $tratado['email'] = self::tratar_email($valor),
                'whatsapp' => $tratado['whatsapp'] = self::tratar_whatsapp($valor)
            };

            if(!$tratado[$campo]){
                $erros[$campo] = match($campo){
                    'email' => 'Insira um E-mail valido',
                    'whatsapp' => 'Insira um numero de whatsapp no formato (xx) xxxxx-xxxx ou (xx) xxxx-xxxx'
                };
            }
        }

        if(isset($erros)){
            self::erro($erros);
            return;
        }

        $email_hash = self::hash_email_whatsapp($tratado['email']);

        $getEmail = $this->db_cliente->getEmail($email_hash);

        if(!$getEmail){
            self::erro('Dados inseridos nao registrados', 404);
            return;
        }

        $whatsapp_hash = self::hash_email_whatsapp($tratado['whatsapp']);

        if(!hash_equals($getEmail['whatsapp_hash'], $whatsapp_hash)){
            self::erro('Dados inseridos nao encontrado', 404);
            return;
        }

        $dadosToken = [
            'id' => $getEmail['id_cliente'],
            'nome' => $getEmail['nome_cliente'],
            'email' => $getEmail['email_cliente'],
            'exp' => time() + 3600
        ];

        $token = Token::gerar_token($dadosToken);

        self::sucesso($token);
        return;
    }

    public function login_senha(): void
    {
        $input = file_get_contents('php://input');
        $input = json_decode($input, true);

        header('Content-Type: application/json');

        $campos = ['email', 'senha'];

        foreach($campos as $valor){
            if(!isset($input[$valor])){
                self::erro('Não identificamos um campo obrigatório na requisição, tentar novamente pelo formulário de Login', 404);
                return;
            }
        }

        if(count($input) !== count($campos)){
            self::erro('Envio do formulário corrompido', 400);
            exit;
        }

        foreach($input as $campo => $valor){
            match($campo){
                'email' => $tratado['email'] = self::tratar_email($valor),
                'senha' => $tratado['senha'] = self::tratar_senha($valor)
            };

            if(!$tratado[$campo]){
                $erros[$campo] = match($campo){
                    'email' => 'Insira um E-mail válido',
                    'senha' => 'Sua senha precisa conter 5 dígitos ou mais'
                };
            }
        }

        if(isset($erros)){
            self::erro($erros);
            return;
        }

        $email_hash = self::hash_email_whatsapp($tratado['email']);

        $getEmail = $this->db_cliente->getEmail($email_hash);

        if(!$getEmail){
            self::erro('Dados inseridos não estão registrados', 404);
            return;
        }

        if(!password_verify($tratado['senha'], $getEmail['senha_cliente'])){
            self::erro('Dados inseridos não estão registrados', 404);
            return;
        }

        $dadosToken = [
            'id' => $getEmail['id_cliente'],
            'nome' => $getEmail['nome_cliente'],
            'email' => $getEmail['email_cliente'],
            'exp' => time() + 3600
        ];

        $token = Token::gerar_token($dadosToken);

        self::sucesso($token);
        return;
    }

    public function atu_cadastro(int $id): void
    {
        header('Content-Type: application/json');

        $payload = $this->verificar($id);

        if(is_null($payload)){
            self::erro('Token expirado ou invalido', 400);
            return;
        }

        $input = file_get_contents('php://input');
        $input = json_decode($input, true);

        $campos = ['nome', 'email', 'whatsapp', 'senha'];

        foreach($campos as $valor){
            if(!isset($input[$valor])){
                self::erro('Campo obrigatorio nao identificado', 404);
                return;
            }
        }

        if(count($input) !== count($campos)){
            self::erro('Envio do formulario corrompido', 400);
            return;
        }

        foreach($input as $campo => $valor){
            if($campo === 'senha'){
                continue;
            }

            match($campo){
                'nome' => $tratado['nome'] = self::tratar_nome($valor),
                'email' => $tratado['email'] = self::tratar_email($valor),
                'whatsapp' => $tratado['whatsapp'] = self::tratar_whatsapp($valor)
            };

            if(!$tratado[$campo]){
                $erros['erro'] = match($campo){
                    'nome' => 'Insira seu nome completo e valido',
                    'email' => 'Insira seu E-mail valido',
                    'whatsapp' => 'Insira seu numero de Whatsapp no formato (xx) xxxxx-xxxx ou (xx) xxxx-xxxx'
                };
            }
        }

        if(is_string($input['senha'])){
            $tratado['senha'] = self::tratar_senha($input['senha']);

            if(!$tratado['senha']){
                $erros['erro'] = 'Sua senha precisa conter 5 digitos ou mais';
            } else {
                $tratado['senha'] = password_hash($tratado['senha'], PASSWORD_DEFAULT);
            }
        } else {
            $tratado['senha'] = $input['senha'];
        }

        if(isset($erros)){
            self::erro($erros);
            return;
        }

        $email_hash = self::hash_email_whatsapp($tratado['email']);

        $getEmail = $this->db_cliente->getEmailAtu($email_hash, $id);

        if($getEmail !== false){
            self::erro('Dados inseridos ja estao sendo utilizados', 409);
            return;
        }

        $whatsapp_hash = self::hash_email_whatsapp($tratado['whatsapp']);

        $getWhatsapp = $this->db_cliente->getWhatsappAtu($whatsapp_hash, $id);

        if($getWhatsapp !== false){
            self::erro('Dados inseridos ja estao sendo utilizados', 409);
            return;
        }

        $tratado['email'] = Controller::criptografia($tratado['email']);
        $tratado['whatsapp'] = Controller::criptografia($tratado['whatsapp']);

        $tratado['email_hash'] = $email_hash;
        $tratado['whatsapp_hash'] = $whatsapp_hash;

        $updateCadastro = $this->db_cliente->updateCadastro($tratado, $id);

        if(!$updateCadastro){
            self::erro('Erro ao atualizar cadastro', 500);
            return;
        }

        self::sucesso('Cadastro atualizado com sucesso');
        return;
    }

    public function listar_login(int $id): void
    {
        $payload = $this->verificar($id);

        if(is_null($payload)){
            self::erro('Token invalido', 404);
            return;
        }

        header('Content-Type: application/json');

        $getLogin = $this->db_cliente->getDetalheCliente((int)$payload['id']);

        if(!$getLogin){
            self::erro('Erro ao retornar dados do Login', 500);
            return;
        }

        $listarLogin['nome'] = $getLogin['nome_cliente'];
        $listarLogin['email'] = Controller::descriptografia($getLogin['email_cliente']);
        $listarLogin['whatsapp'] = Controller::descriptografia($getLogin['whatsapp_cliente']);

        self::exibir_dados($listarLogin);
        return;
    }

    public function deletar_cadastro(int $id): void
    {
        header('Content-Type: application/json');

        $payload = $this->verificar($id);

        if(is_null($payload)){
            self::erro('Token expirado ou invalido', 400);
            return;
        }

        $deleteCadastro = $this->db_cliente->deleteCadastro($id);

        if(!$deleteCadastro){
            self::erro('Erro ao deletar cadastro', 500);
            return;
        }

        self::sucesso('Cadastro deletado com sucesso', 200);
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
            self::erro('Erro ao retornar todos os combos');
            return;
        }

        $total = array_merge($getServicos, $getCombos);

        self::exibir_dados($total);
        return;
    }

    public function listar_detalhe(string $nomeServico): void
    {
        header('Content-Type: application/json');

        $getServicos = $this->db_servico->getServicos();

        if(!$getServicos){
            self::erro('Erro ao retornar todos os servicos', 500);
            return;
        }

        $getCombos = $this->db_servico->getCombos();

        if(!$getCombos){
            self::erro('Erro ao retornar todos os combos');
            return;
        }

        $total = array_merge($getServicos, $getCombos);

        foreach($total as $atributo){
            $nome = $atributo['nome_servico'] ?? $atributo['nome_combo'];

            if(self::tratar_url($nome) === $nomeServico){
                $detalheServico = $atributo;
            }
        }

        if(!isset($detalheServico)){
            self::erro('Erro ao buscar detalhes do servico', 500);
            return;
        }

        self::exibir_dados($detalheServico);
        return;
    }








    // Data
    public function listar_datas(): void
    {
        header('Content-Type: application/json');

        $datas = $this->db_data->getDatas();

        if(!$datas){
            self::erro('Erro ao retornar todas as datas', 500);
            return;
        }

        self::exibir_dados($datas);
        return;
    }

    public function listar_horarios_data(int $id_data): void
    {
        header('Content-Type: application/json');

        $getHorarioData = $this->db_data->getHorarios($id_data);

        if(!$getHorarioData){
            self::erro('Erro ao retornar todos os horarios da data', 500);
            return;
        }

        self::exibir_dados($getHorarioData);
        return;
    }






    // Comentario
    public function add_comentario(int $id): void
    {
        header('Content-Type: application/json');

        $payload = $this->verificar($id);

        if(is_null($payload)){
            self::erro('Token expirado ou invalido', 400);
            return;
        }

        $input = file_get_contents('php://input');
        $input = json_decode($input, true);

        if(!isset($input['mensagem'])){
            self::erro('Campo obrigatorio nao encontrado', 404);
            return;
        }

        if(count($input) !== 1){
            self::erro('Envio do formulario corrompido', 400);
            return;
        }


        $mensagem = trim(filter_var($input['mensagem'], FILTER_SANITIZE_SPECIAL_CHARS));

        if(str_word_count($mensagem) < 5){
            self::erro('Mensagem muito curta');
            return;
        }

        $addComentario = $this->db_contato->addComentario($id, $mensagem);

        if(!$addComentario){
            self::erro('Erro ao adicionar comentario', 500);
            return;
        }

        self::sucesso('Comentario adicionado com sucesso', 201);
        return;
    }

    public function atu_comentario(int $comentario, int $id): void
    {
        header('Content-Type: application/json');

        $payload = $this->verificar($id);

        if(is_null($payload)){
            self::erro('Token expirado ou invalido');
            return;
        }

        $input = file_get_contents('php://input');
        $input = json_decode($input, true);

        if(!isset($input['mensagem'])){
            self::erro('Campo obrigatorio nao identificado', 404);
            return;
        }

        if(count($input) !== 1){
            self::erro('Envio do formulario corrompido', 400);
            return;
        }

        
        $mensagem = filter_var($input['mensagem'], FILTER_SANITIZE_SPECIAL_CHARS);

        if(str_word_count($mensagem) < 5 || strlen($mensagem) < 5){
            self::erro('Sua mensagem esta muito curta');
            return;
        }

        $updateComentario = $this->db_contato->updateComentario($comentario, $mensagem);

        if(!$updateComentario){
            self::erro('Erro ao atualizar comentario', 500);
            return;
        }

        self::sucesso('Comentario atualizado com sucesso');
        return;
    }

    public function listar_comentario_cliente(int $id): void
    {
        header('Content-Type: application/json');

        $payload = $this->verificar($id);

        if(is_null($payload)){
            self::erro('Token expirado ou inválido', 400);
            return;
        }

        $getComentario = $this->db_contato->getComentariosCliente($id);

        if(!$getComentario){
            self::erro('Erro ao exibir comentario do cliente', 500);
            return;
        }

        self::exibir_dados($getComentario);
        return;
    }

    public function deletar_comentario(int $id, int $id_cliente): void
    {
        header('Content-Type: application/json');

        $payload = $this->verificar($id_cliente);

        if(is_null($payload)){
            self::erro('Token expirado ou inválido', 400);
            return;
        }

        $deleteComentario = $this->db_contato->deleteComentario($id);

        if(!$deleteComentario){

        }
    }

    




    // Notificacao
    public function listar_notificacao(int $id): void
    {
        header('Content-Type: application/json');

        $payload = $this->verificar($id);

        if(is_null($payload)){
            self::erro('Token expirado ou invalido', 400);
            return;
        }

        $getNotificacao = $this->db_notificacao->getNotificacao($id);

        if(!$getNotificacao){
            self::erro('Erro ao retornar dados da notificacao', 500);
            return;
        }

        self::exibir_dados($getNotificacao);
        return;
    }






    // -------------------------------- Metodos auxiliares ------------------------------------- //
    
    // Validar Token
    public function verificar(int $id): ?array
    {
        $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

        if(preg_match('/Bearer\s(\S+)/', $token, $conteudo) !== 1){
            return null;
        }

        $payload = Token::validar_token($conteudo[1]);

        if(is_null($payload)){
            return null;
        }

        if((int)$payload['id'] !== $id){
            return null;
        }

        return $payload;
    }



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
            if(preg_match('/^\(\d{2}\) \d{4}-\d{4}$/', $whatsappTratado) !== 1){
                return false;
            }
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
