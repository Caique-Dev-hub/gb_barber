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

        if(is_null($getAgendamentos)){
            return null;
        }

        foreach($getAgendamentos as $atributos){
                    echo "
                    <div class=\"cartao\">
                        <div class=\"lado-esquerdo\">
                            <h2>Maria Silva <span class=\"status\" id=\"status\">PENDENTE</span></h2>
            
                            <div class=\"informacoes\">
                                <div class=\"item-informacao\">
                                    <i>📧</i> maria.silva@exemplo.com
                                </div>
                                <div class=\"item-informacao\">
                                    <i>📱</i> (11) 98765-4321
                                </div>
                            </div>
            
                            <div class=\"acoes\">
                                <button class=\"botao-agendar\" onclick=\"agendar()\">Agendar Reserva</button>
                                <button class=\"botao-cancelar\" onclick=\"cancelar()\">Cancelar Reserva</button>
                            </div>
                        </div>
            
                        <div class=\"lado-direito\">
                            <div>
                                <p class=\"rotulo\">Serviço</p>
                                <p class=\"valor\">Design de Sobrancelhas</p>
                            </div>
            
                            <div style=\"margin-top: 12px;\">
                                <p class=\"rotulo\">Data e Hora</p>
                                <p class=\"valor\">15/07/2023 - 14:30</p>
                            </div>
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
            <div class=\"cartao\">
    <div class=\"lado-esquerdo\">
        <h2>Maria Silva <span class=\"status\" id=\"status\">PENDENTE</span></h2>

        <div class=\"informacoes\">
            <div class=\"item-informacao\">
                <i>📧</i> maria.silva@exemplo.com
            </div>
            <div class=\"item-informacao\">
                <i>📱</i> (11) 98765-4321
            </div>
        </div>

        <div class=\"acoes\">
            <button class=\"botao-agendar\" onclick=\"agendar()\">Agendar Reserva</button>
            <button class=\"botao-cancelar\" onclick=\"cancelar()\">Cancelar Reserva</button>
        </div>
    </div>

    <div class=\"lado-direito\">
        <div>
            <p class=\"rotulo\">Serviço</p>
            <p class=\"valor\">Design de Sobrancelhas</p>
        </div>

        <div style=\"margin-top: 12px;\">
            <p class=\"rotulo\">Data e Hora</p>
            <p class=\"valor\">15/07/2023 - 14:30</p>
        </div>
    </div>
</div>
     ";
        }
    }





    // CRUD

}
