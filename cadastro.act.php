<?php 
@session_start();
require('connect.php');

extract($_POST);

// Validações
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['msg'] = "<p class='alerta error'>Email inválido!</p>";
    header("location:cadastro.php");
    exit;
}

if ($senha !== $confirmarSenha) {
    $_SESSION['msg'] = "<p class='alerta error'>As senhas não coincidem!</p>";
    header("location:cadastro.php");
    exit;
}

// Tratamento de dados para evitar SQL Injection
$nome = mysqli_real_escape_string($con, $nome);
$email = mysqli_real_escape_string($con, $email);
$cpf = mysqli_real_escape_string($con, $cpf);
$data_nasc = mysqli_real_escape_string($con, $data_nasc);
$telefone = mysqli_real_escape_string($con, $telefone);
$cep = mysqli_real_escape_string($con, $cep);
$endereco = mysqli_real_escape_string($con, $endereco);
$num_endereco = isset($_POST['num_endereco']) ? mysqli_real_escape_string($con, $_POST['num_endereco']) : '0';
$tipo_usuario = isset($_POST['tipo_usuario']) ? mysqli_real_escape_string($con, $_POST['tipo_usuario']) : '';

// Verifica se o email já está cadastrado
$busca = mysqli_query($con, "SELECT * FROM `tb_usuarios` WHERE `email_usuario` = '$email'");
if ($busca->num_rows == 0) {
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Corrigida a query com os nomes corretos das colunas
    $query = "INSERT INTO `tb_usuarios` (`cod_usuario`, `nome_usuario`, `cpf_usuario`, `data_nasc_usuario`, `email_usuario`, `senha_usuario`, `telefone_usuario`, `cep_usuario`, `endereco_usuario`, `numero_endereco_usuario`) 
              VALUES (NULL, '$nome', '$cpf', '$data_nasc', '$email', '$senha_hash', '$telefone', '$cep', '$endereco', '$num_endereco')";

    if (mysqli_query($con, $query)) {
        $_SESSION['msg'] = "<p class='alerta success'>Cadastro concluído com sucesso!</p>";
        header("location:login.php");
        exit;
    } else {
        $_SESSION['msg'] = "<p class='alerta error'>Erro ao cadastrar: " . mysqli_error($con) . "</p>";
    }
} else {
    $_SESSION['msg'] = "<p class='alerta error'>Email já cadastrado!</p>";
}

header("location:cadastro.php");
exit;
?>
