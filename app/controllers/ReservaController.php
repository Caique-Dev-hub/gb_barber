<?php


class ReservaController extends Controller
{
    public function adicionar_reserva(): void
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $input = [
                'nome' => filter_input(INPUT_POST, 'nome_reserva', FILTER_SANITIZE_SPECIAL_CHARS),
                'email' => filter_input(INPUT_POST, 'email_reserva', FILTER_SANITIZE_SPECIAL_CHARS),
                'telefone' => filter_input(INPUT_POST, 'telefone_reserva', FILTER_SANITIZE_SPECIAL_CHARS),
                'servico' => filter_input(INPUT_POST, 'servico_reserva', FILTER_SANITIZE_NUMBER_INT),
                'horario' => filter_input(INPUT_POST, 'horario_reserva', FILTER_SANITIZE_NUMBER_INT)
            ];

            foreach($input as $campo => $valor){
                if(empty($valor)){
                    http_response_code(400);
                    echo json_encode([
                        'error' => match($campo){
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

                switch()
            }
        }
    }
}
