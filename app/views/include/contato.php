<section id="contato" style="background: linear-gradient(180deg, #000000 0%, #18181800 100%);">
    <video src="<?= URL_BASE ?>assets/img/video-contact.mp4"
        autoplay
        loop
        muted
        preload="auto"
        width="100%"
        poster="<?= URL_BASE ?>assets/img/poster-image.jpg"
        style="height:auto; display: block; background-color: #000; position: absolute; z-index:-2;"></video>
    <div class="contato" style="z-index: 1;">
        <div class="conteiner-info">
            <div class="containers">
                <div class="">
                    <div class="text-contact">
                        <div class="text1">
                            <img src="<?= URL_BASE ?>assets/img/logo-gb.png" alt="">
                        </div class="text2">
                        <div class="box1-contact">
                            <h3>telefone</h3>
                            <p>(11) 95853-8834</p>
                        </div>
                        <div class="box2-contact">
                            <h3>Endereço</h3>
                            <p>Rua Henrique Jacobs, 689 - Vila Santa Teresa, <br> São Paulo - SP, 03566-010</p>
                        </div>
                    </div>
                </div>
            </div>
            <form class="form-contato" id="reserva" method="post" action="">
                <div style="margin: 0 auto; ">
                    <h3>Faça sua reserva</h3>
                </div>

                <div class="container-menu">
                    <div class="input-name">
                        <label for="_name" style="width: 50px;color: white;">Nome:</label>
                        <input type="text" placeholder="Nome completo" id="name" name="nome_reserva" required>
                    </div>
                    <div class="input-name">
                        <label for="_tel" style="width: 50px;color: white;">Telefone:</label>
                        <input type="text" id="telefone" placeholder="(11) 99999-9999" maxlength="15" name="telefone_reserva" required>
                    </div>
                </div>
                <div class="container-menu">
                    <div class="input-name">
                        <label style="width: 50px;color: white;" for="">E-mail</label>
                        <input style="WIDTH:660px;" type="text" id="email" placeholder="@example.com" name="email_reserva" required>
                    </div>
                </div>
                <div class="container-form">
                    <div class="container-menu" style="display: flex;flex-direction: column; ">
                        <label class="" style="margin-left: 10px;width: 50px;color: white;" for="inputGroupSelect01">Serviços</label>
                        <select class="" name="servico_reserva" id="inputGroupSelect01" style="width: 658px;height: 50px;background-color: #282626;border: none;border-radius: 10px;color: #fff;padding: 0.8rem; margin-left: 10px;" required>
                            <option value="0" selected></option>
                            <?php foreach ($todosservico as $coluna) : ?>
                                <option value="<?= isset($coluna['id_servico']) ? $coluna['id_servico'] : $coluna['id_combo'] + 3 ?>"><?= isset($coluna['nome_servico']) ? $coluna['nome_servico'] . ' ' . 'R$' . str_replace('.', ',', $coluna['valor_servico']) : $coluna['nome_combo'] . ' ' . 'R$' . str_replace('.', ',', $coluna['valor_combo'])  ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="container-menu" style="display: flex; margin-top: 26px;">
                    <select class="" id="data" style="width: 325px;height: 50px;background-color: #282626;border: none;border-radius: 10px;color: #fff;padding: 0.8rem; margin-left: 10px;" required>
                        <option value="0" selected>Selecione algum Dia</option>
                        <?php foreach ($datas as $atributo) :?>
                            <?php
                            $nome_data = explode('-', $atributo['nome_data']);

                            $nome_data = array_reverse($nome_data);

                            $dia_data = $nome_data[0];

                            $nome_data = implode('/', $nome_data);

                            $dia = date('d');
                            ?>

                            <?php if ((int)$dia_data >= (int)$dia) : ?>
                                <option value="<?= $atributo['id_data'] ?>"><?= $nome_data ?></option>
                            <?php endif ?>

                        <?php endforeach ?>
                    </select>
                    <select  class="" name="horario_reserva" id="horario" style=" width: 325px;height: 50px;background-color:  #282626;border: none;border-radius: 10px;color: #fff;padding: 0.8rem; margin-left: 10px;" disabled>
                        <option value="0" selected>Seleciona algum Horário</option>
                    </select>
                </div>

                <div class="d-grid gap-2 col-6 mx-auto">
                    <button class="btn_btn-primary" type="submit" id="btn-reserva">
                        ENVIAR
                    </button>
                </div>
            </form>
        </div>
    </div>                                                                      
</section>



<!--------------------------------------- AJAX ---------------------------------->

<!-- Reservas -->
<script>
    document.getElementById("reserva").addEventListener("submit", function(e) {
        e.preventDefault(); //evita envio normal do form 

        const nome = document.getElementById("name").value;
        const telefone = document.getElementById("telefone").value;
        const email = document.getElementById("email").value;
        const servico = document.getElementById("inputGroupSelect01").options[document.getElementById("inputGroupSelect01").selectedIndex].text;
        const data = document.getElementById("data").options[document.getElementById("data").selectedIndex].text;
        const horario = document.getElementById("horario").options[document.getElementById("horario").selectedIndex].text;

        let mensagem = `Olá, meu nome é ${nome}. 
                Gostaria de fazer uma reserva para:
                - Serviço: ${servico}
                - Data: ${data}
                - Horário: ${horario}

                Meu telefone: ${telefone}
                E-mail: ${email}`;

        const numero = '5511958538834';

        const url = `https://api.whatsapp.com/send?phone=${numero}&text=${encodeURIComponent(mensagem)}`;
        window.open(url, "_blank");//abre a janela do wpp
    });

</script>


<script>
    document.getElementById('reserva').addEventListener('submit', function(event){
        event.preventDefault();

        const form = new FormData(event.target);

        fetch(`<?= URL_BASE?>reserva/adicionar_reserva`, {
            method: event.target.method,
            body: form
        })

        .then(response => response.json())
        .then(data => {
            if(data.error){
                alert(data.error);
                console.log(data);
            } else {
                alert(data.sucess);
            }
        })

        .catch(error => {
            console.error(error);
        })
    });
</script>


<!-- Horarios -->
<script>
    document.getElementById('data').addEventListener('change', function() {
        const horario = document.getElementById('horario');
        const id = this.value;

        fetch(`<?= URL_BASE ?>inicio/listar_horarios/${id}`)

            .then(response => response.text())
            .then(data => {
                horario.disabled = false;

                horario.innerHTML = data;
            })

            .catch(error => {
                alert(error);
            })
    })
</script>





<!-- //script do tratamento do telefone -->
<script>
    document.getElementById('telefone').addEventListener('input', function(e) {
        let x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,5})(\d{0,4})/);
        e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
    });
</script>