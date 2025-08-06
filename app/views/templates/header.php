<header>
    <div class="site">

        <div class="menu" id="main-header">

            <div class="conteudo-menu-1 ">
                <a href="#">GB-BARBEARIA</a>
            </div>
            <div class="conteudo-menu-2">
                <ul>
                    <li ><a class="session-menu" href="#home">HOME</a></li>
                    <li ><a class="session-menu" href="#servico">SERVIÇO</a></li>
                    <li ><a class="session-menu" href="#sobre">SOBRE</a></li>
                    <li ><a class="session-menu" href="#contato">RESERVA</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function(){//O que faz: Espera o HTML da página carregar completamente antes de executar o JavaScript.
        const header = document.getElementById('main-header');//O que faz: Seleciona o elemento HTML com id "main-header" e armazena na variável header.
        const scrollThreshold = 100;//O que faz: Define a quantidade de rolagem (em pixels) necessária para ativar a mudança.

        window.addEventListener('scroll', function(){//O que faz: Fica "escutando" o evento de rolagem da página.
            if(window.scrollY > scrollThreshold){//O que faz: Verifica se a rolagem passou do limite definido.
                header.classList.add('scrolled');// Adiciona classe que muda o estilo
            }else{
                header.classList.remove('scrolled');// Remove a classe se voltou ao topo
            }
        })
    })
</script>