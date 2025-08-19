<?php


class ReservaController extends Controller
{
    public function adicionar_reserva(): void
    {
        if(isset($_SESSION['time'])){
            $time = time();

            if(($time - $_SESSION['time']) < 60){
                echo json_encode([
                    'erro' => 'Aguarde 30 minutos para tentar novamente'
                ]);
                return;
            }
        }

        $input = file_get_contents('php://input');
        $input = json_decode($input, true);

        header('Content-Type: application/json');

        $campos = ['nome', 'email', 'whatsapp', 'servico', 'data', 'horario'];

        if(count($campos) <> count($input)){
            echo json_encode([
                'erro' => 'Envio do formulario corrompido'
            ]);
            return;
        }

        foreach($campos as $valor){
            if(!isset($input[$valor])){
                echo json_encode([
                    'erro' => 'Campo invalido identificado'
                ]);
                return;
            }
        }

        foreach($input as $campo => $valor){
            if(empty(trim($valor))){
                echo json_encode([
                    'erro' => 'Preencha todos os campos'
                ]);
                return;
            }

            switch($campo){
                case 'nome':
                    $nome = filter_var($valor, FILTER_SANITIZE_SPECIAL_CHARS);

                    if(str_word_count($nome) < 2){
                        echo json_encode([
                            'erro' => 'Insira o seu nome completo'
                        ]);
                        return;
                    }

                    $nome = str_word_count($nome, 1);

                    foreach($nome as $valor){
                        if(strlen($valor) < 2){
                            echo json_encode([
                                'erro' => 'Nome invalido'
                            ]);
                            return;
                        }
                    }

                    $nome = implode(' ', $nome);
                    break;

                case 'email':
                    $email = filter_var($valor, FILTER_SANITIZE_EMAIL);

                    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                        echo json_encode([
                            'erro' => 'E-mail invalido'
                        ]);
                        return;
                    }

                    $email = Controller::criptografia($email);

                    break;

                case 'whatsapp':
                    $whatsapp = filter_var($valor, FILTER_SANITIZE_SPECIAL_CHARS);

                    if(preg_match('/^\(\d{2}\) \d{5}-\d{4}$/', $whatsapp) !== 1){
                        echo json_encode([
                            'erro' => 'Formato de numero de whatsapp invalido'
                        ]);
                        return;
                    }

                    $whatsapp = Controller::criptografia($whatsapp);

                    break;

                case 'servico':
                    $servico = (int)$valor;

                    if($servico > 3){
                        $combo = $servico - 3;
                    }

                    break;
            }
        }

        $input['nome'] = $nome;
        $input['email'] = $email;
        $input['whatsapp'] = $whatsapp;
        
        if(isset($combo)){
            $input['combo'] = $combo;

            $addReserva = $this->db_reserva->addCombo($input);
        } else{
            $addReserva = $this->db_reserva->addServico($input);
        }

        if(!$addReserva){
            echo json_encode([
                'erro' => 'Erro ao adicionar reserva'
            ]);
            return;
        }

        echo json_encode([
            'sucesso' => 'Reserva adicionada com sucesso'
        ]);

        if(!isset($_SESSION['count'])){
            $_SESSION['count'] = 1;
            return;
        } else{
            $_SESSION['count']++;

            if($_SESSION['count'] >= 3){
                echo json_encode([
                    'erro' => 'Voce excedeu o limite maximo de reservas (3), aguarde 30 minutos para realizar novamente'
                ]);

                $_SESSION['time'] = time();
                return;
            } else{
                return;
            }
        }
    }
}
