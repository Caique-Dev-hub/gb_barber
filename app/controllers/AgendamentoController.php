<?php

class AgendamentoController extends Controller
{
    public function editar($id)
    {
        $editar = file_get_contents('php://input');
        $editar = json_decode($editar);

        $classDash = new DashController();

        if (empty($editar) || !isset($editar)) {
            $agendamento = $this->db_dashboard->getAgendamento_editar($id);

            return $classDash->index("agendamento/editar.php", $agendamento);
        }

        foreach($editar as $campo => $valor){
            switch($campo){
                case 'chave':
                    if(strlen($valor) < 5){
                        echo 'Insira uma chave mais segura';
                        return;
                    }

                    $hash = password_hash($valor, PASSWORD_DEFAULT);
                    break;

                case 'servicos':
                    foreach($valor as $servico){
                        $vazio = 0;

                        if(empty($servico)){
                            $vazio += 1;
                        }
                    }

                    if($vazio == 3){
                        echo 'Selecione pelo menos um servico';
                        return;
                    }

            }
        }
    }
}
