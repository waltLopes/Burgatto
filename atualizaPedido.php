<?php
session_start();

if (isset($_POST['id'], $_POST['acao'])) {
    $id = (int)$_POST['id'];
    $acao = $_POST['acao'];

    
    if (!isset($_SESSION['pedido'])) {
        $_SESSION['pedido'] = [];
    }


    if (!isset($_SESSION['pedido'][$id])) {
        $_SESSION['pedido'][$id] = 0;
    }

    if ($acao === 'adicionar') {
        $_SESSION['pedido'][$id]++;
        echo json_encode(['success' => true, 'quantidade' => $_SESSION['pedido'][$id]]);
    } elseif ($acao === 'remover') {
        $_SESSION['pedido'][$id]--;
        if ($_SESSION['pedido'][$id] <= 0) {
            unset($_SESSION['pedido'][$id]);
            echo json_encode(['success' => true, 'quantidade' => 0]);
        } else {
            echo json_encode(['success' => true, 'quantidade' => $_SESSION['pedido'][$id]]);
        }
    } 
    // LINO: remover o item por completo
    elseif ($acao === 'remover_tudo') { 
        if (isset($_SESSION['pedido'][$id])) {
            unset($_SESSION['pedido'][$id]); // ← REMOVE o produto completamente
            echo json_encode(['success' => true, 'quantidade' => 0]);
        } else {
            echo json_encode(['success' => false, 'msg' => 'Produto não encontrado']);
        }
    } 
    // Caso a ação seja inválida
    else {
        echo json_encode(['success' => false, 'msg' => 'Ação inválida']); // ← ADICIONADO
    }
} else {
    echo json_encode(['success' => false, 'msg' => 'Parâmetros inválidos']); // ← ADICIONADO
}





// session_start();

// if (isset($_POST['id'], $_POST['acao'])) {
//     $id = (int)$_POST['id'];
//     $acao = $_POST['acao'];

//     if (!isset($_SESSION['pedido'][$id])) {
//         $_SESSION['pedido'][$id] = 0;
//     }

//     if ($acao === 'adicionar') {
//         $_SESSION['pedido'][$id]++;
//     } elseif ($acao === 'remover') {
//         $_SESSION['pedido'][$id]--;
//         if ($_SESSION['pedido'][$id] <= 0) {
//             unset($_SESSION['pedido'][$id]);
//         }
//     }

//     echo json_encode(['success' => true, 'quantidade' => $_SESSION['pedido'][$id] ?? 0]);
// }
