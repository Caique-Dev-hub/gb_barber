<?php


class ReservaController extends Controller
{
    public function agendar_reserva($id_reserva)
    {
        $cliente = [];
        $agendamento = [];

        $getReserva = $this->db_reserva->getReserva($id_reserva);

        foreach ($getReserva as $atributo => $valor) {
            switch ($atributo) {
                case 'nome_reserva':
                    $cliente['nome'] = $valor;
                    break;

                case 'email_reserva':
                    $cliente['email'] = $valor;
                    break;

                case 'whatsapp_reserva':
                    $cliente['whatsapp'] = $valor;
                    break;

                default:
                    $agendamento[$atributo] = $valor;
                    break;
            }
        }

        $addCliente = $this->db_cliente->addCliente($cliente);

        $addAgendamento = $this->db_agendamento->addAgendamento_reserva($addCliente, $agendamento);

        if(!$addAgendamento){
            echo 'Erro ao fazer agendamento da reserva';
            return;
        }

        echo 'Reserva agendada';
    }
}
