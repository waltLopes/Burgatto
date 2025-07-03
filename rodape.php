<footer>
  <div class="rodape">
    <div class="conteiner">
      <ul class="links">
        <li><a href="index.php">HOME</a></li>
        <li><a href="cardapio.php">CARDÁPIO</a></li>
        <li><a href="#">NOSSA HISTÓRIA</a></li>
        <li><a href="#">CONTATE-NOS</a></li>
        <?php
            if (
                isset($_SESSION['logado']) &&
                $_SESSION['logado'] === true &&
                isset($_SESSION['tipo_usuario']) &&
                $_SESSION['tipo_usuario'] === 'admin'
            ):
        ?>
            <li><a href="listarUsuario.php">Usuários</a></li>
        <?php endif; ?>
        <?php if (isset($_SESSION['email_usuario'])): ?>
            <li><a href="logoff.php">Sair</a></li>
        <?php else: ?>
            <li><a href="login.php">Login</a></li>
        <?php endif; ?>

      </ul>

      <div class="logo2">
        <img src="imgs/logoAlternativa2.png" alt="Logo">
      </div>

      <div class="social">
        <img src="imgs/whatsapp.png" alt="WhatsApp">
        <img src="imgs/instagram-new.png" alt="Instagram" onclick="window('https://www.instagram.com/burgatto.burger/')">
        <img src="imgs/images.png" alt="LinkedIn">
        <img src="imgs/facebook-new.png" alt="Facebook">
      </div>
    </div>
    <div class="direitos">
      © 2025 BURGATTO
    </div>
</div>
<script src="app.js" defer></script>
</footer>
</html>
