<?php
session_start();
include('head.php');
?>

<?php include('head.php'); ?>
<body>
    <?php include('menu.php'); ?>

    <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
    ?>

    <img class="fundo" src="imgs/fundo2.jpg" alt="">

    <div class="textoSobreImagem">
        O verdadeiro hambúrguer<br>Artesanal
    </div>


    <div class="nossaHistoria">
        <img src="imgs/logoAlternativa2.png" alt="">

        <div class="nossaHistoria2">
            <div class="tituloHistoria">
                <p>Nossa História</p>
            </div>

            <div class="textoHistoria">
                <p>
                    A BURGATTO nasceu da amizade entre Lorenzo Bianchi e Enzo Moretti, dois apaixonados pela culinária 
                    italiana e pelo sabor do verdadeiro hambúrguer artesanal. Juntos, uniram tradição e criatividade para criar uma 
                    hamburgueria com personalidade única, onde cada receita carrega autenticidade e excelência.
                </p>
            </div>

        </div>

    </div>


    <div class="pecaAgora2">
        <div class="pecaAgoraTitulo">
            <a href="cardapio.php">Peça Agora</a>    
        </div>

        <div class="listaPrevia">
            <div class="hamburguer"><img src="imgs/burger8.jpg" alt=""><p>BURGERS ARTESANAIS</p></div>
            <div class="hamburguer"><img src="imgs/batata2.jpg" alt=""><p>OS MELHOR ACOMPANHAMENTOS</p></div>
            <div class="hamburguer"><img src="imgs/sobremesaBrownie.jpg" alt=""><p>SOBREMESAS DELICIOSAS</p></div>
            <div class="hamburguer"><img src="imgs/heineken.jpg" alt=""><p>SUA BEBIDA FAVORITA</p></div>
        </div>
        
        <a class="verCardapio" href="cardapio.php"><button>VER CARDÁPIO COMPLETO →</button></a>
    </div>

    

    <?php include('rodape.php'); ?>

</body>