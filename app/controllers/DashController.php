<?php

class DashController extends Controller
{
    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
            $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);

            $admin = $this->db_dashboard->getAdmin();

            foreach ($admin as $atributo) {
                if ($atributo['nome_admin'] === $nome && $atributo['senha_admin'] === $senha) {
                    $_SESSION['admin'] = $atributo;
                }
            }
        }

        $dados = [];

        $this->view('admin/dash', $dados);
    }


    public function listar_agendamento()
    {

        $getAgendamentos = $this->db_agendamento->getAgendamentos();

        foreach ($getAgendamentos as $valor) {
            if (!isset($valor['nome_servico'])) {
                $servico = $valor['nome_combo'];
            } else {
                $servico = $valor['nome_servico'];
            }

            echo  "
            <div class=\"card-agendamento\">
              <div class=\"info-cliente\">
                <h2>" . Controller::descriptografia($valor['nome_cliente']) . "</h2>
                <p><i class=\"fa fa-envelope\"></i> " . Controller::descriptografia($valor['email_cliente']) . "</p>
                <p><i class=\"fa fa-phone\"></i> " . Controller::descriptografia($valor['whatsapp_cliente']) . "</p>
                <span class=\"status aguardando\">" . $valor['status_agendamento'] . "</span>
              </div>
    
              <div class=\"info-servico\">
                <p class=\"label\">Serviço</p>
                <p><strong>" . $servico . "</strong></p>
                <p class=\"label\">Data & Hora</p>
                <p><strong>" . $valor['nome_data'] . " - " . $valor['hora_inicio'] . "</strong></p>
              </div>
            </div>
            ";
        }
    }

    public function listar_reserva()
    {
        $getReservas = $this->db_reserva->getReservas();

        foreach ($getReservas as $atributo) {
            extract($atributo);

            $email = Controller::descriptografia($email_reserva);
            $whatsapp = Controller::descriptografia($whatsapp_reserva);

            $data = explode('-', $nome_data);
            $data = array_reverse($data);

            $data = implode('/', $data);

            if (isset($id_servico)) {
                $servico = $this->db_servico->getDetalhe_servico($id_servico);
            } else {
                $combo = $this->db_servico->getDetalhe_combo($id_combo);
            }

            $nome_servico = $servico['nome_servico'] ?? $combo['nome_combo'];

            echo
            "
        <div class=\"cartao-reserva\">
  <div class=\"info-cliente-reserva\">
    <h2>João Pereira</h2>
    <p><i class=\"fa fa-envelope\"></i> joao.pereira@exemplo.com</p>
    <p><i class=\"fa fa-phone\"></i> (11) 99999-1234</p>
    <span class=\"status-reserva\">Aguardando</span>

    <div class=\"botoes-reserva\">
      <button class=\"botao-reserva botao-agendar\">Agendar Reserva</button>
      <button class=\"botao-reserva botao-cancelar\">Cancelar Reserva</button>
    </div>
  </div>

  <div class=\"info-servico-reserva\">
    <p class=\"rotulo\">Serviço</p>
    <p><strong>Corte de Cabelo</strong></p>
    <p class=\"rotulo\">Data & Hora</p>
    <p><strong>18/10/2025 - 15:00</strong></p>
  </div>
</div>
            ";
        }
    }





    // CRUD

}
