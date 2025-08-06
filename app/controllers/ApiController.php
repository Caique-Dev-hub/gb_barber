<?php

class ApiController extends Controller
{

    // Agendamento
    public function adicionar_agendamento()
    {
        $campos = file_get_contents('php://input');
        $campos = json_decode($campos, true);

        header('Content-Type: application/json');

        foreach ($campos as $input => $valor) {
            if ($input == 'email') {
                $email_db = $this->db_cliente->getEmail();

                foreach ($email_db as $atributo) {
                    if ($valor == Geral::descriptografia($atributo['email_cliente'])) {
                        http_response_code(400);
                        echo json_encode([
                            'erro' => 'Email ja foi cadastrado'
                        ]);
                        return;
                    }
                }
            }

            if ($input == 'whatsapp') {
                $whatsapp_db = $this->db_cliente->getWhatsapp();

                foreach ($whatsapp_db as $atributo) {
                    if ($valor == Geral::descriptografia($atributo['whatsapp_cliente'])) {
                        http_response_code(400);
                        echo json_encode([
                            'erro' => 'Whatsapp ja foi cadastrado'
                        ]);
                        return;
                    }
                }
            }

            if ($input == 'chave') {
                $chaves_db = $this->db_agendamento->getChave();

                foreach ($chaves_db as $atributo) {
                    if (password_verify($valor, $atributo['chave_agendamento'])) {
                        http_response_code(400);
                        echo json_encode([
                            'erro' => 'Chave ja foi cadastrada'
                        ]);
                        return;
                    }
                }
            }
        }

        $addCliente = $this->db_cliente->addCliente($campos);

        if (!$addCliente) {
            http_response_code(400);
            echo json_encode([
                'erro' => 'Problema ao cadastrar no sistema'
            ]);
            return;
        }

        $campos['cliente'] = (int)$addCliente;

        $addAgendamento = $this->db_agendamento->addAgendamento($campos);

        if (!$addAgendamento) {
            http_response_code(400);
            echo json_encode([
                'erro' => 'Erro ao adicionar agendamento'
            ]);
            return;
        }

        foreach ($campos['servicos'] as $valor) {
            $addServico_agendamento = $this->db_agendamento->addServico_agendamento($addAgendamento, $valor);

            if (!$addServico_agendamento) {
                http_response_code(400);
                echo json_encode([
                    'erro' => 'Erro ao agendar servico'
                ]);
                return;
            }
        }

        $valor_total = $this->db_agendamento->getValor_servico_agendamento($addAgendamento);

        if (!$valor_total) {
            http_response_code(400);
            echo json_encode([
                'erro' => 'Erro ao retornar o valor total'
            ]);
            return;
        }

        $updateAgendamento = $this->db_agendamento->updateAgendamento($addAgendamento, $valor_total['valor_total']);

        if (!$updateAgendamento) {
            http_response_code(400);
            echo json_encode([
                'erro' => 'Erro ao inserir o valor total do agendamento'
            ]);
            return;
        }

        http_response_code(202);
        echo json_encode([
            'sucesso' => 'Agendamento feito com sucesso'
        ]);
    }

    public function agendamento_email()
    {
        $campos = file_get_contents('php://input');
        $campos = json_decode($campos, true);

        header('Content-Type: application/json');

        foreach ($campos as $input => $valor) {
            $email_db = $this->db_cliente->getEmail();

            if ($input == 'email') {
                foreach ($email_db as $atributo) {
                    if ($valor == Geral::descriptografia($atributo['email_cliente'])) {
                        $cliente = $atributo['id_cliente'];
                    }
                }
            }

            if ($input == 'chave') {
                $chave_db = $this->db_agendamento->getChave();

                foreach ($chave_db as $atributo) {
                    if (password_verify($valor, $atributo['chave_agendamento'])) {
                        http_response_code(400);
                        echo json_encode([
                            'erro' => 'Chave ja foi cadastrada'
                        ]);
                        return;
                    }
                }
            }
        }

        $campos['cliente'] = $cliente;

        $addAgendamento = $this->db_agendamento->addAgendamento($campos);

        if (!$addAgendamento) {
            http_response_code(400);
            echo json_encode([
                'erro' => 'Erro ao fazer agendamento'
            ]);
            return;
        }

        foreach ($campos as $input => $valor) {
            if ($input == 'servicos') {
                foreach ($valor as $a) {
                    $addServico_agendamento = $this->db_agendamento->addServico_agendamento($addAgendamento, (int)$a);

                    if (!$addServico_agendamento) {
                        http_response_code(400);
                        echo json_encode([
                            'erro' => 'Erro ao agendar o servico no agendamento'
                        ]);
                        return;
                    }
                }
            }
        }

        $valor_total = $this->db_agendamento->getValor_servico_agendamento($addAgendamento);

        if (!$valor_total) {
            http_response_code(400);
            echo json_encode([
                'erro' => 'Erro ao retornar o valor dos servicos'
            ]);
            return;
        }

        $updateAgendamento = $this->db_agendamento->updateAgendamento($addAgendamento, $valor_total['valor_total']);

        if (!$updateAgendamento) {
            http_response_code(400);
            echo json_encode([
                'erro' => 'Erro ao atualizar o valor'
            ]);
            return;
        }

        http_response_code(200);
        echo json_encode([
            'sucesso' => 'Agendamento feito com sucesso'
        ]);
    }

    public function remover_agendamento()
    {
        $chave = file_get_contents('php://input');
        $chave = json_decode($chave, true);

        header('Content-Type: application/json');

        $chaves_db = $this->db_agendamento->getChave();

        foreach ($chaves_db as $atributo) {
            if (password_verify($chave['chave'], $atributo['chave_agendamento'])) {
                $removeAgendamento = $this->db_agendamento->removeAgendamento($atributo['id_agendamento']);

                if (!$removeAgendamento) {
                    http_response_code(400);
                    echo json_encode([
                        'erro' => 'Erro ao remover agendamento'
                    ]);
                    return;
                } else {
                    http_response_code(200);
                    echo json_encode([
                        'sucesso' => 'Agendamento removido com sucesso'
                    ]);
                    return;
                }
            }
        }

        http_response_code(400);
        echo json_encode([
            'erro' => 'Chave incorreta'
        ]);
    }

    public function listar_agendamentos()
    {
        $campos = file_get_contents('php://input');
        $campos = json_decode($campos, true);

        $email = false;
        $whatsapp = false;

        header('Content-Type: application/json');

        foreach ($campos as $input => $valor) {
            if ($input == 'email') {
                $email_db = $this->db_cliente->getEmail();

                foreach ($email_db as $atributo) {
                    if ($valor == Geral::descriptografia($atributo['email_cliente'])) {
                        $email = true;
                    }
                }
            }

            if ($input == 'whatsapp') {
                $whatsapp_db = $this->db_cliente->getWhatsapp();

                foreach ($whatsapp_db as $atributo) {
                    if ($valor == Geral::descriptografia($atributo['whatsapp_cliente'])) {
                        $whatsapp = true;
                    }
                }
            }
        }

        if (!$whatsapp || !$email) {
            http_response_code(400);
            echo json_encode([
                'erro' => 'Dados nao encontrados'
            ]);
            return;
        }

        foreach ($campos as $input => $valor) {
            if ($input == 'email') {
                foreach ($email_db as $atributo) {
                    if ($valor == Geral::descriptografia($atributo['email_cliente'])) {
                        $cliente = $atributo['id_cliente'];
                    }
                }
            }
        }

        $agendamentos = $this->db_agendamento->getAgendamentos($cliente);

        http_response_code(200);
        echo json_encode($agendamentos);
    }

    public function listar_servicos_agendamento($agendamento)
    {
        header('Content-Type: application/json');

        $getServicos_agendamento = $this->db_agendamento->getServico_agendamento($agendamento);

        if (!$getServicos_agendamento) {
            http_response_code(400);
            echo json_encode([
                'erro' => 'Erro ao retornar servicos do agendamento'
            ]);
            return;
        }

        http_response_code(200);
        echo json_encode($getServicos_agendamento);
    }

    public function atualizar_chave()
    {
        $campos = file_get_contents('php://input');
        $campos = json_decode($campos, true);
        $email = false;
        $whatsapp = false;

        header('Content-Type: application/json');

        foreach($campos as $input => $valor){
            if($input == 'email'){
                $email_db = $this->db_cliente->getEmail();

                foreach($email_db as $atributo){
                    if($valor == Geral::descriptografia($atributo['email_cliente'])){
                        $email = true;
                    }
                }
            }

            if($input == 'whatsapp'){
                $whatsapp_db = $this->db_cliente->getWhatsapp();

                foreach($whatsapp_db as $atributo){
                    if($valor == Geral::descriptografia($atributo['whatsapp_cliente'])){
                        $whatsapp = true;
                    }
                }
            }

        }
    }
}
