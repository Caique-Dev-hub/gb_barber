<?php

class ApiController extends Controller
{
    // Login
    public function add_cadastro()
    {
        $input = file_get_contents('php://input');
        $input = json_decode($input, true);

        header('Content-Type: application/json');

        foreach ($input as $campo => $valor) {
            if (empty(trim($valor))) {
                self::response(400, 'Preencha todos os campos');
                return;
            }

            switch ($campo) {
                case 'nome':
                    $nome = filter_var($valor, FILTER_SANITIZE_SPECIAL_CHARS);

                    $nameArray = explode(' ', $nome);

                    if (count($nameArray) < 2) {
                        self::response(400, 'Insira o seu nome completo');
                        return;
                    }

                    foreach ($nameArray as $valor) {
                        if (strlen(trim($valor)) < 2) {
                            self::response(400, 'Nome invalido');
                            return;
                        }

                        (array)$nome[] = ucfirst($valor);
                    }

                    $nome = implode(' ', $nome);
                    break;

                case 'email':
                    $email = filter_var($valor, FILTER_SANITIZE_EMAIL);

                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        self::response(400, 'E-mail invalido');
                        return;
                    }

                    $email = Geral::criptografia($email);

                    $emailHash = ;
                    break;

                case 'whatsapp':
                    $whatsapp = filter_var($valor, FILTER_SANITIZE_SPECIAL_CHARS);

                    if (strlen(trim($whatsapp)) <> 15) {
                        self::response(400, 'Whatsapp invalido');
                        return;
                    }

                    if (preg_match('/^\(\d{2}\) \d{5}-\d{4}$/', $whatsapp) !== 1) {
                        self::response(400, 'Formato de whatsapp invalido');
                        return;
                    }

                    $whatsapp = Geral::criptografia($whatsapp);
                    break;

                case 'senha':
                    $senha = filter_var($valor, FILTER_SANITIZE_SPECIAL_CHARS);

                    if (strlen(trim($senha)) < 5) {
                        self::response(400, 'Insira uma senha com 5 digitos ou mais');
                        return;
                    }

                    $senha = password_hash($senha, PASSWORD_DEFAULT);
                    break;
            }
        }

        $input['nome'] = $nome;
        $input['email'] = $email;
        $input['emailHash'] = $emailHash;
        $input['whatsapp'] = $whatsapp;
        $input['senha'] = $senha;
    }





    private static function response(int $http, string $mensagem)
    {
        header('Content-Type: application/json');
        http_response_code($http);
        echo json_encode([
            'mensagem' => $mensagem
        ]);
    }

    private static function select(int $http, array $table)
    {
        header('Content-Type: application/json');
        http_response_code($http);
        echo json_encode($table, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    }
}
