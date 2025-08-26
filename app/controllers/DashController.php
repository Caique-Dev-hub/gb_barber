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
        $getReservas = $this->db_reserva->getReservas();

        foreach($getReservas as $atributo){
            extract($atributo);

            $email = Controller::descriptografia($email_reserva);
            $whatsapp = Controller::descriptografia($whatsapp_reserva);

            $data = explode('-', $nome_data);
            $data = array_reverse($data);

            $data = implode('/', $data);

            if(isset($id_servico)){
                $servico = $this->db_servico->getDetalhe_servico($id_servico);
            } else{
                $combo = $this->db_servico->getDetalhe_combo($id_combo);
            }

            $nome_servico = $servico['nome_servico'] ?? $combo['nome_combo'];

            echo 
            "
        <div style='font-family: Arial, sans-serif; border: 1px solid #e0e0e0; border-radius: 8px; padding: 20px; max-width: 500px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); background-color: white;'>
           <h2 style='margin-top: 0; color: #333;'>$nome_reserva</h2>

           <div style='margin-bottom: 15px;'>
               <div>✉️ $email</div>
               <div>📞 $whatsapp</div>
           </div>

           <hr style='border: 0.5px solid #e0e0e0; margin: 15px 0;'>

           <div style='background-color: #e8f5e9; color: #2e7d32; padding: 5px 10px; border-radius: 4px; display: inline-block; font-weight: bold; margin-bottom: 15px;'>
               $status_reserva
           </div>

           <div style='margin-bottom: 10px;'>
               <div style='font-weight: bold;'>SERVIÇO</div>
               <div>$nome_servico</div>
           </div>

           <div style='margin-bottom: 20px;'>
               <div style='font-weight: bold;'>DATA & HORA</div>
               <div>$data - $hora_inicio</div>
           </div>

           <div style='display: flex; gap: 10px;'>
               <button style='background-color: #4caf50; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; flex: 1;'>
                   Agendar Reserva
               </button>
               <button style='background-color: #f44336; color: white; border: none; padding: 8px 15px; border-radius: 4px; cursor: pointer; flex: 1;'>
                   Cancelar
               </button>
           </div>
        </div>
            ";
        }
    }





    // CRUD
    
}