<?php

class ApiController extends Controller{
    // APIs

    public function add_cadastro(): void
    {
        $input = file_get_contents('php://input');
        $input = json_decode($input, true);

        header('Content-Type: application/json');

        $erro = [];
        $sucesso = [];

        foreach($input as $campo => $valor){
            if(empty(trim($valor))){
                $erro[] = 'Preencha todos os campos';
            }

            switch($campo){
                case 'nome':
                    $sucesso['nome'] = self::validation_name($valor);

                    if(!$sucesso['nome']){
                        $erro[] = 'Insira o seu nome completo e valido';
                    }

                    break;

                case 'email':
                    $sucesso['email'] = self::validation_email($valor);

                    if(!$sucesso['email']){
                        $erro[] = 'E-mail invalido';
                    }

                    $sucesso['email_hash'] = self::hash_email_whatsapp($sucesso['email']);
                    $sucesso['email'] = Controller::criptografia($sucesso['email']);

                    break;

                case 'whatsapp':
                    $sucesso['whatsapp'] = self::validation_whatsapp($valor);

                    if(!$sucesso['whatsapp']){
                        $erro[] = 'Insira um formato valido para o Whatsapp';
                    }

                    $sucesso['whatsapp_hash'] = self::hash_email_whatsapp($sucesso['whatsapp']);
                    $sucesso['whatsapp'] = Controller::criptografia($sucesso['whatsapp']);

                    break;

                case 'senha':
                    $sucesso['senha'] = self::validation_password($valor);

                    if(!$sucesso['senha']){
                        $erro[] = 'Sua senha precisa conter 5 digitos ou mais';
                    }

                    break;
            }
        }

        if(count($erro) > 0){
            self::error(422, $erro);
            return;
        }

        if(count($sucesso) < 6){
            self::error_method('Erro ao realizar tratamento');
            return;
        }

        $addCadastro = $this->db_cliente->addCliente($sucesso);

        if(!$addCadastro){
            self::error_method('Erro ao adicionar cadastro');
            return;
        }

        self::success(201, 'Cadastro realizado com sucesso');
        return;
    }





    // Respostas
    private static function error(int $http, array $mensagem): void
    {
        header('Content-Type: application/json');
        http_response_code($http);
        echo json_encode($mensagem);
    }

    private static function error_method(string $mensagem): void
    {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode([
            'erro' => $mensagem
        ]);
    }

    private static function success(int $http, string $mensagem): void
    {
        header('Content-Type: application/json');
        http_response_code($http);
        echo json_encode([
            'sucesso' => $mensagem
        ]);
    }

    private static function display(int $http, array $tabela): void
    {
        header('Content-Type: application/json');
        http_response_code($http);
        echo json_encode($tabela, JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }




    // Reutilizaveis
    private static function validation_name(string $nome): string|bool
    {
        $nomeTratado = filter_var($nome, FILTER_SANITIZE_SPECIAL_CHARS);

        $ucfirst = [];

        if(str_word_count($nomeTratado) < 2){
            return false;
        }

        $nomeTratado = str_word_count($nomeTratado, 1);

        foreach($nomeTratado as $valor){
            if(strlen(trim($valor)) < 2){
                return false;
            } else{
                $ucfirst[] = ucfirst($valor);
            }
        }

        return implode(' ', $ucfirst);
    }

    private static function validation_email(string $email): string|bool
    {
        $emailTratado = filter_var($email, FILTER_SANITIZE_EMAIL);

        if(!filter_var($emailTratado, FILTER_VALIDATE_EMAIL)){
            return false;
        } else{
            return $emailTratado;
        }
    }

    private static function validation_whatsapp(string $whatsapp): string|bool
    {
        $whatsappTratado = filter_var($whatsapp, FILTER_SANITIZE_SPECIAL_CHARS);

        if(preg_match('/^\(\d{2}\) \d{5}-\d{4}$/', $whatsappTratado) !== 1){
            return false;
        } else{
            return $whatsappTratado;
        }
    }

    private static function validation_password(string $senha): string|bool
    {
        $senhaHash = filter_var($senha, FILTER_SANITIZE_SPECIAL_CHARS);

        if(strlen($senhaHash) < 5){
            return false;
        } else{
            $senhaHash = password_hash($senhaHash, PASSWORD_DEFAULT);
            return $senhaHash;
        }
    }

    private static function hash_email_whatsapp(string $emailWhatsapp): string
    {
        $key = base64_decode($_ENV['CRYPTO_KEY']);

        $hash = hash_hmac('sha256', $emailWhatsapp, $key);

        return $hash;
    }
}