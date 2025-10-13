<?php

class ApiController extends Controller
{
    // Cliente
    public function add_cadastro(): void
    {
        header('Content-Type: applcation/json');

        $input = file_get_contents('php://input');
        $input = json_decode($input, true);

        $campos = ['nome', 'email', 'whatsapp', 'senha'];

        foreach ($campos as $valor) {
            if (!isset($input[$valor])) {
                self::erro('Campo obrigátorio não identificado', 404);
                return;
            }
        }

        if (count($input) !== count($campos)) {
            self::erro('Envio de dados adicionais', 400);
            return;
        }

        foreach ($input as $campo => $valor) {
            match ($campo) {
                'nome' => $input[$campo] = self::tratar_nome($valor),
                'email' => $input[$campo] = self::tratar_email($valor),
                'whatsapp' => $input[$campo] = self::tratar_whatsapp($valor),
                'senha' => $input[$campo] = self::tratar_senha($valor)
            };

            if (is_null($input[$campo])) {
                $erros['error'] = match ($campo) {
                    'nome' => 'Insira o seu nome completo',
                    'email' => 'Insira um E-mail válido',
                    'whatsapp' => 'Insira um numero de Whatsapp válido, no formato (xx) xxxxx-xxxx ou (xx) xxxx-xxxx',
                    'senha' => 'Insira uma senha com no minímo 5 digítos'
                };
            }
        }

        if (isset($erros) || !empty($erros)) {
            self::erro($erros);
            return;
        }

        $input['emailHash'] = self::hash_email_whatsapp($input['email']);

        $getEmailHash = $this->db_cliente->getEmailCadastro($input['emailHash']);

        if (is_null($getEmailHash)) {
            self::erro('Erro ao verificar a existencia do E-mail de cadastro', 500);
            return;
        }

        if ($getEmailHash > 0) {
            self::erro('Dados já estão sendo utilizados', 409);
            return;
        }

        $input['whatsappHash'] = self::hash_email_whatsapp($input['whatsapp']);

        $getWhatsappHash = $this->db_cliente->getWhatsappCadastro($input['whatsappHash']);

        if (is_null($getWhatsappHash)) {
            self::erro('Erro ao verificar a existencia do Whatsapp de cadastro', 500);
            return;
        }

        if ($getWhatsappHash > 0) {
            self::erro('Dados já estão sendo utilizados', 409);
            return;
        }

        $input['email'] = Controller::criptografia($input['email']);
        $input['whatsapp'] = Controller::criptografia($input['whatsapp']);

        $input['senha'] = password_hash($input['senha'], PASSWORD_DEFAULT);

        $addCadastro = $this->db_cliente->addCadastro($input);

        if (is_null($addCadastro)) {
            self::erro('Erro ao adicionar cadastro', 500);
            return;
        }

        $dataToken = [
            'id' => $addCadastro,
            'nome' => $input['nome'],
            'exp' => time() + 3600
        ];

        $token = Token::gerar_token($dataToken);

        if (!$token) {
            self::erro('Erro ao realizar cadastro', 500);
            return;
        }

        self::sucesso($token, 201);
        return;
    }

    public function login_cliente(): void
    {
        header('Content-Type: application/json');

        $input = file_get_contents('php://input');
        $input = json_decode($input, true);

        $campos = ['email', 'whatsapp', 'senha'];

        if (!isset($input['whatsapp']) && !isset($input['senha'])) {
            self::erro('Campo obrigatorio nao identificado', 404);
            return;
        }

        if (!isset($input['whatsapp'])) {
            unset($campos[1]);
        } else {
            unset($campos[2]);
        }

        foreach ($campos as $valor) {
            if (!isset($input[$valor])) {
                self::erro('Campo obrigatorio nao identificado', 404);
                return;
            }
        }

        if (count($input) !== count($campos)) {
            self::erro('Envio de campos incorreto', 400);
            return;
        }

        foreach ($input as $campo => $valor) {
            match ($campo) {
                'email' => $input[$campo] = self::tratar_email($valor),
                'whatsapp' => $input[$campo] = self::tratar_whatsapp($valor),
                'senha' => $input[$campo] = self::tratar_senha($valor)
            };

            if (is_null($input[$campo])) {
                self::erro(match ($campo) {
                    'email' => 'Insira um E-mail valido',
                    'whatsapp' => 'Insira um numero de whatsapp no formato (xx) xxxxx-xxxx ou xxxx-xxxx',
                    'senha' => 'Insira uma senha com no minimo 5 digitos'
                });
                return;
            }
        }

        $emailHash = self::hash_email_whatsapp($input['email'] ?? '');

        if (is_null($emailHash)) {
            self::erro('Erro ao gerar hash do E-mail', 500);
            return;
        }

        $getEmailLogin = $this->db_cliente->getEmail($emailHash);

        if (is_null($getEmailLogin)) {
            self::erro('Erro ao buscar E-mail para login', 500);
            return;
        }

        if (!$getEmailLogin) {
            self::erro('Dados nao registrados no sistema', 404);
            return;
        }

        if (isset($input['whatsapp'])) {
            $whatsappHash = self::hash_email_whatsapp($input['whatsapp']);

            if (!hash_equals($getEmailLogin['whatsapp_hash'], $whatsappHash)) {
                self::erro('Dados nao registrados no sistema', 404);
                return;
            }
        } else {
            if (!password_verify($input['senha'], $getEmailLogin['senha_cliente'])) {
                self::erro('Dados nao registrados no sistema', 404);
                return;
            }
        }

        $dadosToken = [
            'id' => (int)$getEmailLogin['id_cliente'],
            'nome' => $getEmailLogin['nome_cliente'],
            'exp' => time() + 3600
        ];

        $token = Token::gerar_token($dadosToken);

        if (!$token) {
            self::erro('Erro ao gerar token para login', 500);
            return;
        }

        self::sucesso($token);
        return;
    }

    public function atu_cadastro(int $id): void
    {
        header('Content-Type: application/json');

        $payload = $this->verificar($id);

        if (!$payload) {
            self::erro('Token expirado ou inválido', 400);
            return;
        }

        $input = file_get_contents('php://input');
        $input = json_decode($input, true);

        $campos = ['nome', 'email', 'whatsapp', 'senha'];

        if (!isset($input['senha'])) {
            unset($campos[3]);
        }

        foreach ($campos as $valor) {
            if (!isset($input[$valor])) {
                self::erro('Campo obrigátorio não identificado', 404);
                return;
            }
        }

        if (count($input) !== count($campos)) {
            self::erro('Envio dos dados corrompido', 400);
            return;
        }

        $tratato = [];

        foreach ($input as $campo => $valor) {
            match ($campo) {
                'nome' => $tratado['nome'] = self::tratar_nome($valor),
                'email' => $tratado['email'] = self::tratar_email($valor),
                'whatsapp' => $tratado['whatsapp'] = self::tratar_whatsapp($valor),
                'senha' => $tratado['senha'] = self::tratar_senha($valor)
            };

            if (!$tratado[$campo]) {
                $erros['erro'] = match ($campo) {
                    'nome' => 'Insira o seu nome completo',
                    'email' => 'Insira o seu E-mail válido',
                    'whatsapp' => 'Insira um numero de whatsapp válido',
                    'senha' => 'Insira uma senha com no minímo 5 digitos'
                };
            }
        }

        if (isset($erros) && count($erros) > 0) {
            self::erro($erros);
            return;
        }


        $emailHash = self::hash_email_whatsapp($tratado['email']);

        $getEmailAtu = $this->db_cliente->getEmailAtu($emailHash, $id);

        if (!is_numeric($getEmailAtu)) {
            self::erro('Erro ao consultar E-mails para atualizar', 500);
            return;
        }

        if ($getEmailAtu > 0) {
            self::erro('Dados já estão sendo utilizados', 409);
            return;
        }

        $whatsappHash = self::hash_email_whatsapp($tratado['whatsapp']);

        $getWhatsappAtu = $this->db_cliente->getWhatsappAtu($whatsappHash, $id);

        if (!is_numeric($getWhatsappAtu)) {
            self::erro('Erro ao buscar Whatsapp para atualizar', 500);
            return;
        }

        if ($getWhatsappAtu > 0) {
            self::erro('Dados já estão sendo utilizados', 409);
            return;
        }

        $tratado['emailHash'] = $emailHash;
        $tratado['whatsappHash'] = $whatsappHash;

        $tratado['email'] = Controller::criptografia($tratado['email']);
        $tratado['whatsapp'] = Controller::criptografia($tratado['whatsapp']);

        if (isset($tratado['senha'])) {
            $tratado['senha'] = password_hash($tratado['senha'], PASSWORD_DEFAULT);
        }

        $atuCadastro = $this->db_cliente->updateCadastro($tratado, $id);

        if (is_null($atuCadastro)) {
            self::erro('Erro ao atualizar cadastro', 500);
            return;
        }

        self::sucesso('Cadastro atualizado com sucesso', 200);
        return;
    }

    public function listar_login(int $id): void
    {
        header('Content-Type: application/json');

        $payload = $this->verificar($id);

        if (!$payload) {
            self::erro('Token expirado ou inválido', 400);
            return;
        }

        $getCadastro  = $this->db_cliente->getClienteByid($id);

        if (!$getCadastro) {
            self::erro('Erro ao retornar todos os dados do usuario logado', 500);
            return;
        }

        $dataLogin = [
            'nome' => $getCadastro['nome_cliente'],
            'email' => Controller::descriptografia($getCadastro['email_cliente']),
            'whatsapp' => Controller::descriptografia($getCadastro['whatsapp_cliente']),
            'senha' => empty($getCadastro['senha_cliente']) || is_null($getCadastro['senha_cliente']) ? true : false
        ];

        self::exibir_dados($dataLogin);
        return;
    }

    public function deletar_cadastro(int $id): void
    {
        header('Content-Type: application/json');

        $payload = $this->verificar($id);

        if (is_null($payload)) {
            self::erro('Token expirado ou invalido', 400);
            return;
        }

        $deleteCadastro = $this->db_cliente->deleteCadastro($id);

        if (!$deleteCadastro) {
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

        if (!$getServicos) {
            self::erro('Erro ao retornar todos os servicos', 500);
            return;
        }

        $getCombos = $this->db_servico->getCombos();

        if (!$getCombos) {
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

        if (!$getServicos) {
            self::erro('Erro ao retornar todos os servicos', 500);
            return;
        }

        $getCombos = $this->db_servico->getCombos();

        if (!$getCombos) {
            self::erro('Erro ao retornar todos os combos');
            return;
        }

        $total = array_merge($getServicos, $getCombos);

        foreach ($total as $atributo) {
            $nome = $atributo['nome_servico'] ?? $atributo['nome_combo'];

            if (self::tratar_url($nome) === $nomeServico) {
                $detalheServico = $atributo;
            }
        }

        if (!isset($detalheServico)) {
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

        if (!$datas) {
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

        if (!$getHorarioData) {
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

        if (is_null($payload)) {
            self::erro('Token expirado ou invalido', 400);
            return;
        }

        $input = file_get_contents('php://input');
        $input = json_decode($input, true);

        if (!isset($input['mensagem'])) {
            self::erro('Campo obrigatorio nao encontrado', 404);
            return;
        }

        if (count($input) !== 1) {
            self::erro('Envio do formulario corrompido', 400);
            return;
        }


        $mensagem = trim(filter_var($input['mensagem'], FILTER_SANITIZE_SPECIAL_CHARS));

        if (str_word_count($mensagem) < 5) {
            self::erro('Mensagem muito curta');
            return;
        }

        $addComentario = $this->db_contato->addComentario($id, $mensagem);

        if (!$addComentario) {
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

        if (is_null($payload)) {
            self::erro('Token expirado ou invalido');
            return;
        }

        $input = file_get_contents('php://input');
        $input = json_decode($input, true);

        if (!isset($input['mensagem'])) {
            self::erro('Campo obrigatorio nao identificado', 404);
            return;
        }

        if (count($input) !== 1) {
            self::erro('Envio do formulario corrompido', 400);
            return;
        }


        $mensagem = filter_var($input['mensagem'], FILTER_SANITIZE_SPECIAL_CHARS);

        if (str_word_count($mensagem) < 5 || strlen($mensagem) < 5) {
            self::erro('Sua mensagem esta muito curta');
            return;
        }

        $updateComentario = $this->db_contato->updateComentario($comentario, $mensagem);

        if (!$updateComentario) {
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

        if (!$payload) {
            self::erro('Token expirado ou invalido', 400);
            return;
        }

        $getCliente = $this->db_cliente->getDetalheCliente($id);

        if (!$getCliente) {
            self::erro('Erro ao retornar dados do cliente', 500);
            return;
        }

        $getCliente['email_cliente'] = Controller::descriptografia($getCliente['email_cliente']);
        $getCliente['whatsapp_cliente'] = Controller::descriptografia($getCliente['whatsapp_cliente']);


        $getComentarios = $this->db_contato->getComentariosCliente($id);

        if (is_null($getComentarios)) {
            self::erro('Erro ao retornar os comentarios', 500);
            return;
        }

        foreach ($getComentarios as $posicao => $valor) {
            if (is_array($valor)) {
                $getComentarios[$posicao] = array_merge($valor, $getCliente);


            }
        }

        self::exibir_dados($getComentarios);
        return;
    }

    public function deletar_comentario(int $id, int $id_cliente): void
    {
        header('Content-Type: application/json');

        $payload = $this->verificar($id_cliente);

        if (is_null($payload)) {
            self::erro('Token expirado ou inválido', 400);
            return;
        }

        $deleteComentario = $this->db_contato->deleteComentario($id);

        if (!$deleteComentario) {
        }
    }






    // Notificacao
    public function listar_notificacao_lida(int $id): void
    {
        header('Content-Type: application/json');

        $payload = $this->verificar($id);

        if(!$payload){
            self::erro('Token expirado ou invalido', 400);
            return;
        }

        $getNotificacoes = $this->db_notificacao->getNotificacaoLida($id);

        if(is_null($getNotificacoes)){
            self::erro('Erro ao buscar as notificacoes lidas', 500);
            return;
        }

        self::exibir_dados($getNotificacoes);
        return;
    }

    public function listar_notificacao_nao_lida(int $id): void
    {
        header('Content-Type: application/json');

        $payload = $this->verificar($id);
        
        if(!$payload){
            self::erro('Token expirado ou invalido', 400);
            return;
        }

        $getNotificacao = $this->db_notificacao->getNotificacaoNaoLida($id);

        if(is_null($getNotificacao)){
            self::erro('Erro ao retornar notificacoes nao lidas', 500);
            return;
        }

        self::exibir_dados($getNotificacao);
        return;
    }

    public function atu_notificacao(int $id_notificacao, int $id): void
    {
        header('Content-Type: application/json');

        $payload = $this->verificar($id);

        if(!$payload){
            self::erro('Token expirado ou invalido', 400);
            return;
        }

        $updateNotificao = $this->db_notificacao->updateNotificacaoLida($id_notificacao);

        if(is_null($updateNotificao)){
            self::erro('Erro ao atualizar notificacao', 500);
            return;
        }

        self::sucesso('Notificacao atualizada com sucesso');
        return;
    }



    // Agendamento
    public function add_agendamento(int $id_cliente): void
    {
        header('Content-Type: application/json');

        $payload = $this->verificar($id_cliente);

        if (is_null($payload)) {
            self::erro('Token expirado ou inválido', 400);
            return;
        }

        $input = file_get_contents('php://input');
        $input = json_decode($input, true);


        $campos = ['data_horario', 'servico'];

        foreach ($campos as $valor) {
            if (!isset($input[$valor])) {
                self::erro('Campo obrigatório não identificado', 404);
                return;
            }
        }

        if (count($input) !== count($campos)) {
            self::erro('Envio do formulario corrompido, tentar novamente do jeito correto', 400);
            return;
        }

        $servico = (int)$input['servico'];
        $data_horario = (int)$input['data_horario'];

        $detalheDataHorario = $this->db_data->getDataHorarioDetalhe($data_horario);

        if (is_null($detalheDataHorario)) {
            self::erro('Erro ao carregar detalhe da data do agendamento', 500);
            return;
        }

        $countServico = $this->db_servico->getCount();

        if ($servico > (int)$countServico['total']) {
            $combo = $servico - (int)$countServico;

            $detalheCombo = $this->db_servico->getDetalhe_combo($combo);

            if (is_null($detalheCombo)) {
                self::erro('Erro ao buscar detalhes do combo', 500);
                return;
            }

            $servicoHorario = $detalheCombo['tempo_estimado'];
        } else {
            $detalheServico = $this->db_servico->getDetalhe_servico($servico);

            if (is_null($detalheServico)) {
                self::erro('Erro ao retornar detalhes do serviço', 500);
                return;
            }

            $servicoHorario = $detalheServico['tempo_estimado'];
        }

        $data = (int)$detalheDataHorario['id_data'];


        $tempoMinimo = $detalheDataHorario['hora_inicio'];


        $segundoMinimo = strtotime($tempoMinimo) - strtotime("00:00:00");

        $segundoServico = strtotime($servicoHorario) - strtotime("00:00:00");

        $segundoTotal = $segundoMinimo + $segundoServico;


        $tempoMaximo = gmdate('H:i:s', $segundoTotal);



        $getAgendamentos = $this->db_agendamento->getAgendamentosHorario($tempoMinimo, $tempoMaximo, $data);

        if (is_null($getAgendamentos)) {
            self::erro('Erro ao buscar agendamentos com base no horario', 500);
            return;
        }

        if ($getAgendamentos) {
            self::erro('Nao e possivel agendar esse servico nesse horario, tentar novamente com outro servico ou em outro horario', 409);
            return;
        }


        $validado = [
            'data_horario' => $data_horario,
            'cliente' => $id_cliente
        ];

        if (isset($combo)) {
            $validado['combo'] = $combo;
        } else {
            $validado['servico'] = $servico;
        }

        $addAgendamento = $this->db_agendamento->addAgendamento($validado);

        if (!$addAgendamento) {
            self::erro('Erro ao adicionar agendamento', 500);
            return;
        }

        $updateDataHorario = $this->db_data->updateDataHorario($tempoMinimo, $tempoMaximo, $data);

        if (!$updateDataHorario) {
            self::erro('Erro ao atualizar datas do agendamento', 500);
            return;
        }

        self::sucesso('Agendamento realizado com sucesso', 201);
        return;
    }






    // -------------------------------- Metodos auxiliares ------------------------------------- //

    // Validar Token
    public function verificar(int $id): ?array
    {
        $token = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

        if (preg_match('/Bearer\s(\S+)/', $token, $conteudo) !== 1) {
            return null;
        }

        $payload = Token::validar_token($conteudo[1]);

        if (is_null($payload)) {
            return null;
        }

        if ((int)$payload['id'] !== $id) {
            return null;
        }

        return $payload;
    }



    // Respostas
    private static function erro(array|string $mensagem, int $http = 422): void
    {
        header('Content-Type: application/json');
        http_response_code($http);

        if (is_string($mensagem)) {
            echo json_encode([
                'error' => $mensagem
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        } else {
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
    private static function tratar_nome(string $nome): ?string
    {
        $nomeTratado = trim($nome);

        if (str_word_count($nomeTratado) < 2) {
            return null;
        }

        return $nomeTratado ?: null;
    }

    private static function tratar_email(string $email): ?string
    {
        if (empty($email)) {
            return null;
        }

        if (preg_match('/^[a-zA-Z0-9$%&_.-]{2,}\@[a-zA-Z0-9$%&._-]{2,}\.[a-zA-Z0-9]{2,8}$/', $email) !== 1) {
            return null;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return null;
        }

        return $email ?: null;
    }

    private static function tratar_whatsapp(string $whatsapp): ?string
    {
        if (empty(trim($whatsapp))) {
            return null;
        }

        if (preg_match('/^\(\d{2}\)\s\d{4,5}\-\d{4}$/', $whatsapp) !== 1) {
            return null;
        }

        return $whatsapp ?: null;
    }

    private static function tratar_senha(string $senha): ?string
    {
        if (empty($senha)) {
            return null;
        }

        if (strlen($senha) < 5) {
            return null;
        }

        return $senha ?: null;
    }

    private static function hash_email_whatsapp(string $emailWhatsapp): ?string
    {
        if (empty($emailWhatsapp)) {
            return null;
        }

        $key = base64_decode($_ENV['CRYPTO_KEY']);

        $hash = hash_hmac('sha256', $emailWhatsapp, $key, true);

        return $hash;
    }
}
