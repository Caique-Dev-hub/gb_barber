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
        </div>
    </div>
</section>


<section class="geral-servico1" id="servico">
    <div class="site">
        <div class="lista-servico multiple-items">
            <?php foreach ($servicos as $coluna) : ?>
                <div class="containe servicos" data-id="<?= isset($coluna['id_servico']) ? $coluna['id_servico'] : $coluna['id_combo'] + 3 ?>">
                    <div class="container1" style="background-image: url(<?= URL_BASE ?>upload/<?= $coluna['imagem_combo'] ?? $coluna['imagem_servico'] ?>);background-size: cover; background-position: center;">
                        <div class="container-content">
                            <div style="display: flex;">
                                <h2><?= isset($coluna['nome_servico']) ? $coluna['nome_servico'] : $coluna['nome_combo'] ?></h2>
                                <P style="   margin-top: 10px; margin-left: 30px;
    /* margin-bottom: 60px; */
    border-radius: 5px;
    font-size: 17px;
    height: 28px;"><?= ($coluna['tempo_estimado']) ?></P>
                            </div>
                            <P><?= isset($coluna['descricao_servico']) ? $coluna['descricao_servico'] : $coluna['descricao_combo'] ?></P>
                            <h3><?= isset($coluna['valor_servico']) ? 'R$' . str_replace('.', ',', $coluna['valor_servico']) : 'R$' . str_replace('.', ',', $coluna['valor_combo']) ?></h3>
                        </div>
                    </div>
                </div>

            <?php endforeach ?>
        </div>
    </div>
</section>
<script>
    $('.multiple-items').slick({
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 4,
        arrows: true,
        prevArrow: `
        <button class="custom-arrow custom-prev">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="square" stroke-linejoin="bevel">
                <path d="M16 4 L8 12 L16 20" />
            </svg>
        </button>
    `,
        nextArrow: `
        <button class="custom-arrow custom-next">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="square" stroke-linejoin="bevel">
                <path d="M8 4 L16 12 L8 20" />
            </svg>
        </button>
    `,
    });
</script>
<!-- AJAX -->
<script>
    document.querySelectorAll('.servicos').forEach((servico) => { //to pegando todos os servicos e armazenando na var servico
        servico.addEventListener('click', function() { //se hover click em alguma div da servico 
            const id = this.dataset.id; //guardando id

            document.getElementById('inputGroupSelect01').value = id; //pegando o valor id da div que foi clicada

            document.getElementById('contato').scrollIntoView({ //descer para contato e trazer o que tem especificado no id
                behavior: 'smooth'
            });
        });
    });
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

<style>
    /* === SETAS PADRÃO DO SLICK === */
    .slick-prev,
    .slick-next {
        width: 45px;
        height: 45px;
        background-color: rgba(255, 255, 255, 0.8);
        border-radius: 50%;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    /* Ícones das setas (usando pseudo-elementos) */
    .slick-prev::before,
    .slick-next::before {
        font-family: 'slick';
        font-size: 24px;
        color: #fff;
        opacity: 1;
    }

    /* Hover bonito */
    .slick-prev:hover,
    .slick-next:hover {
        background-color: rgba(255, 255, 255, 0.8);
        transform: translateY(-50%) scale(1.1);
    }

    /* Posição das setas */
    .slick-prev {
        left: -55px;
        /* Ajuste se quiser mais longe ou mais perto */
    }

    .slick-next {
        right: -55px;
        left: 1570px;
    }

    /* Responsivo - esconder ou aproximar setas no mobile */
    @media (max-width: 768px) {

        .slick-prev,
        .slick-next {
            width: 35px;
            height: 35px;
        }

        .slick-prev {
            left: -40px;
        }

        .slick-next {
            right: -40px;
        }
    }

    .slick-slide {
        /* Espaço lateral entre slides */
        box-sizing: border-box;
    }

    .slick-slide {
        height: 350px;
        margin-top: 35px;
        margin-left: 26px;
    }

    .slick-track {
        display: flex !important;
        align-items: stretch;
    }

    .listar-servico {
        width: 1730px;
    }

    .slick-prev,
    .slick-next {
        font-size: 0;
        /* Esconde texto */
        color: transparent;
        /* Garante que nada apareça */
    }

    .slick-prev::before,
    .slick-next::before {
        font-size: 24px;
        /* Reexibe o ícone normal */
        color: #fff;
        /* Define a cor da seta */
    }

    /* estilo das setas */
    .custom-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 50px;
        height: 50px;
        background: transparent;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 10;
    }

    .custom-prev {
        left: -5px;
    }

    .custom-next {
        right: 10px;
    }

    .custom-arrow svg {
        width: 20px;
        height: 20px;
        fill: #fff;
    }

    /* opcional: hover */
    .custom-arrow:hover {
        background: rgba(0, 0, 0, 0.8);
    }
</style>