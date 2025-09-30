<?php


class ReservaController extends Controller
{
    public function adicionar_reserva(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = [
                'nome' => filter_input(INPUT_POST, 'nome_reserva', FILTER_SANITIZE_SPECIAL_CHARS),
                'email' => filter_input(INPUT_POST, 'email_reserva', FILTER_SANITIZE_SPECIAL_CHARS),
                'telefone' => filter_input(INPUT_POST, 'telefone_reserva', FILTER_SANITIZE_SPECIAL_CHARS),
                'servico' => filter_input(INPUT_POST, 'servico_reserva', FILTER_SANITIZE_NUMBER_INT),
                'horario' => filter_input(INPUT_POST, 'horario_reserva', FILTER_SANITIZE_NUMBER_INT)
            ];

            $tratado = [];

            $countServico = $this->db_servico->getCount();

            if (!$countServico) {
                http_response_code(500);
                echo json_encode([
                    'error' => 'Erro ao retornar a conta de todos os serviços'
                ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                return;
            }

            foreach ($input as $campo => $valor) {
                if (empty($valor)) {
                    http_response_code(400);
                    echo json_encode([
                        'error' => match ($campo) {
                            'nome' => 'Seu nome completo não foi identificado, tentar novamente',
                            'email' => 'E-mail não foi identificado, tentar novamente',
                            'telefone' => 'Telefone não foi identificado, tentar novamente',
                            'servico' => 'Serviço não foi identificado na solicitação da reserva, tentar novamente',
                            'horario' => 'Horário não foi identificado na solicitação da reserva, tentar novamente',
                            default => 'Campo não identificado'
                        }
                    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                    return;
                }

                switch ($campo) {
                    case 'nome':
                        $nome = trim($valor);

                        if (str_word_count($nome) < 2) {
                            http_response_code(422);
                            echo json_encode([
                                'error' => 'Insira o seu nome completo'
                            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                            return;
                        }

                        $nome = str_word_count($nome, 1);

                        foreach ($nome as $valor) {
                            if (strlen($valor) < 2) {
                                http_response_code(422);
                                echo json_encode([
                                    'error' => 'Nome inválido'
                                ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                                return;
                            }
                        }

                        $nome = implode(' ', $nome);
                        break;

                    case 'email':
                        $email = trim($valor);

                        if (preg_match('/^[a-zA-Z0-9$%&_.-]{2,}\@[a-zA-Z0-9$%&_.-]{2,}\.[a-zA-Z0-9]{2,8}$/', $email) !== 1) {
                            http_response_code(422);
                            echo json_encode([
                                'error' => 'E-mail informado incorretamente'
                            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                            return;
                        }

                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            http_response_code(422);
                            echo json_encode([
                                'error' => 'E-mail informado incorretamente'
                            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                            return;
                        }

                        break;

                    case 'telefone':
                        $whatsapp = trim($valor);

                        if (preg_match('/^\(\d{2}\) \d{5}-\d{4}$/', $whatsapp) !== 1) {
                            http_response_code(422);
                            echo json_encode([
                                'error' => 'Telefone informado incorretamente'
                            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                            return;
                        }

                        break;

                    case 'servico':
                        $servico = (int)$valor;

                        if ($servico > $countServico['total']) {
                            $combo = $servico - (int)$countServico['total'];
                            unset($servico);
                        }

                        break;

                    case 'horario':
                        $horario = (int)$valor;

                        break;

                    default:
                        http_response_code(400);
                        echo json_encode([
                            'error' => 'Campo inválido identificado'
                        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                        return;
                }
            }

            $key = base64_decode($_ENV['CRYPTO_KEY']);

            $tratado = [
                'nome' => $nome,
                'email' => Controller::criptografia($email),
                'whatsapp' => Controller::criptografia($whatsapp),
                'horario' => $horario
            ];

            if(isset($servico)){
                $tratado['servico'] = $servico;
            } else {
                $tratado['combo'] = $combo;
            }

            $addReserva = $this->db_reserva->addReserva($tratado);

            if(!$addReserva){
                http_response_code(500);
                echo json_encode([
                    'error' => 'Erro ao realizar reserva'
                ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                return;
            }

            http_response_code(201);
            echo json_encode([
                'sucess' => 'Reserva realizada com sucesso'
            ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            return;
        }
    }
}
