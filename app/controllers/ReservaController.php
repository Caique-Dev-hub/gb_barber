<?php


class ReservaController extends Controller
{
    public function add_reserva()
    {
        header('Content-Type: application/json');

        if(isset($_SESSION['reset'])){
            $timeLimit = 20;

            $expirar = time() - $_SESSION['reset'];

            if($expirar >= $timeLimit){
                session_unset();
                session_destroy();
                session_start();
                return;
            }
        }

        if (isset($_SESSION['time'])) {
            $time = time();

            if (($time - $_SESSION['time']) < 60) {
                http_response_code(429);
                echo json_encode([
                    'Aguarde 1 minuto para realizar outra reserva'
                ]);
                return;
            }
        }

        $_SESSION['time'] = time();

        if (!isset($_SESSION['count'])) {
            $_SESSION['count'] = 0;
        } else {
            $_SESSION['count']++;
        }

        if ($_SESSION['count'] >= 3) {
            $_SESSION['reset'] = time();

            http_response_code(429);
            echo json_encode([
                'Voce excendeu o numero maximo de tentativas de reserva (3), tente novamente daqui 30 minutos'
            ]);
            return;
        }

        $input = file_get_contents('php://input');
        $input = json_decode($input, true);

        $error = [];
        $inputVerify = [];

        foreach ($input as $campo => $valor) {
            if (empty(trim($valor))) {
                $error[] = 'Preencha todos os campos';
            }

            switch ($campo) {
                case 'nome':
                    $inputVerify['nome'] = filter_var($valor, FILTER_SANITIZE_SPECIAL_CHARS);

                    if (str_word_count($inputVerify['nome']) < 2) {
                        $error[] = 'Insira o seu nome completo';
                    }

                    $nome = str_word_count($inputVerify['nome'], 1);

                    foreach ($nome as $n) {
                        if (strlen($n) < 2) {
                            $error[] = 'Nome invalido';
                        }
                    }

                    break;

                case 'email':
                    $inputVerify['email'] = filter_var($valor, FILTER_SANITIZE_EMAIL);

                    if (!filter_var($inputVerify['email'], FILTER_VALIDATE_EMAIL)) {
                        $error[] = 'E-mail invalido';
                    }

                    $inputVerify['email'] = Controller::criptografia($inputVerify['email']);

                    break;

                case 'whatsapp':
                    $inputVerify['whatsapp'] = filter_var($valor, FILTER_SANITIZE_SPECIAL_CHARS);

                    if (preg_match('/^\(\d{2}\) \d{5}-\d{4}$/', $inputVerify['whatsapp']) === 0) {
                        $error[] = 'Telefone invalido';
                    }

                    $inputVerify['whatsapp'] = Controller::criptografia($inputVerify['whatsapp']);

                    break;
            }
        }

        $inputVerify['servico'] = (int)$input['servico'];

        if ($inputVerify['servico'] > 3) {
            $inputVerify['combo'] = $inputVerify['servico'];
        }

        $inputVerify['data'] = (int)$input['data'];

        if (count($error) > 0) {
            self::error(422, $error);
            session_unset();
            return;
        }

        if (isset($inputVerify['combo'])) {
            $addCombo = $this->db_reserva->addCombo($inputVerify);

            if (!$addCombo) {
                self::errorBanco(500, 'Erro ao adicionar reserva com combo');
                return;
            }

            http_response_code(201);
            echo json_encode([
                'Reserva concluida com sucesso'
            ]);
            return;
        } else {
            $addServico = $this->db_reserva->addServico($inputVerify);

            if (!$addServico) {
                self::errorBanco(500, 'Erro ao adicionar reserva com servico');
                return;
            }

            http_response_code(201);
            echo json_encode([
                'Reserva concluida com sucesso'
            ]);
            return;
        }
    }

    private static function error(int $http, array $mensagens)
    {
        header('Content-Type: application/json');
        http_response_code($http);
        echo json_encode($mensagens);
    }

    private static function errorBanco(int $http, string $mensagem)
    {
        header('Content-Type: application/json');
        http_response_code($http);
        echo json_encode([
            'erro' => $mensagem
        ]);
    }
}
