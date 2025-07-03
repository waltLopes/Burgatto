<?php 
include('head.php'); 
require('sec.php'); 
require('connect.php'); 
@session_start();

// Verifica se o código do usuário foi passado
if (!isset($_GET['cod']) || empty($_GET['cod'])) {
    $_SESSION['msg'] = "<p class='alerta error'>Código de usuário inválido!</p>";
    header("location: listarUsuario.php");
    exit;
}

$cod = intval($_GET['cod']);

// Busca os dados do usuário no banco
$busca = mysqli_query($con, "SELECT * FROM `tb_usuarios` WHERE `cod_usuario` = $cod");
$usuario = mysqli_fetch_assoc($busca);

// Se o usuário não for encontrado, redireciona
if (!$usuario) {
    $_SESSION['msg'] = "<p class='alerta error'>Usuário não encontrado!</p>";
    header("location: listarUsuario.php");
    exit;
}
?>

<body>
    <?php include('menu.php'); ?>

    <div class="fundoCadastro">
        <form class="formUsuario" action="editarUsuario.act.php" method="post" enctype="multipart/form-data" id="formCadastro">
            <h1>Editar Usuário</h1>

            <input type="hidden" name="cod_usuario" value="<?php echo $usuario['cod_usuario']; ?>">

            <p>
                <label for="nome">Nome:</label> 
                <input type="text" name="nome" value="<?php echo htmlspecialchars($usuario['nome_usuario']); ?>" required>
            </p>

            <p>
                <label for="email">E-mail:</label>
                <input type="text" name="email" value="<?php echo htmlspecialchars($usuario['email_usuario']); ?>" required>
            </p>      

            <div class="grupoCampos">
                <p>
                    <label for="cpf">CPF:</label>
                    <input type="text" name="cpf" id="cpf" value="<?php echo htmlspecialchars($usuario['cpf_usuario']); ?>" required>
                </p>
                <p>
                    <label for="data_nascimento">Data de nascimento:</label>
                    <input type="date" name="data_nasc" value="<?php echo $usuario['data_nasc_usuario']; ?>" required>
                </p>
            </div>

            <div class="grupoCampos">
                <p>
                    <label for="telefone">Telefone:</label> 
                    <input type="text" name="telefone" id="telefone" value="<?php echo htmlspecialchars($usuario['telefone_usuario']); ?>" required>
                </p>
                <p>
                    <label for="cep">CEP:</label>
                    <input type="text" name="cep" id="cep" value="<?php echo htmlspecialchars($usuario['cep_usuario']); ?>" required maxlength="9" onblur="buscarEndereco()">
                </p>
            </div>

            <div class="grupoCampos2">
                <p>
                    <label for="endereco">Endereço:</label>
                    <input type="text" name="endereco" id="endereco" value="<?php echo htmlspecialchars($usuario['endereco_usuario']); ?>" required readonly>
                </p>
                <p>
                    <label for="numero">Número:</label>
                    <input type="text" name="num_endereco" id="num_endereco" value="<?php echo htmlspecialchars($usuario['numero_endereco_usuario']); ?>" required>
                </p>
            </div>
            
            <p>
                <label for="senha">Nova Senha (opcional):</label> 
                <input type="password" name="senha" placeholder="Digite uma nova senha">
            </p>
            <p>
                <label for="confirmarSenha">Confirmar Nova Senha:</label> 
                <input type="password" name="confirmarSenha" placeholder="Confirme a nova senha">
            </p>

            <p><input type="submit" value="Salvar"></p>
        </form>

        <div class="msgErroLogin">
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
        </div>
    </div>
</body>
</html>
