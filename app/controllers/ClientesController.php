<?php

class ClientesController extends Controller
{

    public function listar()
    {
        $dados = [];

        $dados['clientes'] = $this->db_cliente->getcliente();
        $dados['hidden'] = 'none';
        $dados['conteudo'] = "clientes/listar";
        $this->view("admin/dash", $dados);
    }

    public function excluir($id)
    {
        if (!$id) {
            echo ("Falha ao excluir dados");
            return;
        } else {
            $this->db_cliente->deletecliente($id);
            header('Location:' . URL_BASE . 'clientes/listar');
            exit;
        }
    }

    public function ativar($id)
    {
        $ativarcliente = $this->db_cliente->AtivarCliente($id);
        if (!$ativarcliente) {
            echo "Cliente Não alterado";
            return;
        } else {
            header('Location:' . URL_BASE . 'clientes/listar');
            exit;
        }
    }

    public function addestrela($id)
    {
        if (isset($id)) {
            echo "cliente não identificado";
            return;
        }

        $estrela = $this->db_cliente->addestrela($id);

        if (!$estrela) {
            echo 'Erro';
            return;
        } else {
            echo "cliente favoritado";
            return;
        }
    }

    public function editar($id)
    {
        $dados = [];

        $getclientes = $this->db_cliente->getClienteByid($id);
        $clientes = [
            'nome' => $getclientes['nome_cliente'],
            'telefone' => Controller::descriptografia($getclientes['whatsapp_cliente']),
            'email' => Controller::descriptografia($getclientes['email_cliente']),
            'id' => $getclientes['id_cliente']
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cliente = [
                'nome' => $_POST['nome_cliente'],
                'telefone' => Controller::criptografia($_POST['telefone_cliente']),
                'email' => Controller::criptografia($_POST['email_cliente']),
                'id' => $id
            ];
            $clienteFinal = $this->db_cliente->updateCliente($cliente);

            if (!$clienteFinal) {
                echo "erro ao enviar dados";
                return;
            } else {
                header('Location:' . URL_BASE . 'clientes/listar');
                exit;
            };
        }
        $dados['clientes'] = $clientes;
        $this->view("admin/content/clientes/editar", $dados);
    }
    public function adicionar()
    {
        $dados = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $telefone = filter_input(INPUT_POST, 'whatsapp', FILTER_SANITIZE_SPECIAL_CHARS);
            $senha = $_POST['senha'];
            if (!$nome) {
                echo "campo nome não preenchido";
                return;
            }
            if (!$email) {
                echo "campo email não preenchido";
                return;
            }
            if (!$telefone) {
                echo "campo telefone não preenchido";
                return;
            }
            if (!$senha) {
                echo "campo telefone não preenchido";
                return;
            }

            if (preg_match('/^[a-zA-Z0-9$%&_.-]{2,}\@[a-zA-Z0-9$%&_.-]{2,}\.[a-zA-Z0-9]{2,8}$/', $email) !== 1) {
                echo "email mal formatado";
                return;
            }

            if (preg_match('/^\(\d{2}\) \d{5}-\d{4}$/', $telefone) !== 1) {
                echo "telefone mal formatado";
                return;
            };

            $key = base64_decode($_ENV['CRYPTO_KEY']);

            $email_hash = hash_hmac('sha256', $email, $key);

            $telefone_hash = hash_hmac('sha256', $telefone, $key);

            $campos = [
                'nome' => $nome,
                'email' => Controller::criptografia($email),
                'whatsapp' => Controller::criptografia($telefone),
                'whatsapp_hash' => $telefone_hash,
                'email_hash' => $email_hash,
                'senha' => $_POST['senha']
            ];

            $salvarCliente = $this->db_cliente->addCliente($campos);

            if (!$salvarCliente) {
                echo "erro ao adicionar cliente";
                return;
            } else {
                header('Location:' . URL_BASE . 'clientes/listar');
                exit;
            }
        }
    }
}
