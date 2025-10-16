<section id="home" class="banner-home">
    <div class="banner-content">
        <h1 class="banner-title">Experiência Excepcional<br>com Estilo</h1>
        <div class="banner-line"></div>
        <p class="banner-subtitle">Descubra o melhor serviço de barbearia na <strong>GB BARBEARIA</strong></p>
        <a target="_blank"  data-destiny="contato" class="banner-btn">Reserve Agora</a>
    </div>
</section>

<a href="https://wa.me/11958538834" class="whatsapp-float" target="_blank">
    <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp">
</a>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.banner-btn').forEach((header) => {
            header.addEventListener('click', function() {
                let destino = this.dataset.destiny;

                document.getElementById(`${destino}`).scrollIntoView({
                    behavior: "smooth"
                });
            })
        })
    })
</script>