<?php include('head.php'); ?>
<body>
    <?php include('menu.php'); ?>
    
    <div class="fundoLogin">
        <form action="login.act.php" method="post" enctype="multipart/form-data" id="formLogin">
            <h1>Entrar</h1>
            <p>
                <label for="email">Email:</label>
                <input type="text" name="email" id="email" placeholder="Digite seu email" required>
            </p>
            <p style="position: relative;">
                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" placeholder="Digite sua senha" required>
            </p>

            <p><input type="submit" value="Entrar"></p>
            <p><a href="cadastro.php">Crie sua conta</a></p> 
        </form>


        <div class="msgErroLogin">
            <?php
                @session_start();
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
            ?>
        </div>
    </div>

    

    <?php include('rodape.php'); ?>
</body>
</html>
