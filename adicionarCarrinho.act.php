<?php
session_start();
require('connect.php');

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Buscar do banco de dados
    $sql = $con->prepare("SELECT descricao_produto, valor_produto, img_produto FROM tb_produtos WHERE cod_produto = ?");
    $sql->bind_param("i", $id);
    $sql->execute();
    $result = $sql->get_result();
    $produto = $result->fetch_assoc();
    

    if ($produto) {
        $nome = $produto['descricao_produto'];
        $preco = $produto['valor_produto'];
        $img = $produto['img_produto'];

        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        if (isset($_SESSION['carrinho'][$id])) {
            $_SESSION['carrinho'][$id]['quantidade'] += 1;
        } else {
            $_SESSION['carrinho'][$id] = [
                'nome' => $nome,
                'preco' => $preco,
                'quantidade' => 1,
                'img' => $img
            ];
        }
    }
}

$id = (int) $_POST['id'];

if (!isset($_SESSION['pedido'])) {
    $_SESSION['pedido'] = [];
}

if (isset($_SESSION['pedido'][$id])) {
    $_SESSION['pedido'][$id]++;
} else {
    $_SESSION['pedido'][$id] = 1;
}

$_SESSION['msg_pedido'] = "Adicionado em Meu Pedido"; //Mensagem adicionar Pedido -- LINO

echo "ok";
exit;






