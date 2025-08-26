<?php


class ServicoController extends Controller
{
    // CRUD
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

    public function adicionar(string $servicoCombo): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($servicoCombo === 'servico') {
                $input = [
                    'nome' => filter_input(INPUT_POST, 'nome_servico', FILTER_SANITIZE_SPECIAL_CHARS),
                    'valor' => filter_input(INPUT_POST, 'valor_servico', FILTER_SANITIZE_NUMBER_FLOAT),
                    'tempo' => filter_input(INPUT_POST, 'tempo_servico', FILTER_SANITIZE_NUMBER_INT),
                    'descricao' => filter_input(INPUT_POST, 'descricao_servico', FILTER_SANITIZE_SPECIAL_CHARS)
                ];

                foreach ($input as $campo => $valor) {
                    switch ($campo) {
                        case 'nome':
                            if (strlen($valor) < 5) {
                                $_SESSION['erro'] = 'Nome de servico invalido';
                                header('Location: ' . URL_BASE . 'servico/listar');
                                exit;
                            }

                            break;

                        case 'valor':
                            if ((float)$valor <= 0) {
                                $_SESSION['erro'] = 'O valor do servico precisa ser maior que R$0,00';
                                header('Location: ' . URL_BASE . 'servico/listar');
                                exit;
                            }

                            $preco = (float)$valor;

                            break;

                        case 'tempo':
                            $tempo = (float)$valor;

                            $tempo /= 60;

                            $tempo = explode('.', (string)$tempo);

                            if ((int)$tempo[0] > 0 && (int)$tempo[0] < 10) {
                                $tempoFormato = "0$tempo[0]:";
                            } else {
                                $tempoFormato = "00:";
                            }

                            if ((int)$tempo[1] > 0 && (int)$tempo[1] < 10) {
                                $tempoFormato .= "0$tempo[1]:";
                            } else {
                                $tempoFormato .= "00:";
                            }

                            $tempoFormato .= "00";

                            break;

                        case 'descricao':
                            if (strlen($valor) < 5) {
                                $_SESSION['erro'] = "Descricao de servico invalido";
                                header('Location: ' . URL_BASE . 'servico/listar');
                                exit;
                            }

                            break;
                    }
                }

                $input['tempo'] = $tempoFormato;
                $input['valor'] = $preco;

                $imagem = $_FILES['imagem_servico'];

                $novoNome = Controller::tratar_imagem($imagem, 'teste');

                if (!$novoNome) {
                    $_SESSION['erro'] = "Nome de imagem ja existente";
                    header('Location: ' . URL_BASE . 'servico/listar');
                    exit;
                }

                $input['imagem'] = $novoNome;

                $addServico = $this->db_servico->addServico($input);

                if (!$addServico) {
                    $_SESSION['erro'] = 'Erro ao adicionar servico';
                    header('Location: ' . URL_BASE . 'servico/listar');
                    exit;
                }

                $_SESSION['sucesso'] = "Servico adicionado com sucesso";
                header('Location: ' . URL_BASE . 'servico/listar');
                exit;
            } else if($servicoCombo === 'combo'){

            } else{
                die("Erro ao adicionar servico");
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
