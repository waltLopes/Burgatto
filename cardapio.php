<?php
include('head.php');
include('connect.php'); 

function listarProdutosPorCategoria($con, $categoria) {
    $sql = "SELECT * FROM tb_produtos WHERE status_produto = 'ativo' AND categoria_produto = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $categoria);
    $stmt->execute();
    return $stmt->get_result();
}

?>

<body>
    <?php include('menu.php'); ?>

    <?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    ?>


    <div class="fundoCardapio">
        <div class="tituloCardapio"><p>Cardápio</p></div>

        <div class="menuCardapio">
            <button class="active" data-target="burgers">Burgers</button>
            <button data-target="acompanhamentos">Acompanhamentos</button>
            <button data-target="sobremesas">Sobremesas</button>
            <button data-target="bebidas">Bebidas</button>
        </div>
    
        <!--ADICIONAR A MENSAGEM NO CARDAPIO AO CLICAR EM ADD O PRODUTO - LINO -->

        <div class="cardapioContent">
            <div class="fundoCardapio2">

            <input type="text" id="barraPesquisa" placeholder="Pesquisar">

            <!-- B U R G E R S -->
            <div class="categoria active" id="burgers">
                <?php $result = listarProdutosPorCategoria($con, 'burgers'); ?>
                <?php while ($produto = $result->fetch_assoc()): ?>
                    <div class="burger">
                        <img src="<?= $produto['img_produto'] ?>" alt="<?= $produto['descricao_produto'] ?>">
                        <div class="desc">
                            <p><?= $produto['descricao_produto'] ?></p>
                            <h1><?= $produto['ingredientes_produto'] ?></h1>
                            <p>R$<?= number_format($produto['valor_produto'], 2, ',', '.') ?></p>
                            <form method="post" action="adicionarCarrinho.act.php">
                                <input type="hidden" name="id" value="<?= $produto['cod_produto'] ?>">
                                <input type="hidden" name="categoria" value="<?= $produto['categoria_produto'] ?>">
                                <button class="btnAdicionar" data-id="<?= $produto['cod_produto'] ?>" data-categoria="<?= $produto['categoria_produto'] ?>">
                                    Adicionar ao Pedido
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <!-- A C O M P A N H A M E N T O S -->
            <div class="categoria" id="acompanhamentos">
                <?php $result = listarProdutosPorCategoria($con, 'acompanhamentos'); ?>
                <?php while ($produto = $result->fetch_assoc()): ?>
                    <div class="burger">
                        <img src="<?= $produto['img_produto'] ?>" alt="<?= $produto['descricao_produto'] ?>">
                        <div class="desc">
                            <p><?= $produto['descricao_produto'] ?></p>
                            <h1><?= $produto['ingredientes_produto'] ?></h1>
                            <p>R$<?= number_format($produto['valor_produto'], 2, ',', '.') ?></p>
                            <form method="post" action="adicionarCarrinho.act.php">
                                <input type="hidden" name="id" value="<?= $produto['cod_produto'] ?>">
                                <input type="hidden" name="categoria" value="<?= $produto['categoria_produto'] ?>">
                                <button class="btnAdicionar" data-id="<?= $produto['cod_produto'] ?>" data-categoria="<?= $produto['categoria_produto'] ?>">
                                    Adicionar ao Pedido
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <!-- S O B R E M E S A S -->
            <div class="categoria" id="sobremesas">
                <?php $result = listarProdutosPorCategoria($con, 'sobremesas'); ?>
                <?php while ($produto = $result->fetch_assoc()): ?>
                    <div class="burger">
                        <img src="<?= $produto['img_produto'] ?>" alt="<?= $produto['descricao_produto'] ?>">
                        <div class="desc">
                            <p><?= $produto['descricao_produto'] ?></p>
                            <h1><?= $produto['ingredientes_produto'] ?></h1>
                            <p>R$<?= number_format($produto['valor_produto'], 2, ',', '.') ?></p>
                            <form method="post" action="adicionarCarrinho.act.php">
                                <input type="hidden" name="id" value="<?= $produto['cod_produto'] ?>">
                                <input type="hidden" name="categoria" value="<?= $produto['categoria_produto'] ?>">
                                <button class="btnAdicionar" data-id="<?= $produto['cod_produto'] ?>" data-categoria="<?= $produto['categoria_produto'] ?>">
                                    Adicionar ao Pedido
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <!-- B E B I D A S -->
            <div class="categoria" id="bebidas">
                <?php $result = listarProdutosPorCategoria($con, 'bebidas'); ?>
                <?php while ($produto = $result->fetch_assoc()): ?>
                    <div class="burger">
                        <img src="<?= $produto['img_produto'] ?>" alt="<?= $produto['descricao_produto'] ?>">
                        <div class="desc">
                            <p><?= $produto['descricao_produto'] ?></p>
                            <h1><?= $produto['ingredientes_produto'] ?></h1>
                            <p>R$<?= number_format($produto['valor_produto'], 2, ',', '.') ?></p>
                            <form method="post" action="adicionarCarrinho.act.php">
                                <input type="hidden" name="id" value="<?= $produto['cod_produto'] ?>">
                                <input type="hidden" name="categoria" value="<?= $produto['categoria_produto'] ?>">
                                <button class="btnAdicionar" data-id="<?= $produto['cod_produto'] ?>" data-categoria="<?= $produto['categoria_produto'] ?>">
                                    Adicionar ao Pedido
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
        </div>

    </div>

    <?php include('rodape.php'); ?>
</body>