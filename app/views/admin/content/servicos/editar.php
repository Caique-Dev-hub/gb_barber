<?php

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar</title>
    <style>
        /* Layout Geral */
        body {
            font-family: Arial, sans-serif;
            background: #f5f6fa;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .content {
            max-width: 700px;
            margin: 220px auto;
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        h2 {
            margin-bottom: 20px;
            color: #444;
        }

        /* Formulários */
        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
            color: #444;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #007bff;
            outline: none;
        }

        /* Imagens */
        .form-group img {
            margin-top: 10px;
            border-radius: 8px;
            border: 1px solid #ddd;
            max-width: 150px;
            display: block;
        }

        /* Botões */
        .form-actions {
            margin-top: 25px;
            display: flex;
            gap: 10px;
        }

        button,
        a.btn-primary,
        a.btn-cancel {
            padding: 10px 18px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            display: inline-block;
            transition: background 0.2s, transform 0.1s;
        }

        button:hover,
        a:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: #007bff;
            color: #fff;
        }

        .btn-primary:hover {
            background: #0069d9;
        }

        .btn-cancel {
            background: #6c757d;
            color: #fff;
        }

        .btn-cancel:hover {
            background: #5a6268;
        }
    </style>
</head>

<body>
    <div class="content">
        <h2>Editar Serviço</h2>
        <form method="post" action="<?= URL_BASE ?>servico/editar/<?= $servico['tipo']?>/<?= $servico['id'] ?>">
            <div class="form-group">
                <label for="nome_servico">Servico</label>
                <input type="text" id="nome_servico" value="<?= $servico['nome'] ?? ''?>" name="nome">
            </div>

            <div class="form-group">
                <label for="valor_servico">Valor:</label>
                <input type="text" id="valor_servico" value="<?= $servico['valor'] ?>" name="valor">
            </div>

            <div class="form-group">
                <label for="tempo_servico">Tempo:</label>
                <input type="text" id="tempo_servico" name="tempo" value="<?= $servico['tempo'] ?>">
            </div>

            <div class="form-group">
                <label for="imagem_servico">Imagem:</label>
                <input type="file" id="imagem_servico" accept="image/*" name="imagem" >
                <br>
            </div>

            <div class="form-group">
                <label for="tempo_servico">Descrição:</label>
                <input type="text" id="" name="descricao" value="<?= $servico['descricao'] ?>">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">Salvar Alterações</button>
                <a href="<?= URL_BASE ?>servico/listar" class="btn-cancel">Cancelar</a>
            </div>


        </form>

        <hr>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputTempo = document.getElementById('tempo_servico');

            // Função para validar o formato HH:mm:ss
            function validarFormatoTempo(tempo) {
                const regex = /^(?:2[0-3]|[01]?[0-9]):[0-5]?[0-9]:[0-5]?[0-9]$/;
                return regex.test(tempo);
            }

            // Adiciona um listener para o evento 'change'
            inputTempo.addEventListener('change', function() {
                const valor = this.value;

                // Se o valor for "60 min", ou qualquer outro valor fora do formato,
                // e for diferente do formato correto, mostre o alerta.
                if (!validarFormatoTempo(valor)) {
                    alert('Formato de tempo inválido! Por favor, use o formato HH:mm:ss.');
                    this.value = ''; // Opcional: limpa o campo se o formato for inválido
                }
            });

            // Opcional: Adicionar um placeholder para orientar o usuário
            inputTempo.placeholder = 'HH:mm:ss';

        });
    </script>
</body>

</html>