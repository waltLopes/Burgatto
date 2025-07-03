<?php
session_start();
require('connect.php');

if (!isset($_SESSION['pedido']) || empty($_SESSION['pedido'])) {
    echo "Pedido não encontrado.";
    exit;
}

$referencia = $_GET['payment_id'] ?? 'sem_ref';
$cod_usuario = $_SESSION['cod_usuario'] ?? null;
$total = 0;

// Calcula total
foreach ($_SESSION['pedido'] as $id => $qtd) {
    $q = mysqli_query($con, "SELECT valor_produto FROM tb_produtos WHERE cod_produto = $id");
    $row = mysqli_fetch_assoc($q);
    $total += $row['valor_produto'] * $qtd;
}

// Insere pedido
mysqli_query($con, "INSERT INTO tb_pedidos (cod_usuario, status_pagamento, valor_total, referencia_pagamento) VALUES ($cod_usuario, 'pago', $total, '$referencia')");
$cod_pedido = mysqli_insert_id($con);

// Insere itens do pedido
foreach ($_SESSION['pedido'] as $id => $qtd) {
    $q = mysqli_query($con, "SELECT valor_produto FROM tb_produtos WHERE cod_produto = $id");
    $row = mysqli_fetch_assoc($q);
    $valor = $row['valor_produto'];

    mysqli_query($con, "INSERT INTO tb_itens_pedido (cod_pedido, cod_produto, quantidade, valor_unitario) VALUES ($cod_pedido, $id, $qtd, $valor)");
}

// Limpa carrinho
unset($_SESSION['pedido']);
$_SESSION['msg'] = "<p class='alerta success'>Pagamento confirmado com sucesso!</p>";
header("Location: cardapio.php");
exit;
