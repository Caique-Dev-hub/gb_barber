    <style>
        :root {
            --primary-color: #3a86ff;
            --secondary-color: #8338ec;
            --success-color: #06d6a0;
            --danger-color: #ef476f;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --border-radius: 8px;
            --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }

        .container {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 2rem;
            margin-top: 2rem;
            width: 96%;
            overflow: hidden;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .title {
            font-weight: 600;
            color: var(--dark-color);
            margin: 0;
            font-size: 1.75rem;
        }

        .img-thumbnail {
            width: 120px;
            height: 77px;
            border-radius: 4px;
            object-fit: cover;
            border: 1px solid rgba(0, 0, 0, 0.08);
            transition: var(--transition);
        }

        .img-thumbnail:hover {
            transform: scale(1.05);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .table {
            --bs-table-bg: transparent;
            --bs-table-striped-bg: rgba(58, 134, 255, 0.02);
            --bs-table-hover-bg: rgba(58, 134, 255, 0.05);
            margin-bottom: 0;
        }

        .table thead th {
            background-color: var(--light-color);
            border-bottom-width: 2px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            color: #6c757d;
            padding: 1rem;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .table tbody td {
            padding: 0.5rem;
            vertical-align: middle;
            border-color: rgba(0, 0, 0, 0.03);
        }

        .service-name {
            font-weight: 600;
            color: var(--dark-color);
            transition: var(--transition);
        }

        .service-name:hover {
            color: var(--primary-color);
        }

        .service-description {
            color: #6c757d;
            font-size: 0.9rem;
            white-space: normal;
            /* Alterado de pre-wrap para normal */
            overflow: visible;
            /* Remove o overflow hidden */
            text-overflow: unset;
            /* Remove o ellipsis */
            display: block;
            /* Muda de -webkit-box para block */
            -webkit-line-clamp: unset;
            /* Remove a limitação de linhas */
            -webkit-box-orient: unset;
            /* Remove a orientação do box */
            line-height: 1.5;
            /* Espaçamento entre linhas melhorado */
        }

        .service-price {
            font-weight: 600;
            color: var(--dark-color);
        }

        .service-duration {
            background-color: rgba(58, 134, 255, 0.1);
            color: var(--primary-color);
            padding: 0.25rem 0.5rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            display: inline-block;
        }

        .status-badge {
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-active {
            background-color: rgba(6, 214, 160, 0.1);
            color: var(--success-color);
        }

        .status-inactive {
            background-color: rgba(239, 71, 111, 0.1);
            color: var(--danger-color);
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: var(--transition);
        }

        .btn-edit {
            background-color: rgba(58, 134, 255, 0.1);
            color: var(--primary-color);
            border: none;
        }

        .btn-edit:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-delete {
            background-color: rgba(239, 71, 111, 0.1);
            color: var(--danger-color);
            border: none;
        }

        .btn-delete:hover {
            background-color: var(--danger-color);
            color: white;
        }

        .btn-add {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius);
            font-weight: 500;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-add:hover {
            background-color: #2a75e6;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(58, 134, 255, 0.2);
        }

        .search-box {
            position: relative;
            width: 300px;
        }

        .search-box input {
            padding-left: 2.5rem;
            border-radius: var(--border-radius);
            border: 1px solid rgba(0, 0, 0, 0.1);
            transition: var(--transition);
        }

        .search-box input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(58, 134, 255, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 10;
        }

        /* Modal styles */
        .modal-content {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: var(--box-shadow);
        }

        .modal-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
        }

        .modal-title {
            font-weight: 600;
            color: var(--dark-color);
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.5rem;
        }

        .form-label {
            font-weight: 500;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .form-control,
        .form-select {
            border-radius: var(--border-radius);
            padding: 0.75rem 1rem;
            border: 1px solid rgba(0, 0, 0, 0.1);
            transition: var(--transition);
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(58, 134, 255, 0.1);
        }

        .btn-save {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius);
            font-weight: 500;
            transition: var(--transition);
        }

        .btn-save:hover {
            background-color: #2a75e6;
        }

        .btn-cancel {
            background-color: transparent;
            color: #6c757d;
            border: 1px solid rgba(0, 0, 0, 0.1);
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius);
            font-weight: 500;
            transition: var(--transition);
        }

        .btn-cancel:hover {
            background-color: rgba(0, 0, 0, 0.02);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .search-box {
                width: 100%;
            }

            .table thead {
                display: none;
            }

            .table,
            .table tbody,
            .table tr,
            .table td {
                display: block;
                width: 100%;
            }

            .table tr {
                margin-bottom: 1rem;
                border-radius: var(--border-radius);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
                overflow: hidden;
            }

            .table td {
                padding: 0.75rem;
                border: none;
                border-bottom: 1px solid rgba(0, 0, 0, 0.03);
                position: relative;
                padding-left: 50%;
            }

            .table td::before {
                content: attr(data-label);
                position: absolute;
                left: 1rem;
                top: 50%;
                transform: translateY(-50%);
                font-weight: 600;
                color: var(--dark-color);
                font-size: 0.8rem;
            }

            .action-buttons {
                justify-content: flex-end;
            }
        }
    </style>

    <!-- Modal CSS -->
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #4895ef;
            --secondary: #3f37c9;
            --dark: #1a1a2e;
            --light: #f8f9fa;
            --success: #4cc9f0;
            --danger: #f72585;
            --warning: #f8961e;
            --border-radius: 12px;
            --box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        .btn-open {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
            transition: var(--transition);
            margin: 20px;
        }

        .btn-open:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(67, 97, 238, 0.4);
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 100;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            background-color: rgba(26, 26, 46, 0.8);
            backdrop-filter: blur(4px);
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .modal-content {
            background-color: white;
            margin: auto auto;
            padding: 30px;
            width: 90%;
            max-width: 700px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            animation: slideIn 0.4s;
            position: relative;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .modal-title {
            font-size: 24px;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
        }

        .close {
            color: var(--dark);
            font-size: 28px;
            font-weight: 300;
            cursor: pointer;
            transition: var(--transition);
            opacity: 0.7;
        }

        .close:hover {
            opacity: 1;
            color: var(--danger);
        }

        .tab-buttons {
            display: flex;
            background: #f0f2ff;
            border-radius: 50px;
            padding: 5px;
            margin-bottom: 25px;
        }

        .tab-btn {
            flex: 1;
            padding: 12px;
            text-align: center;
            cursor: pointer;
            border: none;
            background: transparent;
            font-size: 15px;
            font-weight: 500;
            color: var(--dark);
            transition: var(--transition);
            border-radius: 50px;
            outline: none;
        }

        .tab-btn.active {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            box-shadow: 0 4px 8px rgba(67, 97, 238, 0.2);
        }

        .tab-content {
            display: none;
            animation: fadeIn 0.5s;
        }

        .tab-content.active {
            display: block;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }

        .form-col {
            flex: 0 0 50%;
            padding: 0 10px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 0;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
            color: var(--dark);
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e0e3ff;
            border-radius: 8px;
            font-size: 15px;
            transition: var(--transition);
            background-color: #f8f9ff;
        }

        .form-control:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
            outline: none;
            background-color: white;
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        /* Estilo para upload de imagem */
        .image-upload {
            position: relative;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .image-upload-input {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .image-upload-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            border: 2px dashed #e0e3ff;
            border-radius: 8px;
            background-color: #f8f9ff;
            cursor: pointer;
            transition: var(--transition);
        }

        .image-upload-label:hover {
            border-color: var(--primary-light);
            background-color: #f0f2ff;
        }

        .image-upload-icon {
            font-size: 40px;
            color: var(--primary);
            margin-bottom: 10px;
        }

        .image-upload-text {
            font-size: 14px;
            color: var(--dark);
            text-align: center;
        }

        .image-upload-text span {
            color: var(--primary);
            font-weight: 500;
        }

        .image-preview {
            display: none;
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            margin-top: 10px;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            margin-top: 0px;
            gap: 12px;
        }

        .modal-backdrop {
            position: unset;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            border: none;
        }

        .btn-cancel {
            background-color: #f0f2ff;
            color: var(--dark);
        }

        .btn-cancel:hover {
            background-color: #e0e3ff;
        }

        .btn-save {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            box-shadow: 0 4px 12px rgba(67, 97, 238, 0.3);
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(67, 97, 238, 0.4);
        }

        /* Efeito de hover para selects */
        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .modal-content {
                margin: 2% auto;
                width: 95%;
                padding: 20px;
            }

            .tab-buttons {
                flex-direction: column;
                border-radius: 8px;
                padding: 0;
            }

            .tab-btn {
                border-radius: 0;
                padding: 12px;
            }

            .tab-btn:first-child {
                border-top-left-radius: 8px;
                border-top-right-radius: 8px;
            }

            .tab-btn:last-child {
                border-bottom-left-radius: 8px;
                border-bottom-right-radius: 8px;
            }

            .form-col {
                flex: 0 0 100%;
            }
        }
    </style>

    <div class="container">
        <div class="header">
            <h1 class="title">Gestão de Clientes</h1>
            <div class="d-flex align-items-center gap-3">
                <div class="search-box">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="form-control" placeholder="Pesquisar clientes...">
                </div>
                <button class="btn-open" id="openModal">+ Adicionar Cliente</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 100px;">Nome</th>
                        <th style="text-align: center;">Telefone</th>
                        <th style="text-align: center;">E-mail</th>
                        <th>Avaliações</th>
                        <th style="width: 120px;">Status</th>
                        <th style="width: 120px;padding: 14px 34px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $atributo) : ?>
                        <tr>
                            <td data-label="Serviço">
                                <div class="service-name"><?= $atributo['nome_cliente'] ?></div>
                            </td>
                            <td style="text-align: center;" data-label="Whatsapp">
                                <div class="service-description"><?= Controller::descriptografia($atributo['whatsapp_cliente']) ?></div>
                            </td>
                            <td style="text-align: center;" data-label="E-mail">
                                <div class="service-price"><?= Controller::descriptografia($atributo['email_cliente']) ?></div>
                            </td>
                            <td data-label="Avaliações">
                                <?php if ($atributo['estrela_cliente'] == 0) :  ?>
                                    <div class="service-description">
                                        <img class="avaliacaoimg" id="avaliacao" data-id="<?= $atributo['id_cliente'] ?>" style="width: 40px; height: 40px;margin-left: 39px; cursor: pointer;" src="<?= URL_BASE ?>assets/img/estrela.png" alt="">
                                    </div>
                                <?php else: ?>
                                    <div class="service-description">
                                        <img class="avaliacaoimg" style="width: 20px; height: 20px;margin-left: 39px;" src="<?= URL_BASE ?>assets/img/estrela.png" alt="">
                                    </div>
                                <?php endif ?>
                            </td>
                            <td data-label="Status">
                                <?php
                                if (isset($atributo['status_cliente'])) {
                                    if ($atributo['status_cliente'] === 'Ativo') {
                                        echo "<span class=\"status-badge status-active\">Ativo</span>";
                                    } else {
                                        echo "<span class=\"status-badge status-inactive\">Desativado</span>";
                                    }
                                }
                                ?>
                            </td>
                            <td data-label="Ações">
                                <div class="action-buttons">

                                    <a href="<?= URL_BASE ?>clientes/editar/<?= $atributo['id_cliente'] ?>">
                                        <button class="btn btn-icon btn-edit" title="Editar">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                    </a>
                                    <?php if ($atributo['status_cliente'] == 'Ativo') : ?>
                                        <button class="btn btn-icon btn-delete" data-bs-toggle="modal" data-bs-target="#cliente<?= $atributo['id_cliente'] ?>" data-id="" title="Remover">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    <?php else: ?>
                                        <button class="btn btn-icon btn-delete" style="background-color: #06d6a0; color: #043024ff;" data-bs-toggle="modal" data-bs-target="#cliente<?= $atributo['id_cliente'] ?>" data-id="" title="Remover">
                                            <i class="">✔</i>
                                        </button>
                                    <?php endif ?>
                            </td>
                        </tr>
                        <div class="modal fade" id="cliente<?= $atributo['id_cliente'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Voçê deseja realmente excluir este cliente "<?= $atributo['nome_cliente'] ?>" ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <?php if ($atributo['status_cliente'] == 'Ativo'): ?>
                                            <a href="<?= URL_BASE ?>clientes/excluir/<?= $atributo['id_cliente'] ?>">
                                                <button class="btn btn-primary" id="addServico">Desativar</button>
                                            </a>
                                        <?php else : ?>
                                            <a href="<?= URL_BASE ?>clientes/ativar/<?= $atributo['id_cliente'] ?>">
                                                <button class="btn btn-primary" id="addServico">Ativar</button>
                                            </a>
                                        <?php endif ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                    <div id="serviceModal" class="modal">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title">Novo Cliente</h2>
                                <span class="close">&times;</span>
                            </div>

                            <div class="tab-buttons">
                                <button class="tab-btn active" type="button" data-name="servico" onclick="openTab('service-tab')">Cliente</button>
                            </div>

                            <form id="service-tab" class="tab-content active" method="post" action="<?= URL_BASE ?>clientes/adicionar" enctype="multipart/form-data">

                                <div class="form-row">
                                    <div class="form-col">
                                        <div class="form-group">
                                            <label for="nome_servico" class="form-label">Nome do Cliente</label>
                                            <input type="text" id="nome_servico" name="nome" class="tab-content active" placeholder="" required>
                                        </div>
                                    </div>

                                    <div class="form-col">
                                        <div class="form-group">
                                            <label for="valor_servico" class="form-label">Email</label>
                                            <input type="text" id="nome_servico" name="email" class="tab-content active" placeholder="" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-col">
                                        <div class="form-group">
                                            <label for="tempo_servico" class="form-label">Whatsapp</label>
                                            <input type="text" id="telefone" name="whatsapp" class="tab-content active" placeholder="" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="descricao_servico" class="form-label">Senha</label>
                                    <input type="password" id="nome_servico" name="senha" class="tab-content active" placeholder="" required>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-cancel">Cancelar</button>
                                    <button class="btn btn-save" id="addServico" type="submit">Salvar Serviço</button>
                                </div>
                            </form>


                        </div>
                    </div>
                </tbody>
            </table>
        </div>
    </div>



    <script>
        document.querySelectorAll('.avaliacaoimg').foreach(valor => [
            valor.addEventListener('click', function() {
                const id = this.dataset.id;

                fetch(`<?= URL_BASE ?>cliente/addestrela/${id}`)
                    .then(response => response.text())
                    .then(data => {
                        alert(data)
                        console.log(data)
                    })
                    .catch(error => {
                        console.error(error)
                    })
            })
        ])
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('telefone').addEventListener('input', function(e) {
            let x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,5})(\d{0,4})/);
            e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
        });
    </script>
    <script>
        // Abrir modal
        document.getElementById('openModal').onclick = function() {
            document.getElementById('serviceModal').style.display = 'block';
        }

        // Fechar modal
        document.querySelector('.close').onclick = function() {
            document.getElementById('serviceModal').style.display = 'none';
        }

        document.querySelector('.btn-cancel').onclick = function() {
            document.getElementById('serviceModal').style.display = 'none';
        }

        // Fechar ao clicar fora do modal
        window.onclick = function(event) {
            if (event.target == document.getElementById('serviceModal')) {
                document.getElementById('serviceModal').style.display = 'none';
            }
        }

        // Trocar entre abas
        function openTab(tabId) {
            // Esconder todas as abas
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });

            // Mostrar a aba selecionada
            document.getElementById(tabId).classList.add('active');

            // Atualizar botões ativos
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active');
            });

            event.currentTarget.classList.add('active');

            // Atualizar texto do botão de salvar
            const saveBtn = document.getElementById('addServico');
            saveBtn.textContent = tabId === 'service-tab' ? 'Salvar Serviço' : 'Salvar Combo';
        }

        // Preview da imagem para serviço
        document.getElementById('service-image').addEventListener('change', function(e) {
            const preview = document.getElementById('service-image-preview');
            const file = e.target.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }

                reader.readAsDataURL(file);
            }
        });

        // Preview da imagem para combo
        document.getElementById('combo-image').addEventListener('change', function(e) {
            const preview = document.getElementById('combo-image-preview');
            const file = e.target.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }

                reader.readAsDataURL(file);
            }
        });

        // Drag and drop para imagens
        function setupDragDrop(uploadInput, previewId) {
            const uploadLabel = uploadInput.nextElementSibling;

            uploadLabel.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadLabel.style.borderColor = '#4361ee';
                uploadLabel.style.backgroundColor = '#e0e3ff';
            });

            uploadLabel.addEventListener('dragleave', () => {
                uploadLabel.style.borderColor = '#e0e3ff';
                uploadLabel.style.backgroundColor = '#f8f9ff';
            });

            uploadLabel.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadLabel.style.borderColor = '#e0e3ff';
                uploadLabel.style.backgroundColor = '#f8f9ff';

                if (e.dataTransfer.files.length) {
                    uploadInput.files = e.dataTransfer.files;
                    const event = new Event('change');
                    uploadInput.dispatchEvent(event);
                }
            });
        }

        // Configurar drag and drop para ambos os uploads
        setupDragDrop(document.getElementById('service-image'), 'service-image-preview');
        setupDragDrop(document.getElementById('combo-image'), 'combo-image-preview');
    </script>