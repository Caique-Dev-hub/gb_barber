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

<section class="geral-servico1" id="servico">
    <div class="site">
        <div class="lista-servico">
            <?php foreach ($servicos as $atributo) : ?>
                <div class="containe servicos" data-id="<?= isset($atributo['id_servico']) ? $atributo['id_servico'] : $atributo['id_combo'] + 3?>">
                    <div class="container1" style="background-image: url(<?= URL_BASE ?>assets/img/<?= $atributo['imagem_combo'] ?? $atributo['imagem_servico'] ?>);background-size: cover; background-position: center;">
                        <div class="container-content">
                            <h2><?= $atributo['nome_combo'] ?? $atributo['nome_servico'] ?></h2>
                            <P><?= $atributo['descricao_combo'] ?? $atributo['descricao_servico'] ?></P>
                            <h3><?= isset($atributo['valor_combo']) ? 'R$' . str_replace('.', ',', $atributo['valor_combo']) : 'R$'. str_replace('.', ',', $atributo['valor_servico'])?> <span style="text-decoration: line-through; font-size:1.5rem ;font-weight: 200;">R$<?= isset($atributo['valor_antigo']) ? str_replace('.', ',', $atributo['valor_antigo']) : 0.00 ?></span></h3>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>

    </div>


</section>


<!-- AJAX -->
<script>
    document.querySelectorAll('.servicos').forEach((servico) => {
        servico.addEventListener('click', function(){
            const id = this.dataset.id;

            document.getElementById('inputGroupSelect01').value = id;
            
            document.getElementById('contato').scrollIntoView({behavior: 'smooth'});
        })
    })
</script>

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