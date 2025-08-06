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
            <form action="" method="post" class="form-contato">
                <div style="margin: 0 auto; ">
                    <h3>FALE CONOSCO</h3>
                </div>

                <div class="container-menu">
                    <div class="input-name">
                        <label for="_name" style="width: 50px;color: white;">Nome:</label>
                        <input type="text" placeholder="Nome completo" id="_name">
                    </div>
                    <div class="input-name">
                        <label for="_tel" style="width: 50px;color: white;">Telefone:</label>
                        <input type="text" id="_tel" placeholder="(11) 99999-9999" maxlength="15">
                    </div>
                </div>
                <div class="container-menu">
                    <div class="input-name">
                        <label style="width: 50px;color: white;" for="">E-mail</label>
                        <input style="WIDTH:660px;" type="text" placeholder="@example.com">
                    </div>
                </div>
                <div class="container-form">
                    <div class="container-menu" style="display: flex;flex-direction: column; ">
                        <label class="" style="margin-left: 10px;width: 50px;color: white;" for="inputGroupSelect01">Serviços</label>
                        <select class="" id="inputGroupSelect01" style="width: 320px;height: 50px;background-color: #282626;border: none;border-radius: 10px;color: #fff;padding: 0.8rem; margin-left: 10px;">
                            <option selected></option>
                            <option value="1">Corte Social R$35,00</option>
                            <option value="2">Barba R$25,00</option>
                            <option value="3">Sobrancelha R$15,00</option>
                        </select>
                    </div>
                    <div class="container-menu" style="display: flex;flex-direction: column; ">
                        <label class="" style="margin-left: 10px;width: 50px;color: white;" for="inputGroupSelect01">Horários</label>
                        <select class="" id="inputGroupSelect01" style="width: 320px;height: 50px;background-color: #282626;border: none;border-radius: 10px;color: #fff;padding: 0.8rem; margin-left: 10px;">
                            <option selected></option>
                            <option value="1">PM 14:00</option>
                            <option value="2">PM 15:00</option>
                            <option value="3">PM 16:00</option>
                        </select>
                    </div>
                </div>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <button class="btn btn-primary" id="btn-reserva" style="background: linear-gradient(135deg, #BE4949 0%,rgb(93, 29, 29) 100%); background-color: #BE4949;border:none; margin-top: 40px;font-size: 1.3rem;" type="button"><a style="text-decoration:none; color:#fff;" href="">Reserva</a></button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
document.getElementById('_tel').addEventListener('input', function(e) {
    let x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,5})(\d{0,4})/);
    e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
});
</script>