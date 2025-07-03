<?php
session_start();
include('head.php');
include('meuPedido.act.php');

$num_endereco = $_POST['num_endereco'] ?? '';
$pedido = getPedidoCompleto();
$usuarioLogado = isset($_SESSION['cod_usuario']) && !empty($_SESSION['cod_usuario']);
$cepUsuario = isset($_SESSION['cep_usuario']) ? $_SESSION['cep_usuario'] : '';

?>
<?php include('menu.php'); ?>

<?php
if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}
?>

<div class="fundoMeuPedido">
<main class="sacola-container">

    <h1>Sacola</h1>

    <?php if (empty($pedido)): ?>
        <div class="sacola-vazia">
            <p>Seu pedido está vazio.</p>
            <a href="cardapio.php" class="btn-ver-cardapio">Ir para o cardápio</a>
        </div>
    <?php else: ?>

        <div class="conteudo-sacola">
        <table class="tabela-sacola">
            <thead>
                <th class="prod">Produto</th>
                <th>Preço</th>
                <th>Quantidade</th>
                <th class="tot">Total</th>
            </thead>
            <tbody>
                <?php
                $subtotal = 0;
                foreach ($pedido as $id => $item):
                    $subtotal += $item['total'];
                ?>
                    <tr>
                        <td class="produto-info">
                            <img src="<?= $item['img'] ?>" alt="<?= $item['nome'] ?>">
                            <span><?= $item['nome'] ?></span>
                        </td>
                        <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                        <td>
                            <input type="hidden" class="produto-id" value="<?= $id ?>">
                            <button type="button" class="menos">-</button>
                            <span class="quantidade"><?= $item['quantidade'] ?></span>
                            <button type="button" class="mais">+</button>
                            <button type="button" class="remover">❌</button>
                        </td>
                        <td>R$ <?= number_format($item['total'], 2, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="resumo-container">
        <div class="resumo-compra">
            <h3>Resumo da compra</h3>
            <p>Sub-total: R$ <?= number_format($subtotal, 2, ',', '.') ?></p>
            <input type="text" name="cep" id="cep" placeholder="Digite seu CEP" required maxlength="9" onblur="buscarEndereco(); calcularFrete();" value="<?= htmlspecialchars($cepUsuario) ?>" required>
            <input type="text" name="endereco" id="endereco" placeholder="Digite seu endereço" readonly>
            <input type="text" name="num_endereco" id="num_endereco" placeholder="Nº" required>
            <p><a href="https://buscacepinter.correios.com.br/app/endereco/index.php?t" target="_blank">Não lembro meu CEP</a></p>
            <p id="valor-frete">Frete: R$ 0,00</p>
            <hr>
            <p id="valor-total">Total: R$ <?= number_format($subtotal, 2, ',', '.') ?></p>
        </div>

        <form id="formPagamento" action="<?= $usuarioLogado ? 'pagamento.php' : '#' ?>" method="post" class="form-pagamento" <?= $usuarioLogado ? '' : 'onsubmit="return false;"' ?>>
            <h3>Escolha a forma de pagamento:</h3>
            <label><input type="radio" name="forma_pagamento" value="pix" required> PIX</label><br>
            <label><input type="radio" name="forma_pagamento" value="cartao"> Cartão na entrega</label><br>
            <label><input type="radio" name="forma_pagamento" value="dinheiro"> Dinheiro na entrega</label><br>

            <div id="campo-extra" style="margin-top: 10px;"></div>

            <?php if (!$usuarioLogado): ?>
                <p style="color: red; margin-top: 10px;">Você precisa estar logado para finalizar a compra.</p>
                <input type="submit" class="btn-finalizar" value="FINALIZAR COMPRA" >
            <?php else: ?>
                <input type="submit" class="btn-finalizar" value="FINALIZAR COMPRA">
            <?php endif; ?>
        </form>

        </div>
        </div>
    <?php endif; ?>
</main>
</div>

<!-- Pop-up PIX -->
<div id="popupPix" class="popup-pix" style="display: none;">
  <div class="popup-conteudo">
    <h2>Pagamento via PIX</h2>
    <img src="imgs/burgatto.burger_qr.png" alt="QR Code PIX" class="popup-img">
    <p>Chave PIX:</p>
    <input type="text" value="burgatto@pagamento.com" readonly class="popup-chave">
    <br>
    <button onclick="confirmarPagamentoPix()" class="popup-btn">Já paguei</button>
    <button onclick="fecharPopupPix()" class="popup-btn">Cancelar</button>
  </div>
</div>

<script>
function calcularFrete() {
    const cep = document.getElementById('cep').value;
    if (cep.length < 8) return;

    const formData = new FormData();
    formData.append('cep', cep);

    fetch('meuPedido.act.php', {
        method: 'POST',
        body: formData
    })
    .then(resp => resp.json())
    .then(data => {
        const frete = parseFloat(data.frete);
        const subtotal = <?= $subtotal ?>;
        const total = subtotal + frete;

        const freteElement = document.getElementById('valor-frete');
        const totalElement = document.getElementById('valor-total');
        const btnFinalizar = document.querySelector('.btn-finalizar');

        if (frete === 0) {
            freteElement.innerText = "Fora da área de entrega";
            btnFinalizar.disabled = true;
        } else {
            freteElement.innerText = "Frete: R$ " + frete.toFixed(2).replace('.', ',');
            totalElement.innerText = "Total: R$ " + total.toFixed(2).replace('.', ',');
            btnFinalizar.disabled = false;
        }
    });
}
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const radios = document.querySelectorAll('input[name="forma_pagamento"]');
    const campoExtra = document.getElementById('campo-extra');

    radios.forEach(radio => {
        radio.addEventListener('change', () => {
            if (radio.value === 'dinheiro') {
                campoExtra.innerHTML = `
                    <label>Precisa de troco para quanto?</label>
                    <input type="text" name="troco" placeholder="Ex: 100.00">
                `;
            } else if (radio.value === 'cartao') {
                campoExtra.innerHTML = `
                    <label>Qual bandeira do cartão?</label>
                    <label><input type="radio" name="bandeira" value="Visa"> Visa</label><br>
                    <label><input type="radio" name="bandeira" value="MasterCard"> MasterCard</label><br>
                    <label><input type="radio" name="bandeira" value="Elo"> Elo</label><br>
                    <label><input type="radio" name="bandeira" value="American Express"> American Express</label><br>
                    <label><input type="radio" name="bandeira" value="Hipercard"> Hipercard</label><br>
                    <label><input type="radio" name="bandeira" value="Outro" id="bandeiraOutro"> Outro</label>
                    <div id="campoOutro" style="display:none; margin-top: 5px;">
                        <input type="text" name="bandeiraOutroTexto" id="dgtBand" placeholder="Digite a bandeira">
                    </div>
                `;
            } else {
                campoExtra.innerHTML = '';
            }
        });
    });

    document.addEventListener('change', function (e) {
        if (e.target.name === 'bandeira') {
            const campoOutro = document.getElementById('campoOutro');
            if (campoOutro) {
                campoOutro.style.display = e.target.value === 'Outro' ? 'block' : 'none';
            }
        }
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formPagamento');

    if (!form) return;

    form.addEventListener('submit', async (e) => {
        const forma = form.querySelector('input[name="forma_pagamento"]:checked');
        if (!forma) return;

        if (forma.value === 'pix') {
            e.preventDefault();
            const formData = new FormData(form);
            const response = await fetch('pagamento.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.text();
            if (result.trim() === 'pix') {
                document.getElementById('popupPix').style.display = 'flex';
            }
        } else {
            form.action = 'pagamento.php';
        }
    });
});

function fecharPopupPix() {
    document.getElementById('popupPix').style.display = 'none';
}

function confirmarPagamentoPix() {
    fetch('pagamentoSucessoSimulado.php')
        .then(res => res.text())
        .then(retorno => {
            if (retorno.trim() === 'ok') {
                window.location.href = 'index.php';
            } else {
                alert("Erro ao registrar pedido.");
                console.error(retorno);
            }
        });
}
</script>

<?php include('rodape.php'); ?>
