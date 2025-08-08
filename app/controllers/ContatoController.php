<?php
class ContatoController extends Controller
{
    public function adicionar_reserva()
    {
        $file = file_get_contents('php://input');
        $file = json_decode($file, true);

        foreach ($file as $campo => $valor) {
            if (empty(trim($valor))) {
                echo 'Preencha todos os campos';
                return;
            }

            switch ($campo) {
                case 'nome':
                    $nome = filter_var($valor, FILTER_SANITIZE_SPECIAL_CHARS);
                    $nome = explode(' ', $nome); //Caique Martins

                    if (count($nome) < 2) {
                        echo 'Coloque seu Nome Completo';
                        return;
                    }

                    foreach ($nome as $valor) {
                        if (strlen($valor) < 2) { //passando por cada nome e conferindo se os caracter esta acima de 2
                            echo 'Nome Inválido';
                            return;
                        }
                    }

                    $nome = implode(' ', $nome); //Caique Martins
                    break;

                case 'email':
                    $email = filter_var($valor, FILTER_SANITIZE_EMAIL);

                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        echo 'E-mail Inválido';
                        return;
                    }
        
                    $email = Controller::criptografia($email);
                    break;

                case 'telefone':
                    $telefone = filter_var($valor, FILTER_SANITIZE_SPECIAL_CHARS);

                    if (strlen($telefone) != 15) {
                        echo 'Telefone Inválido';
                        return;
                    }

                    if (preg_match('/^\(\d{2}\) \d{5}-\d{4}$/', $telefone) == 0) {
                        echo 'Formato Inválido';
                        return;
                    }

                    $telefone = Controller::criptografia($telefone);
                    break;
            }
        }

        $file['servico'] = (int)$file['servico'];

        if ($file['servico'] > 3) {
            $combo = $file['servico'] - 3;

            $file['combo'] = $combo;
        }

        $file['nome'] = $nome; //nome tratado
        $file['email'] = $email; //email tratado
        $file['telefone'] = $telefone; //telefone tratado

        if (isset($file['combo'])) {
            $addcombo = $this->db_reserva->addcombo($file);

            if (!$addcombo) {
                echo 'Erro ao fazer reserva';
                return;
            }

            echo 'Certo';
        } else {
            $addservico = $this->db_reserva->addservico($file);
            
            if (!$addservico) {
                echo 'Erro ao fazer reserva';
                return;
            }

            echo 'Certo';
        }
    }
}
