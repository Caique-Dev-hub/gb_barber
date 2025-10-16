<?php


class ReservaController extends Controller
{
    public function adicionar_reserva(): void
    {
        // Segurança e configuração
        ini_set('display_errors', 0);
        error_reporting(E_ALL);
        header('Content-Type: application/json; charset=utf-8');

        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            error_log("Erro PHP: [$errno] $errstr em $errfile:$errline");
        });

        // Proteção contra spam / tempo
        if (isset($_SESSION['time'])) {
            $time = time();

            // 30 minutos = 1800 segundos
            if (($time - $_SESSION['time']) < 1800) {
                echo json_encode(['error' => 'Aguarde 30 minutos para tentar novamente']);
                exit;
            }
        }

        $input = $_POST;

        $campos = ['nome_reserva', 'email_reserva', 'telefone_reserva', 'servico_reserva', 'horario_reserva'];

        $nome = $email = $whatsapp = $servico = $data = $horario = null;

        foreach ($campos as $campo) {
            if (!isset($input[$campo])) {
                echo json_encode(['error' => "Campo ausente: {$campo}"]);
                exit;
            }

            if (empty(trim($input[$campo]))) {
                echo json_encode(['error' => 'Preencha todos os campos']);
                exit;
            }
        }

        foreach ($input as $campo => $valor) {
            switch ($campo) {
                case 'nome':
                    $nome = filter_var($valor, FILTER_SANITIZE_SPECIAL_CHARS);
                    if (str_word_count($nome) < 2) {
                        echo json_encode(['error' => 'Insira o seu nome completo']);
                        exit;
                    }
                    $nome = str_word_count($nome, 1);
                    foreach ($nome as $v) {
                        if (strlen($v) < 2) {
                            echo json_encode(['error' => 'Nome inválido']);
                            exit;
                        }
                    }
                    $nome = implode(' ', $nome);
                    break;

                case 'email':
                    $email = filter_var($valor, FILTER_SANITIZE_EMAIL);
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        echo json_encode(['error' => 'E-mail inválido']);
                        exit;
                    }
                    $email = Controller::criptografia($email);
                    break;

                case 'whatsapp':
                    $whatsapp = preg_replace('/[^0-9\(\)\-\s]/', '', $valor);
                    if (preg_match('/^\(\d{2}\)\s\d{5}-\d{4}$/', $whatsapp) !== 1) {
                        echo json_encode(['error' => 'Formato de número de WhatsApp inválido']);
                        exit;
                    }
                    $whatsapp = Controller::criptografia($whatsapp);
                    break;

                case 'servico':
                    $servico = (int)$valor;
                    if ($servico > 3) {
                        $combo = $servico - 3;
                    }
                    break;

                case 'data':
                    $data = trim($valor);
                    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data)) {
                        echo json_encode(['error' => 'Data inválida']);
                        exit;
                    }
                    break;

                case 'horario':
                    $horario = trim($valor);
                    if (!preg_match('/^\d{2}:\d{2}$/', $horario)) {
                        echo json_encode(['error' => 'Horário inválido']);
                        exit;
                    }
                    break;
            }
        }

        $input['nome'] = $nome;
        $input['email'] = $email;
        $input['whatsapp'] = $whatsapp;

        if (isset($combo)) {
            $input['combo'] = $combo;
            $addReserva = $this->db_reserva->addCombo($input);
        } else {
            $addReserva = $this->db_reserva->addServico($input);
        }

        if (!$addReserva) {
            echo json_encode(['error' => 'Erro ao adicionar reserva']);
            exit;
        }


        echo json_encode(['sucess' => 'Reserva adicionada com sucesso']);
        exit;
    }
}
