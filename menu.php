<body>
<?php @session_start(); ?>

    <div class="menu">
        <ul>
            <a href="index.php">Home</a>
            <a href="cardapio.php">Cardápio</a>
            <img class="logo" src="imgs/logo2.png" alt="" onclick="window.location.href='index.php'">
            <a href="meuPedido.php">Meu Pedido</a>
            <?php if (isset($_SESSION['email_usuario'])): ?>
            <a href="logoff.php">Sair</a>
            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
        </ul>
    </div>
    
    <div class="menu2">
        <div class="menu-toggle" onclick="toggleMenu()">
            <div></div>
            <div></div>
            <div></div>
        </div>

        <div class="logoMenu2">
            <p>BURGATTO</p>
        </div>

        <div class=""></div>
    </div>

    <div class="mobile-menu">
        <a href="index.php">Home</a>
        <a href="cardapio.php">Cardápio</a>
        <a href="pedido.php">Meu Pedido</a>
        <?php if (isset($_SESSION['email_usuario'])): ?>
            <a href="logoff.php">Sair</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </div>

    <script src="app.js"></script>
</body>


