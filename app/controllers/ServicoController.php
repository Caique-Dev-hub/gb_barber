<?php


class ServicoController extends Controller
{
    public function adicionar($controle)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($controle == 'servico') {
                $input = [
                    'nome' => filter_input(INPUT_POST, 'nome_servico', FILTER_SANITIZE_SPECIAL_CHARS),
                    'valor' => filter_input(INPUT_POST, 'valor_servico', FILTER_SANITIZE_NUMBER_FLOAT),
                    'tempo' => filter_input(INPUT_POST, 'tempo_servico', FILTER_SANITIZE_NUMBER_INT),
                    'descricao' => filter_input(INPUT_POST, 'descricao_servico', FILTER_SANITIZE_SPECIAL_CHARS)
                ];

                foreach ($input as $valor) {
                    if (empty(trim($valor)) || $_FILES['imagem_servico']['error'] === UPLOAD_ERR_NO_FILE) {
                        self::response('Preencha todos os campos');
                        exit;
                    }
                }

                $img = $_FILES['imagem_servico'];

                $newImg = Geral::tratar_imagem($input['nome'], $img);

                if (!$newImg) {
                    self::response('Erro ao adicionar imagem');
                    exit;
                }

                foreach($input as $campo => $valor){
                    switch($campo){
                        case 'nome':
                            $nome = explode(' ', $valor);

                            foreach($nome as $valor){
                                if(strlen($valor) < 2){
                                    self::response('Nome invalido');
                                    return;
                                }
                            }
                            break;

                        case 'valor':
                            $preco = (float)$valor;
                            break;

                        case 'tempo':
                            $tempo = (int)$valor;
                            $tempo *= 60;

                            $tempo = gmdate('H:i:s', $tempo);
                            break;

                        case 'descricao':
                            $descricao = $valor;

                            if(strlen($descricao) < 10){
                                self::response('Descricao invalida');
                                return;
                            }
                            break;
                    }
                }

                $input['valor'] = $preco;
                $input['tempo'] = $tempo;
                $input['imagem'] = $newImg;

                $addServico = $this->db_servicos->addServico($input);

                if(!$addServico){
                    self::response('Erro ao adicionar servico');
                    return;
                }

                $_SESSION['sucesso'] = 'Servico adicionado com sucesso';
                header('Location:'.URL_BASE.'dash/listar/servicos');
                return;
            }
        }
    }

    private static function response($mensagem)
    {
        $_SESSION['servicoErro'] = $mensagem;
        header('Location:' . URL_BASE . 'dash/listar/servicos');
        return;
    }
}
