<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require('connect.php');

// Cria o array de pedido se não existir
if (!isset($_SESSION['pedido'])) {
    $_SESSION['pedido'] = [];
}

// Carrega produto do banco de dados
function getProduto($id) {
    global $con;

    $id = (int)$id;
    $sql = "SELECT * FROM tb_produtos WHERE cod_produto = $id AND status_produto = 'ativo'";
    $result = mysqli_query($con, $sql);

    if ($produto = mysqli_fetch_assoc($result)) {
        return [
            'nome' => $produto['descricao_produto'],
            'preco' => $produto['valor_produto'],
            'img' => $produto['img_produto']
        ];
    }

    return null;
}


// Remove produto
function removerProduto($id) {
    unset($_SESSION['pedido'][$id]);
}

// Altera quantidade
function alterarQuantidade($id, $qtd) {
    if ($qtd <= 0) {
        removerProduto($id);
    } else {
        $_SESSION['pedido'][$id] = $qtd;
    }
}

// Retorna os itens do pedido com detalhes
function getPedidoCompleto() {
    $pedido = [];
    foreach ($_SESSION['pedido'] as $id => $qtd) {
        $produto = getProduto($id);
        if ($produto) {
            $produto['quantidade'] = $qtd;
            $produto['total'] = $produto['preco'] * $qtd;
            $pedido[$id] = $produto;
        }
    }
    return $pedido;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cep'])) {
    $cep = preg_replace('/\D/', '', $_POST['cep']);
    $cepPrefixo = substr($cep, 0, 5); // Ex: 03058-000 → "03058"

    $frete = 0;

    if ($cepPrefixo >= '01000' && $cepPrefixo <= '01599') {
        $frete = 15.00; // Centro
    } elseif (
        ($cepPrefixo >= '03000' && $cepPrefixo <= '03999') ||
        ($cepPrefixo >= '08000' && $cepPrefixo <= '08499')
    ) {
        $frete = 23.00; // Zona Leste
    }
    

    echo json_encode(['frete' => $frete]);
    exit;
}


?>