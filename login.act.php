<?php
require('connect.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    $stmt = $con->prepare("SELECT * FROM `tb_usuarios` WHERE `email_usuario` = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();

        // Verifica se a senha digitada corresponde ao hash armazenado no banco
        if (password_verify($senha, $usuario['senha_usuario'])) {
            $_SESSION['logado'] = true;
            $_SESSION['cod_usuario'] = $usuario['cod_usuario'];
            $_SESSION['nome_usuario'] = $usuario['nome_usuario'];
            $_SESSION['email_usuario'] = $usuario['email_usuario'];
            $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];
            $_SESSION['cep_usuario'] = $usuario['cep_usuario'];

            $_SESSION['msg'] = "<div class='msg-flutuante'>Bem-vindo, " . $usuario['nome_usuario'] . "!</div>";
            header("location: cardapio.php");
            exit;
        }
    }

    $_SESSION['msg'] = "<p class='alerta error'>Email ou senha incorretos!</p>";
    header("location: login.php");
    exit;
}
?>
