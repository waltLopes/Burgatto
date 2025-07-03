<?php
require('connect.php');
session_start();

$forma = $_POST['forma_pagamento'] ?? '';
$troco = $_POST['troco'] ?? '';
$bandeira = $_POST['bandeira'] ?? '';
$pedido = $_SESSION['pedido'] ?? [];
$cod_usuario = $_SESSION['cod_usuario'] ?? null;

// Validações
if (empty($forma) || empty($pedido) || !$cod_usuario) {
    $_SESSION['msg'] = "<div class='msg-flutuante'>Erro ao processar o pedido!</div>";
    header("Location: meuPedido.php");
    exit;
}

// Se for cartão, exige a bandeira
if ($forma === 'cartao' && empty($bandeira)) {
    $_SESSION['msg'] = "<div class='msg-flutuante'>Selecione a bandeira do cartão!</div>";
    header("Location: meuPedido.php");
    exit;
}

// Se for PIX, apenas responde "pix" e o resto será tratado no confirmarPagamentoPix()
if ($forma === 'pix') {
    $_SESSION['forma_pagamento'] = 'pix';
    $_SESSION['troco'] = '';
    $_SESSION['bandeira'] = '';
    echo "pix";
    exit;
}

// Processar pagamento simulado (cartão ou dinheiro)
$total = 0;
foreach ($pedido as $id => $qtd) {
    $q = mysqli_query($con, "SELECT valor_produto FROM tb_produtos WHERE cod_produto = $id");
    $row = mysqli_fetch_assoc($q);
    $total += $row['valor_produto'] * $qtd;
}

$referencia = $forma . '_' . time();
mysqli_query($con, "INSERT INTO tb_pedidos (cod_usuario, status_pagamento, valor_total, referencia_pagamento, forma_pagamento)
    VALUES ($cod_usuario, 'pago', $total, '$referencia', '$forma')");

$cod_pedido = mysqli_insert_id($con);

foreach ($pedido as $id => $qtd) {
    $q = mysqli_query($con, "SELECT valor_produto FROM tb_produtos WHERE cod_produto = $id");
    $row = mysqli_fetch_assoc($q);
    $valor = $row['valor_produto'];
    mysqli_query($con, "INSERT INTO tb_itens_pedido (cod_pedido, cod_produto, quantidade, valor_unitario)
        VALUES ($cod_pedido, $id, $qtd, $valor)");
}

// Limpa carrinho
unset($_SESSION['pedido']);

$_SESSION['msg'] = "<div class='msg-flutuante'>Pedido realizado com sucesso! Forma de pagamento: " . ucfirst($forma) . "</div>";
header("Location: index.php");
exit;
