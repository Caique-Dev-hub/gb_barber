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
            <?php foreach ($servicos as $coluna) : ?>
                <div class="containe servicos" data-id="<?= isset($coluna['id_servico']) ? $coluna ['id_servico'] : $coluna ['id_combo'] + 3?>">
                    <div class="container1" style="background-image: url(<?= URL_BASE ?>assets/img/<?= isset($coluna['imagem_servico']) ? $coluna['imagem_servico'] : $coluna['imagem_combo'] ?>);background-size: cover; background-position: center;">
                        <div class="container-content">
                            <h2><?= isset($coluna['nome_servico']) ? $coluna ['nome_servico'] : $coluna ['nome_combo'] ?></h2>
                            <P><?= isset($coluna['descricao_servico']) ? $coluna ['descricao_servico'] : $coluna ['descricao_combo'] ?></P>
                            <h3><?= isset($coluna['valor_servico']) ? 'R$' . str_replace('.',',',$coluna['valor_servico']) : 'R$' . str_replace('.' , ',',$coluna['valor_combo']) ?></h3>
                        </div>
                    </div>
                </div>

            <?php endforeach ?>
        </div>
    </div>


</section>


<!-- AJAX -->
<script>
    document.querySelectorAll('.servicos').forEach((servico) => {//to pegando todos os servicos e armazenando na var servico
        servico.addEventListener('click', function() {//se hover click em alguma div da servico 
            const id = this.dataset.id;//guardando id

            document.getElementById('inputGroupSelect01').value = id;//pegando o valor id da div que foi clicada

            document.getElementById('contato').scrollIntoView({//descer para contato e trazer o que tem especificado no id
                behavior: 'smooth'
            });
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