<?php 
require('sec.php');
@session_start();
require('connect.php');

extract($_POST);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['msg'] = "<p class=\"alerta error\">Email inválido!</p>";
    header("location:addCliente.php");
    exit;
}

$nome = mysqli_real_escape_string($con, $nome);
$email = mysqli_real_escape_string($con, $email);

$busca = mysqli_query($con, "SELECT * FROM `tb_usuario` WHERE `email` = '$email'");
if ($busca->num_rows == 0) {
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $query = "INSERT INTO `tb_funcionarios` (`cod_fun`, `nome_fun`, `email_fun`, `senha_fun`) 
              VALUES (NULL, '$nome', '$email', '$senha_hash')";

    if (mysqli_query($con, $query)) {
        $_SESSION['msg'] = "<p class=\"alerta success\">Funcionário cadastrado com sucesso!</p>";
    } else {
        $_SESSION['msg'] = "<p class=\"alerta error\">Erro ao cadastrar funcionário: " . mysqli_error($con) . "</p>";
    }
} else {
    $_SESSION['msg'] = "<p class=\"alerta error\">Email já cadastrado!</p>";
}

header("location:listar.php");
exit;
?>
