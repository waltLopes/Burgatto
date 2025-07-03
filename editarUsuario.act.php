<?php
require('connect.php');
@session_start();

// Redireciona se não for admin
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'admin') {
    $_SESSION['msg'] = "<p class='alerta error'>Acesso restrito para administradores!</p>";
    header("Location: login.php");
    exit;
}

// Verifica se recebeu o formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Valida campos obrigatórios
    if (!isset($_POST['cod_usuario']) || !isset($_POST['nome']) || !isset($_POST['email'])) {
        $_SESSION['msg'] = "<p class='alerta error'>Dados inválidos!</p>";
        header("Location: listarUsuario.php");
        exit;
    }

    // Prepara dados
    $cod = intval($_POST['cod_usuario']);
    $nome = mysqli_real_escape_string($con, trim($_POST['nome']));
    $email = mysqli_real_escape_string($con, trim($_POST['email']));

    // Atualiza o usuário
    $sql = "UPDATE tb_usuarios SET nome_usuario = ?, email_usuario = ? WHERE cod_usuario = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $nome, $email, $cod);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['msg'] = "<p class='alerta success'>Usuário atualizado com sucesso!</p>";
    } else {
        $_SESSION['msg'] = "<p class='alerta error'>Erro ao atualizar usuário.</p>";
    }

    header("Location: listarUsuario.php");
    exit;
} else {
    $_SESSION['msg'] = "<p class='alerta error'>Requisição inválida.</p>";
    header("Location: listarUsuario.php");
    exit;
}
?>
