<?php
require('sec.php');
require('connect.php');
session_start();

// Verifica se um código foi enviado
if (!isset($_GET['cod']) || empty($_GET['cod'])) {
    $_SESSION['msg'] = "<p class='alerta error'>Código de usuário inválido!</p>";
    header("location: listar_usuarios.php");
    exit;
}

// Obtém e protege o código do usuário
$cod = intval($_GET['cod']);

// Verifica se o usuário existe antes de inativá-lo
$busca = mysqli_query($con, "SELECT * FROM `tb_usuarios` WHERE `cod_usuario` = $cod");

if (mysqli_num_rows($busca) > 0) {
    // Atualiza o status do usuário para inativo ('i')
    $inativar = mysqli_query($con, "UPDATE `tb_usuarios` SET `condicaoUsuario` = 'i' WHERE `cod_usuario` = $cod");

    if ($inativar) {
        $_SESSION['msg'] = "<p class='alerta success'>Usuário desativado com sucesso!</p>";
    } else {
        $_SESSION['msg'] = "<p class='alerta error'>Erro ao desativar usuário: " . mysqli_error($con) . "</p>";
    }
} else {
    $_SESSION['msg'] = "<p class='alerta error'>Usuário não encontrado!</p>";
}

header("location: listarUsuario.php");
exit;
?>
