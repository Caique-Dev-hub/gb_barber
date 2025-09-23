 <?php


    class ServicoController extends Controller
    {
        // CRUD
        public function excluir($tipo, $id)
        {
            $dados = [];

            if ($tipo === "servico") {
                $deleteservico = $this->db_servico->deletarServico($id);
                if (!$deleteservico) {
                    echo ("Serviço não encontrado");
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

                $dados = [
                    'imagem' => $imagem['name'],
                    'nome' => $nome,
                    'valor' => (float)$valor,
                    'tempo' => $tempo,
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
