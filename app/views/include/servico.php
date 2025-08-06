<section class="geral-servico" id="servico">
    <div class="carrossel-container">
        <div class="carrossel">
            <div class="tt-servico">
                <h2 class="white">Serviços Disponíveis</h2>
            </div>
            <div class="tt-servico">
                <h2 class="red">Serviços Disponíveis</h2>
            </div>
            <div class="tt-servico">
                <h2 class="white">Serviços Disponíveis</h2>
            </div>
            <div class="tt-servico">
                <h2 class="red">Serviços Disponíveis</h2>
            </div>
            <div class="tt-servico">
                <h2 class="white">Serviços Disponíveis</h2>
            </div>
            <div class="tt-servico">
                <h2 class="red">Serviços Disponíveis</h2>
            </div>
        </div>
    </div>
</section>

<section class="geral-servico1">
    <div class="site">
        <a href="#" id="servico"></a>
        <div class="lista-servico">

            <?php foreach ($servicos as $atributo) : ?>
                <div class="containe servicos">
                    <div class="container1" style="background-image: url(<?= URL_BASE ?>assets/img/<?= $atributo['imagem_servico'] ?>);background-size: cover; background-position: center;"
                        data-bs-toggle="modal" data-bs-target="#exampleModal<?= $atributo['id_servico'] ?>">
                        <div class="container-content">
                            <h2><?php echo $atributo['nome_servico'] ?></h2>
                            <P><?php echo $atributo['descricao_servico'] ?></P>
                            <h3><?php echo 'R$' . str_replace('.', ',', $atributo['valor_servico']) ?> <span style="text-decoration: line-through; font-size:1.5rem ;font-weight: 200;">R$<?= str_replace('.', ',', $atributo['valor_antigo']) ?></span></h3>
                        </div>
                    </div>
                </div>

            <?php endforeach ?>


        </div>

    </div>


</section>



</section>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const carrossel = document.querySelector('.carrossel');
        const items = document.querySelectorAll('.tt-servico');


        items.forEach(item => {
            carrossel.appendChild(item.cloneNode(true));
        });

        let position = 0;
        const speed = 2; // Velocidade do carrossel

        function animate() {
            position -= speed;

            // Quando chegar no final, resetamos para criar o loop infinito
            if (position <= -carrossel.scrollWidth / 2) {
                position = 0;
            }

            carrossel.style.transform = `translateX(${position}px)`;
            requestAnimationFrame(animate);
        }

        animate();
    });
</script>