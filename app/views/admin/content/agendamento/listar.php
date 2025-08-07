<?php $dash = new Dashboard() ?>

<style>
    :root {
        --animate-delay: 0.3s;
    }

    .removidosButton {
        background: linear-gradient(to left, red, rgb(255, 34, 34));
        border: none;
        outline: none;
        color: white;
        width: 8rem;
        height: 2.5rem;
        border-radius: 20px;
        position: absolute;
        margin-left: 58rem;
        top: 1rem;
        font-weight: bold;
        transition: 0.3s;
        z-index: 3;
    }

    .button:hover {
        transform: translateY(-10%);
    }

    .listarButton {
        background: linear-gradient(to left, blue, rgb(34, 122, 255));
        border: none;
        outline: none;
        color: white;
        width: 8rem;
        height: 2.5rem;
        border-radius: 20px;
        position: absolute;
        margin-left: 58rem;
        top: 1rem;
        font-weight: bold;
        transition: 0.3s;
        z-index: 2;
    }
</style>

<div class="col-12 animate__animated animate__fadeInUp animate__delay-1s">
    <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Agendamentos</h6>
                <a href="dash/adicionar/agendamento">
                    <button class="add-button" id="addButton">
                        <div class="icon"></div>
                        <span class="text">Adicionar</span>
                        <div class="counter" id="counter">1</div>
                        <svg class="checkmark" width="30" height="30" viewBox="0 0 50 50">
                            <path d="M10,25 L20,35 L40,15" fill="none" />
                        </svg>
                    </button>
                </a>
                <button class="removidosButton button" id="listarRemovidos">
                    Removidos
                </button>
                <button class="listarButton button" id="listarAgendamentos">
                    Marcados
                </button>
            </div>
        </div>
        <div class="card-body px-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cliente</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Data</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Hora de inicio</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Hora de conclusão</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Serviços</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Valor</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"></th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"></th>
                        </tr>
                    </thead>
                    <tbody id="tbl_agendamento" class="animate__animated animate__fadeIn">
                        <tr>
                            <td>
                                <div class='d-flex px-2 py-1'>
                                    <div class='d-flex flex-column justify-content-center'>
                                        <h6 class='mb-0 text-sm'>$nome_cliente</h6>
                                        <p class='text-xs text-secondary mb-0'>" . Geral::descriptografia($email_cliente) . "</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p>".implode('/', $data)."</p>
                            </td>
                            <td class='align-middle text-center text-sm'>
                                <p style='display: grid; justify-items: left; align-items: center;'>$hora_inicio</p>
                            </td>
                            <td class='align-middle text-center'>
                                <p style='display: grid; justify-items: left; align-items: center;'>$hora_fim</p>
                            </td>
                            <td class='align-middle'>
                                <p></p>
                            </td>
                            <td class='align-middle'>
                                <p></p>
                            </td>
                            <td class='align-middle'>
                                <p class=''></p>
                            </td>
                            <td class='align-middle'>
                                <a href='".URL_BASE."agendamento/editar/$id_agendamento'>
                                    <i class='fa-solid fa-pen-to-square fa-xl editar' data-id='$id_agendamento' style='color: #00348f; cursor: pointer'></i>
                                </a>
                            </td>
                            <td class='align-middle'>
                                <i class='fa-solid fa-trash-can fa-xl remover' style='color: #b30000; cursor: pointer' data-id='$id_agendamento'></i>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>