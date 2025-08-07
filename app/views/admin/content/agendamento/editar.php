<style>
    .form-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
        padding: 40px;
        width: 100%;
        max-width: 1000px;
        position: relative;
        margin: 0 auto;
    }

    .form-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .form-title {
        font-size: 28px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 8px;
    }

    .form-subtitle {
        font-size: 14px;
        color: #7f8c8d;
        line-height: 1.5;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
    }

    .form-label.required::after {
        content: " *";
        color: #e74c3c;
    }

    .form-input,
    .form-select {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #ecf0f1;
        border-radius: 8px;
        font-size: 16px;
        background: #fafbfc;
        transition: all 0.3s ease;
        outline: none;
    }

    .form-input:focus,
    .form-select:focus {
        border-color: #ea6666ff;
        background: white;
        box-shadow: 0 0 0 3px rgba(234, 102, 102, 0.1);
    }

    .form-input::placeholder {
        color: #bdc3c7;
    }

    .form-select {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 12px center;
        background-repeat: no-repeat;
        background-size: 16px;
        padding-right: 40px;
    }

    .form-select option {
        padding: 10px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .price-input {
        position: relative;
    }

    .price-input::before {
        content: "R$";
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #7f8c8d;
        font-weight: 600;
        z-index: 1;
    }

    .price-input .form-input {
        padding-left: 45px;
    }

    .button-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-top: 30px;
    }

    .btn {
        padding: 14px 24px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #ea6666ff 0%, #a24b4bff 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(234, 102, 102, 0.3);
    }

    .btn-secondary {
        background: white;
        color: #ea6666ff;
        border: 2px solid #ea6666ff;
    }

    .btn-secondary:hover {
        background: #ea6666ff;
        color: white;
        transform: translateY(-2px);
    }

    .form-icon {
        position: absolute;
        top: -20px;
        left: 50%;
        transform: translateX(-50%);
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #ea6666ff 0%, #a24b4bff 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
    }

    @media (max-width: 480px) {
        .form-container {
            padding: 30px 20px;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .button-group {
            grid-template-columns: 1fr;
        }
    }

    /* Animações */
    .form-container {
        animation: slideUp 0.5s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Estilo personalizado para WhatsApp */
    .whatsapp-input {
        position: relative;
    }

    /* Estilos dos botões de toggle */
    .toggle-buttons {
        display: flex;
        gap: 10px;
        margin-top: 20px;
        justify-content: center;
    }

    .toggle-btn {
        padding: 10px 20px;
        border: 2px solid #ea6666ff;
        border-radius: 25px;
        background: white;
        color: #ea6666ff;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .toggle-btn.active {
        background: #ea6666ff;
        color: white;
    }

    .toggle-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(234, 102, 102, 0.3);
    }

    /* Estilo para campos desabilitados */
    .form-input:disabled,
    .form-select:disabled {
        background: #f8f9fa;
        color: #6c757d;
        cursor: not-allowed;
        opacity: 0.6;
    }

    .form-group.disabled .form-label {
        color: #6c757d;
    }
</style>

<div class="form-container animate__animated animate__fadeInRight" id="editar">
    <div class="form-icon">📅</div>

    <div class="form-header">
        <h1 class="form-title">Editar Agendamento</h1>
        <p class="form-subtitle">Edite um agendamento preenchendo o formulário abaixo.</p>
    </div>

    <form id="agendamentoForm">
        <div class="form-group" id="nomeGroup">
            <label class="form-label required" for="nome">Nome Completo</label>
            <input type="text" id="nome_edit" class="form-input" value="<?= $editar['nome_cliente'] ?>" placeholder="Digite o nome completo" disabled>
        </div>

        <div class="form-group">
            <label class="form-label required" for="email">E-mail</label>
            <input type="email" id="email_edit" class="form-input" value="<?= Geral::descriptografia($editar['email_cliente']) ?>" placeholder="seu@email.com" disabled>
        </div>

        <div class="form-group" id="whatsappGroup">
            <label class="form-label required" for="whatsapp">WhatsApp</label>
            <div class="whatsapp-input">
                <input type="tel" id="whatsapp_edit" maxlength="15" class="form-input" value="<?= Geral::descriptografia($editar['whatsapp_cliente']) ?>" placeholder="(11) 99999-9999" disabled>
            </div>
        </div>

        <div class="form-group" id="chaveGroup">
            <label class="form-label required" for="chave">Chave de acesso</label>
            <div class="chave-input">
                <input type="text" id="chave_edit" value="<?= Geral::descriptografia($editar['chave_agendamento']) ?>" maxlength="15" class="form-input" placeholder="Chave privativa usada para identificacao" required>
            </div>
        </div>

        <?php

        $servicos_editar = $this->db_dashboard->getServico_agendamento_editar($editar['id_agendamento']);

        ?>

        <div class="form-group">
            <label class="form-label required" for="servico1">Serviço</label>
            <select id="servico1" class="form-select servico" required>
                <option value="<?= $servicos_editar[0]['id_servico'] ?>"><?= $servicos_editar[0]['nome_servico'] ?></option>
                <?php foreach ($servicos as $atributo) : ?>
                    <?php if ($servicos_editar[$i]['id_servico'] <> $atributo['id_servico']) : ?>
                        <option value="<?= $atributo['id_servico'] ?>"><?= $atributo['nome_servico'] ?></option>
                    <?php endif ?>
                <?php endforeach ?>
            </select>
        </div>

        <?php if (isset($servicos_editar[1])) : ?>
            <div class="form-group">
                <label class="form-label required" for="servico2">Segundo Serviço (opcional)</label>
                <select id="servico2" class="form-select servico" required>
                    <option value="<?= $servicos_editar[1]['id_servico'] ?>"><?= $servicos_editar[1]['nome_servico'] ?></option>
                    <?php foreach ($servicos as $atributo) : ?>
                        <option value="<?= $atributo['id_servico'] ?>"><?= $atributo['nome_servico'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        <?php else: ?>
            <div class="form-group">
                <label class="form-label" for="servico2">Segundo Serviço (opcional)</label>
                <select id="servico2" class="form-select servico">
                    <option value="0" selected>Selecione o segundo Serviço (opcional)</option>
                    <?php foreach ($servicos as $atributo) : ?>
                        <option value="<?= $atributo['id_servico'] ?>"><?= $atributo['nome_servico'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        <?php endif; ?>

        <?php if (isset($servicos_editar[2])) : ?>
            <div class="form-group">
                <label class="form-label required" for="servico2">Terceiro Serviço (opcional)</label>
                <select id="servico3" class="form-select servico" required>
                    <option value="">Selecione um serviço</option>
                    <option value="<?= $servicos_editar[2]['id_servico'] ?>" selected><?= $servicos_editar[2]['nome_servico'] ?></option>
                    <?php foreach ($servicos as $atributo) : ?>
                        <?php if ($servicos_editar[2]['id_servico'] <> $atributo['id_servico']) : ?>
                            <option value="<?= $atributo['id_servico'] ?>"><?= $atributo['nome_servico'] ?></option>
                        <?php endif ?>
                    <?php endforeach ?>
                </select>
            </div>
        <?php else: ?>
            <div class="form-group">
                <label class="form-label" for="servico3">Terceiro Serviço (opcional)</label>
                <select id="servico3" class="form-select servico">
                    <option value="0" selected>Selecione o terceiro Serviço (opcional)</option>
                    <?php foreach ($servicos as $atributo) : ?>
                        <option value="<?= $atributo['id_servico'] ?>"><?= $atributo['nome_servico'] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        <?php endif ?>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label required" for="data">Data</label>
                <select id="data" class="form-select" required>
                    <option value="<?= $editar['id_data'] ?>" selected><?= $editar['nome_data'] ?></option>
                    <?php foreach ($data as $atributo) : ?>
                        <?php if ($editar['nome_data'] <> $atributo['nome_data']) : ?>
                            <option value="<?= $atributo['id_data'] ?>"><?= $atributo['nome_data'] ?></option>
                        <?php endif ?>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label required" for="horario">Horário</label>
                <select id="horario" class="form-select">
                    <option value="<?= $editar['id_horario'] ?>"><?= $editar['hora_inicio'] . ' ate as ' . $editar['hora_fim'] ?></option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="valor">Valor do Serviço (R$)</label>
            <div class="price-input">
                <input type="number" value="<?= $editar['valor_agendamento'] ?>" id="valor" class="form-input" placeholder="0,00" step="0.01" min="0" disabled>
            </div>
        </div>

        <div class="button-group">
            <button type="button" id="editar_agendamento" data-id="<?= $editar['id_agendamento'] ?>" class="btn btn-primary">📅 Editar Agendamento</button>
            <button type="button" class="btn btn-secondary" onclick="limparFormulario()">🔄 Retornar</button>
        </div>
    </form>
</div>

<!-- Javascript  -->
<script>
    // Formatação automática do WhatsApp
    document.getElementById('whatsapp_edit').editEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 11) {
            value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
        } else if (value.length >= 7) {
            value = value.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
        } else if (value.length >= 3) {
            value = value.replace(/(\d{2})(\d{0,5})/, '($1) $2');
        }
        e.target.value = value;
    });

    function toggleClienteMode(isExistente) {
        const nomeInput = document.getElementById('nome_edit');
        const whatsappInput = document.getElementById('whatsapp_edit');
        const nomeGroup = document.getElementById('nomeGroup');
        const whatsappGroup = document.getElementById('whatsappGroup');
        const novoClienteBtn = document.getElementById('novoClienteBtn');
        const clienteExistenteBtn = document.getElementById('clienteExistenteBtn');

        if (isExistente) {
            // Modo cliente existente
            nomeInput.disabled = true;
            whatsappInput.disabled = true;
            nomeInput.required = false;
            whatsappInput.required = false;
            nomeGroup.classList.edit('disabled');
            whatsappGroup.classList.edit('disabled');

            // Preenche com valores placeholder
            nomeInput.placeholder = "Nome será carregado do email";
            nomeInput.value = null;
            whatsappInput.placeholder = "WhatsApp será carregado do email";
            whatsappInput.value = null;

            // Atualiza botões
            novoClienteBtn.classList.remove('active');
            clienteExistenteBtn.classList.edit('active');
        } else {
            // Modo novo cliente
            nomeInput.disabled = false;
            whatsappInput.disabled = false;
            nomeInput.required = true;
            whatsappInput.required = true;
            nomeGroup.classList.remove('disabled');
            whatsappGroup.classList.remove('disabled');

            // Restaura placeholders originais
            nomeInput.placeholder = "Digite o nome completo";
            whatsappInput.placeholder = "(11) 99999-9999";

            // Atualiza botões
            novoClienteBtn.classList.edit('active');
            clienteExistenteBtn.classList.remove('active');
        }
    }
</script>


<!-- AJAX -->



<!-- Servico -->
<script>
    let servico1 = 0.00;
    let servico2 = 0.00;
    let servico3 = 0.00;

    document.editEventListener('DOMContentLoaded', function() {
        let id1 = document.getElementById('servico1').value;
        let id2 = document.getElementById('servico2').value;
        let id3 = document.getElementById('servico3').value;

        function valor_editar(id, controle) {
            fetch(`<?= URL_BASE ?>dash/valor_servico/${id}`)

                .then(response => response.text())
                .then(data => {
                    switch (controle) {
                        case 1:
                            servico1 = data
                            break;

                        case 2:
                            servico2 = data
                            break;

                        default:
                            servico3 = data
                            break;
                    }
                })
        }

        valor_editar(id1, 1);
        valor_editar(id2, 2);
        valor_editar(id3, 3);
    })


    document.getElementById('servico1').addEventListener('change', function() {
        let id = this.value;

        fetch(`<?= URL_BASE ?>dash/valor_servico/${id}`)

            .then(response => response.text())
            .then(data => {
                servico1 = data
                valor()
            })

            .catch(error => {
                alert(error);
            })
    })

    document.getElementById('servico2').addEventListener('change', function() {
        let id = this.value;

        fetch(`<?= URL_BASE ?>dash/valor_servico/${id}`)

            .then(response => response.text())
            .then(data => {
                servico2 = data
                valor()
            })

            .catch(error => {
                alert(error);
            })
    })

    document.getElementById('servico3').addEventListener('change', function() {
        let id = this.value;

        fetch(`<?= URL_BASE ?>dash/valor_servico/${id}`)

            .then(response => response.text())
            .then(data => {
                servico3 = data
                valor()
            })

            .catch(error => {
                alert(error);
            })
    })

    function valor() {
        document.getElementById('valor').value = parseFloat(servico1) + parseFloat(servico2) + parseFloat(servico3)
    }
</script>

<script>
    document.getElementById('editar_agendamento').addEventListener('click', function() {
        let id_agendamento = this.dataset.id

        let input = {
            'chave': document.getElementById('chave_edit').value,
            'servicos': [
                document.getElementById('servico1').value,
                document.getElementById('servico2').value,
                document.getElementById('servico3').value
            ],
            'data': document.getElementById('data').value,
            'horario': document.getElementById('horario').value,
            'valor': document.getElementById('valor').value
        }

        fetch(`<?= URL_BASE ?>agendamento/editar/${id_agendamento}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'Application/json'
                },
                body: JSON.stringify(input)
            })

            .then(response => response.text())
            .then(data => {
                sucesso('Registrado', data)
            })

            .catch(error => {
                alert(error)
            })
    })
</script>