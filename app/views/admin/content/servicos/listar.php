    <style>
        .cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .service-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        }

        .service-image {
            width: 100%;
            height: 160px;
            object-fit: cover;
        }

        .service-content {
            padding: 1rem 1.25rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .service-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .service-description {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 1rem;
            line-height: 1.4;
            flex-grow: 1;
        }

        .service-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .service-price {
            font-weight: 600;
            color: var(--primary-color);
        }

        .service-duration {
            background-color: rgba(58, 134, 255, 0.1);
            color: var(--primary-color);
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .service-status {
            margin-bottom: 1rem;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
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

    <div class="cards-container">
        <?php foreach ($servicosListar as $atributo) : ?>
            <div class="service-card">
                <img src="<?= URL_BASE?>upload/<?= $atributo['imagem_servico'] ?? $atributo['imagem_combo']?>"
                    alt="Corte de Cabelo" class="service-image">

                <div class="service-content">
                    <h3 class="service-name"><?= $atributo['nome_combo'] ?? $atributo['nome_servico'] ?></h3>
                    <p class="service-description"><?= $atributo['descricao_combo'] ?? $atributo['descricao_servico'] ?></p>

                    <div class="service-info">
                        <span class="service-price">💰 R$
                            <?= isset($atributo['valor_servico']) ? str_replace('.', ',', $atributo['valor_servico']) : str_replace('.', ',', $atributo['valor_combo']) ?>
                        </span>

                        <span class="service-duration">
                            <?php
                            $horario = explode(':', $atributo['tempo_estimado']);
                            if ((int)$horario[0] > 0) {
                                if ((int)$horario[1] > 0) {
                                    echo "$horario[0]h e $horario[1]min";
                                } else {
                                    echo "$horario[0]h";
                                }
                            } else {
                                if ((int)$horario[1] > 0) {
                                    echo "$horario[1]min";
                                }
                            }
                            ?>
                        </span>
                    </div>

                    <div class="service-status">
                        <?php
                        if (isset($atributo['status_servico'])) {
                            if ($atributo['status_servico'] === 'Ativo') {
                                echo "<span class='status-badge status-active'>Ativo</span>";
                            } else {
                                echo "<span class='status-badge status-inactive'>Inativo</span>";
                            }
                        } else {
                            if ($atributo['status_combo'] === 'Ativo') {
                                echo "<span class='status-badge status-active'>Ativo</span>";
                            } else {
                                echo "<span class='status-badge status-inactive'>Inativo</span>";
                            }
                        }
                        ?>
                    </div>

                    <div class="action-buttons">
                        <?php if (isset($atributo['id_servico'])): ?>
                            <a href="<?= URL_BASE ?>servico/editar/servico/<?= $atributo['id_servico'] ?>">
                                <button class="btn btn-icon btn-edit" title="Editar">
                                    <i class="fas fa-pen"></i>
                                </button>
                            </a>
                        <?php else: ?>
                            <a href="<?= URL_BASE ?>servico/editar/combo/<?= $atributo['id_combo'] ?>">
                                <button class="btn btn-icon btn-edit" title="Editar">
                                    <i class="fas fa-pen"></i>
                                </button>
                            </a>
                        <?php endif; ?>

                        <?php if (isset($atributo['id_servico'])): ?>
                            <?php if ($atributo['status_servico'] == 'Ativo') : ?>
                                <button class="btn btn-icon btn-delete" data-bs-toggle="modal" data-bs-target="#servico<?= $atributo['id_servico'] ?>" title="Remover">
                                    <i class="fas fa-trash"></i>
                                </button>
                            <?php else: ?>
                                <button class="btn btn-icon btn-delete1" data-bs-toggle="modal" data-bs-target="#servico<?= $atributo['id_servico'] ?>" title="Ativar">
                                    <i>✔</i>
                                </button>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if ($atributo['status_combo'] == 'Ativo') : ?>
                                <button class="btn btn-icon btn-delete" data-bs-toggle="modal" data-bs-target="#combo<?= $atributo['id_combo'] ?>" title="Remover">
                                    <i class="fas fa-trash"></i>
                                </button>
                            <?php else: ?>
                                <button class="btn btn-icon btn-delete1" data-bs-toggle="modal" data-bs-target="#combo<?= $atributo['id_combo'] ?>" title="Ativar">
                                    <i>✔</i>
                                </button>
                            <?php endif; ?>
                        <?php endif ?>
                    </div>
                </div>
            </div>

            <!-- Modal permanece o mesmo -->
            <div class="modal fade" id="<?= isset($atributo['id_servico']) ? "servico" . $atributo['id_servico'] : "combo" . $atributo['id_combo'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Confirmação</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <?php if ($atributo['status_servico'] ?? $atributo['status_combo'] === 'Ativo') : ?>
                            <div class="modal-body">
                                Deseja realmente desativar o item "<b><?= $atributo['nome_servico'] ?? $atributo['nome_combo'] ?></b>"?
                            </div>
                        <?php else: ?>
                            <div class="modal-body">
                                Deseja realmente ativar o item "<b><?= $atributo['nome_servico'] ?? $atributo['nome_combo'] ?></b>"?
                            </div>
                        <?php endif; ?>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <?php if ($atributo['status_servico'] ?? $atributo['status_combo'] == 'Ativo') : ?>
                                <a href="<?= URL_BASE ?>servico/excluir/<?= isset($atributo['id_servico']) ? "servico" : "combo" ?>/<?= $atributo['id_servico'] ?? $atributo['id_combo'] ?>">
                                    <button class="btn btn-primary">Desativar</button>
                                </a>
                            <?php else : ?>
                                <a href="<?= URL_BASE ?>servico/ativar/<?= isset($atributo['id_servico']) ? "servico" : "combo" ?>/<?= $atributo['id_servico'] ?? $atributo['id_combo'] ?>">
                                    <button class="btn btn-primary">Ativar</button>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>


    <div id="serviceModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Novo Serviço/Combo</h2>
                <span class="close">&times;</span>
            </div>

            <div class="tab-buttons">
                <button class="tab-btn active" type="button" data-name="servico" onclick="openTab('service-tab')">Serviço Individual</button>
                <button class="tab-btn" type="button" data-name="combo" onclick="openTab('combo-tab')">Combo de Serviços</button>
            </div>














































            <form id="service-tab" class="tab-content active" method="post" action="<?= URL_BASE ?>servico/adicionarServico" enctype="multipart/form-data">
                <!-- Upload de imagem -->
                <div class="form-group">
                    <label for="imagem_servico">Imagem:</label>
                    <input type="file" id="imagem_servico" accept="image/*" name="imagem_servico">
                    <br>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="nome_servico" class="form-label">Nome do Serviço</label>
                            <input type="text" id="nome_servico" name="nome_servico" class="form-control" placeholder="Ex: Corte de Cabelo Masculino" required>
                        </div>
                    </div>

                    <div class="form-col">
                        <div class="form-group">
                            <label for="valor_servico" class="form-label">Valor (R$)</label>
                            <input type="number" id="valor_servico" name="valor_servico" class="form-control" step="0.01" placeholder="Ex: 45,90" required>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="tempo_servico" class="form-label">Tempo Estimado (min)</label>
                            <input type="text" id="tempo_servico" name="tempo_servico" class="form-control" placeholder="Ex: 30" required>
                        </div>
                    </div>

                    <div class="form-col">
                        <!-- Espaço reservado para possível segundo campo -->
                    </div>
                </div>

                <div class="form-group">
                    <label for="descricao_servico" class="form-label">Descrição</label>
                    <textarea id="descricao_servico" name="descricao_servico" class="form-control" placeholder="Descreva detalhes sobre o serviço..."></textarea>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-cancel">Cancelar</button>
                    <button class="btn btn-save" id="addServico" type="submit">Salvar Serviço</button>
                </div>
            </form>

            <form id="combo-tab" class="tab-content" method="post" action="<?= URL_BASE ?>servico/adicionarCombo" enctype="multipart/form-data">
                <!-- Upload de imagem para combo -->
                <div class="form-group">
                    <label for="imagem_servico">Imagem:</label>
                    <input type="file" id="imagem_combo" accept="image/*" name="imagem_combo">
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="servico1" class="form-label">Primeiro Serviço</label>
                            <select name="servico1" id="servico1" class="form-control">
                                <option value="">Selecione um serviço</option>
                                <?php foreach ($servicosAdicionar as $atributos) : ?>
                                    <option value="<?= $atributos['id_servico'] ?>"><?= $atributos['nome_servico'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-col">
                        <div class="form-group">
                            <label for="servico2" class="form-label">Segundo Serviço</label>
                            <select name="servico2" id="servico2" class="form-control">
                                <option value="">Selecione um serviço</option>
                                <?php foreach ($servicosAdicionar as $atributos) : ?>
                                    <option value="<?= $atributos['id_servico'] ?>"><?= $atributos['nome_servico'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label for="combo-value" class="form-label">Valor Total (R$)</label>
                            <input name="valor" type="text" id="combo-value" class="form-control" placeholder="Ex: 75,00">
                        </div>
                    </div>

                    <div class="form-col">
                        <div class="form-group">
                            <label for="combo-time" class="form-label">Tempo Total (min)</label>
                            <input name="tempo" type="text" id="combo-time" class="form-control" placeholder="Ex: 60">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="combo-description" class="form-label">Descrição</label>
                    <textarea name="descricao" id="combo-description" class="form-control" placeholder="Descreva o que está incluído no combo..."></textarea>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-cancel">Cancelar</button>
                    <button class="btn btn-save" type="submit" id="addServico">Salvar Combo</button>
                </div>
            </form>













































        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


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