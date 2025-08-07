<?php

class DashController extends Controller{
    public function index(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
            $senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);

            $admin = $this->db_dashboard->getAdmin();

            foreach($admin as $atributo){
                if($atributo['nome_admin'] === $nome && $atributo['senha_admin'] === $senha){
                    $_SESSION['admin'] = $atributo;
                }
            }
        }

        $dados = [];

        $this->view('admin/dash', $dados);
    }


    public function listar_agendamento(){
        $html = 
        "
            <div class='booking-card'>
                        <div class='card-accent'></div>

                        <div class='booking-content'>
                            <div class='client-info'>
                                <div class='booking-header'>
                                    <h3 class='booking-name'>
                                        <span class='name-text'>Maria Silva</span>
                                        <span class='verified-badge'>
                                            <svg viewBox='0 0 24 24' width='16' height='16'>
                                                <path fill='#EF4444' d='M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z' />
                                            </svg>
                                        </span>
                                    </h3>
                                    <span class='booking-status confirmed'>Confirmado</span>
                                </div>

                                <div class='contact-details'>
                                    <div class='detail-item email'>
                                        <div class='icon-wrapper'>
                                            <svg viewBox='0 0 24 24'>
                                                <path fill='currentColor' d='M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z' />
                                            </svg>
                                        </div>
                                        <span>maria.silva@exemplo.com</span>
                                    </div>

                                    <div class='detail-item phone'>
                                        <div class='icon-wrapper'>
                                            <svg viewBox='0 0 24 24'>
                                                <path fill='currentColor' d='M17 1.01L7 1c-1.1 0-2 .9-2 2v18c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V3c0-1.1-.9-1.99-2-1.99zM17 19H7V5h10v14zm-4.2-5.78v1.75l3.2-2.99L12.8 9v1.7c-3.11.43-4.35 2.56-4.8 4.7 1.11-1.5 2.58-2.18 4.8-2.18z' />
                                            </svg>
                                        </div>
                                        <span>(11) 98765-4321</span>
                                    </div>
                                </div>
                            </div>

                            <div class='booking-info'>
                                <div class='service-detail'>
                                    <div class='icon-wrapper'>
                                        <svg viewBox='0 0 24 24'>
                                            <path fill='currentColor' d='M13 13v8h8v-8h-8zM3 21h8v-8H3v8zM3 3v8h8V3H3zm13.66-1.31L11 7.34 16.66 13l5.66-5.66-5.66-5.65z' />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class='info-label'>Serviço</p>
                                        <p class='info-value'>Design de Sobrancelhas</p>
                                    </div>
                                </div>

                                <div class='date-detail'>
                                    <div class='icon-wrapper'>
                                        <svg viewBox='0 0 24 24'>
                                            <path fill='currentColor' d='M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z' />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class='info-label'>Data & Hora</p>
                                        <p class='info-value'>15/07/2023 - 14:30</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        ";

        echo $html;
    }

    public function listar_reserva(){
        $html = 
        "
            <div class='booking-card'>
                        <div class='card-accent'></div>

                        <div class='booking-content'>
                            <div class='client-info'>
                                <div class='booking-header'>
                                    <h3 class='booking-name'>
                                        <span class='name-text'>Maria</span>
                                        <span class='verified-badge'>
                                            <svg viewBox='0 0 24 24' width='16' height='16'>
                                                <path fill='#EF4444' d='M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z' />
                                            </svg>
                                        </span>
                                    </h3>
                                    <span class='booking-status confirmed'>Confirmado</span>
                                </div>

                                <div class='contact-details'>
                                    <div class='detail-item email'>
                                        <div class='icon-wrapper'>
                                            <svg viewBox='0 0 24 24'>
                                                <path fill='currentColor' d='M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z' />
                                            </svg>
                                        </div>
                                        <span>maria.silva@exemplo.com</span>
                                    </div>

                                    <div class='detail-item phone'>
                                        <div class='icon-wrapper'>
                                            <svg viewBox='0 0 24 24'>
                                                <path fill='currentColor' d='M17 1.01L7 1c-1.1 0-2 .9-2 2v18c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V3c0-1.1-.9-1.99-2-1.99zM17 19H7V5h10v14zm-4.2-5.78v1.75l3.2-2.99L12.8 9v1.7c-3.11.43-4.35 2.56-4.8 4.7 1.11-1.5 2.58-2.18 4.8-2.18z' />
                                            </svg>
                                        </div>
                                        <span>(11) 98765-4321</span>
                                    </div>
                                </div>
                            </div>

                            <div class='booking-info'>
                                <div class='service-detail'>
                                    <div class='icon-wrapper'>
                                        <svg viewBox='0 0 24 24'>
                                            <path fill='currentColor' d='M13 13v8h8v-8h-8zM3 21h8v-8H3v8zM3 3v8h8V3H3zm13.66-1.31L11 7.34 16.66 13l5.66-5.66-5.66-5.65z' />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class='info-label'>Serviço</p>
                                        <p class='info-value'>Design de Sobrancelhas</p>
                                    </div>
                                </div>

                                <div class='date-detail'>
                                    <div class='icon-wrapper'>
                                        <svg viewBox='0 0 24 24'>
                                            <path fill='currentColor' d='M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11z' />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class='info-label'>Data & Hora</p>
                                        <p class='info-value'>15/07/2023 - 14:30</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        ";

        echo $html;
    }





    // CRUD
    public function listar($pasta){
        $dados = [];
        $dados['conteudo'] = "$pasta/listar";

        switch($pasta){
            case 'servicos':
                $servicos = $this->db_servico->getServicos();
                $combos = $this->db_servico->getCombos();

                $dados['servicos'] = array_merge($servicos, $combos);
                break;
        }
        

        $this->view('admin/dash', $dados);
    }
}