 <?php


    class ServicoController extends Controller
    {
        // CRUD
        public function ativar($tipo, $id)
        {
            $dados = [];
            if ($tipo === "servico") {
                $ativarStatus = $this->db_servico->alterStatusServico($id);
                if (!$ativarStatus) {
                    echo "status Não Ativado, tente novamente";
                    return;
                } else {
                    header('Location:' . URL_BASE . 'servico/listar');
                    exit;
                }
            } else {
                $ativarStatus = $this->db_servico->alterStatusCombo($id);
                if (!$ativarStatus) {
                    echo "status Não Ativado, tente novamente";
                    return;
                } else {
                    header('Location:' . URL_BASE . 'servico/listar');
                    exit;
                }
            }
        }
        public function excluir($tipo, $id)
        {
            $dados = [];
            if ($tipo === "servico") {
                $deleteservico = $this->db_servico->deletarServico($id);
                if (!$deleteservico) {
                    echo ("Serviço não encontrado");
                    return;
                } else {
                    header('Location:' . URL_BASE . 'servico/listar');
                    exit;
                }
            } else {
                $deleteCombo = $this->db_servico->deletarCombo($id);
                if (!$deleteCombo) {
                    echo ("Combo não encontrado");
                } else {
                    header('Location:' . URL_BASE . 'servico/listar');
                    exit;
                }
            };
        }

        public function editar($tipo, $id)
        {
            $dados = [];

            if ($tipo == 'servico') {
                $getservico = $this->db_servico->getServicosByid($id);
                $servico = [
                    'nome' => $getservico['nome_servico'],
                    'descricao' => $getservico['descricao_servico'],
                    'tempo' => $getservico['tempo_estimado'],
                    'valor' => $getservico['valor_servico'],
                    'tipo' => 'servico',
                    'id' => $getservico['id_servico'],
                    'imagem' => $getservico['imagem_servico']
                ];
            } else {
                $getcombo = $this->db_servico->getComboByid($id);

                $servico = [
                    'nome' => $getcombo['nome_combo'],
                    'descricao' => $getcombo['descricao_combo'],
                    'tempo' => $getcombo['tempo_estimado'],
                    'tipo' => 'combo',
                    'id' => $getcombo['id_combo'],
                    'valor' => $getcombo['valor_combo'],
                    'imagem' => $getcombo['imagem_combo']
                ];
            };


            $dados['servico'] = $servico;


            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if ($tipo === 'servico') {
                    $servico = [
                        'nome' => $_POST['nome'],
                        'descricao' => $_POST['descricao'],
                        'valor' => $_POST['valor'],
                        'tempo' => $_POST['tempo'],
                        'imagem' => $_POST['imagem'],
                        'id' => $id
                    ];

                    $serv = $this->db_servico->salvarServico($servico);
                } else {
                    $combo = [
                        'nome' => $_POST['nome'],
                        'descricao' => $_POST['descricao'],
                        'valor' => $_POST['valor'],
                        'tempo' => $_POST['tempo'],
                        'imagem' => $_POST['imagem'],
                        'id' => $id
                    ];
                    $serv = $this->db_servico->salvarCombo($combo);
                }
                //Ao enviar o form
                if (!$serv || !isset($serv)) {
                    $_SESSION['mensage'] = "Erro ao realizar atualização, confira os dados";
                    header('Location:' . URL_BASE . 'servicos/listar');
                    exit;
                } else {
                    $_SESSION['sucess'] = "Dados atualizados com sucesso!";
                    header('Location:' . URL_BASE . 'servico/listar');
                    exit;
                }
            }



            $this->view('admin/content/servicos/editar', $dados);
        }

        public function listar(): void
        {
            $dados = [];

            $servicos = $this->db_servico->getServicos();
            $combos = $this->db_servico->getcombotodos();

            $dados['servicosListar'] = array_merge($servicos, $combos);
            $dados['servicosAdicionar'] = $servicos;

            $dados['hidden'] = 'none';



            $dados['conteudo'] = "servicos/listar";

            $this->view('admin/dash', $dados);
        }

        public function adicionarServico(): void
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $dados = [];

                $imagem = $_FILES['imagem_servico'];
                $nome = filter_input(INPUT_POST, 'nome_servico', FILTER_SANITIZE_SPECIAL_CHARS);
                $valor = filter_input(INPUT_POST, 'valor_servico', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $tempo = filter_input(INPUT_POST, 'tempo_servico', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $descricao = filter_input(INPUT_POST, 'descricao_servico', FILTER_SANITIZE_SPECIAL_CHARS);
                if (!$imagem['name']) {
                    echo ("CAMPO IMAGEM VAZIO PREENCHA!");
                    return;
                }
                if (!$nome) {
                    echo ("CAMPO NOME VAZIO PREENCHA!");
                    return;
                }
                if (!$valor) {
                    echo ("CAMPO VALOR VAZIO PREENCHA!");
                    return;
                }
                if (!$tempo) {
                    echo ("CAMPO TEMPO VAZIO PREENCHA!");
                    return;
                }
                if (!$descricao) {
                    echo ("CAMPO DESCRIÇÂO VAZIO PREENCHA!");
                    return;
                }

                $segundo = $tempo * 60;
                $tempoServico = gmdate('H:i:s', $segundo);

                $dados = [
                    'imagem' => $imagem['name'],
                    'nome' => $nome,
                    'valor' => (float)$valor,
                    'tempo' => $tempoServico,
                    'descricao' => $descricao,
                ];

                $respostaServico = $this->db_servico->adicionarServico($dados);


                if (!$respostaServico) {
                    echo ("erro ao adicionar o servico, tente novamente");
                    return;
                } else {
                    header('Location:' . URL_BASE . 'servico/listar');
                    exit;
                }
            }
        }

        public function adicionarCombo(): void
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $dados = [];

                $imagem = $_FILES['imagem_combo'];
                $servico1 = filter_input(INPUT_POST, 'servico1', FILTER_SANITIZE_SPECIAL_CHARS);
                $servico2 = filter_input(INPUT_POST, 'servico2', FILTER_SANITIZE_SPECIAL_CHARS);
                $valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_NUMBER_FLOAT);
                $tempo = filter_input(INPUT_POST, 'tempo', FILTER_SANITIZE_NUMBER_INT);
                $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);

                if (!isset($imagem)) {
                    echo ("Campo imagem vazio");
                    return;
                }
                if (!$servico1) {
                    echo ("Campo servico1 vazio");
                    return;
                };
                if (!$servico2) {
                    echo ("Campo servico2 vazio");
                    return;
                };
                if (!$valor) {
                    echo ("Campo valor vazio");
                    return;
                };
                if (!$tempo) {
                    echo ("Campo tempo vazio");
                    return;
                };
                if (!$descricao) {
                    echo ("Campo descrição vazio");
                    return;
                };

                $ser1 = $this->db_servico->getServicosByid($servico1);
                $ser2 = $this->db_servico->getServicosByid($servico2);

                $segundo = $tempo * 60;
                $tempoFormado = gmdate('H:i:s', $segundo);


                $combo = $ser1['nome_servico'] . ' + ' . $ser2['nome_servico'];

                $dados = [
                    'id1' => $ser1['id_servico'],
                    'id2' => $ser2['id_servico'],
                    'imagem' => $imagem['name'],
                    'combo' => $combo,
                    'valor' => (float)$valor,
                    'tempo' => $tempoFormado,
                    'descricao' => $descricao,
                ];

                $respostaCombo = $this->db_servico->adicionarCombo($dados);
                var_dump($tempo);
                if (!$respostaCombo) {
                    echo "erro ao criar combo";
                    return;
                } else {
                    header('Location:' . URL_BASE . 'servico/listar');
                    exit;
                }
            }
        }


        public function valor(int $servico1, int $servico2): void
        {
            $valor1 = $this->db_servico->getDetalhe_servico($servico1);
            $valor2 = $this->db_servico->getDetalhe_servico($servico2);

            echo (float)$valor1 + (float)$valor2;
            return;
        }
    }
