// MENU
function toggleMenu() {
    let mobileMenu = document.querySelector(".mobile-menu");
    mobileMenu.style.display = (mobileMenu.style.display === "flex") ? "none" : "flex";
}

document.querySelectorAll(".mobile-menu a").forEach(link => {
    link.addEventListener("click", () => {
        document.querySelector(".mobile-menu").style.display = "none";
    });
});

// Cep
function buscarEndereco() {
    let cepInput = document.getElementById("cep");
    let enderecoInput = document.getElementById("endereco");

    if (!cepInput || !enderecoInput) return;

    let cep = cepInput.value.replace(/\D/g, "");
    
    if (cep.length === 8) {
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (!data.erro) {
                    enderecoInput.value = data.logradouro;
                } else {
                    enderecoInput.value = "";
                    exibirMensagem("CEP não encontrado!", "error");
                }
            })
            .catch(error => {
                console.error("Erro ao buscar CEP:", error);
                exibirMensagem("Erro ao buscar CEP!", "error");
            });
    } else {
        enderecoInput.value = "";
    }
}

function exibirMensagem(msg, tipo) {
    let msgDiv = document.querySelector(".msgErroCadastro");
    if (msgDiv) {
        msgDiv.innerHTML = `<p class="alerta ${tipo}">${msg}</p>`;
    }
}

// EXCLUIR USUÁRIO
function excluir(cod) {
    if (!cod) {
        alert("Código inválido!");
        return;
    }

    let confirmacao = confirm("Tem certeza que deseja excluir este usuário?");
    if (confirmacao) {
        window.location.href = "excluirUsuario.php?cod=" + encodeURIComponent(cod);
    }
}

// Ativar campo de pesquisa específico
function ativarCampo(id) {
    let campos = ["idPesquisa", "nomePesquisa", "cpfPesquisa", "telefonePesquisa"];
    campos.forEach(campo => {
        let campoInput = document.getElementById(campo);
        if (campoInput) campoInput.disabled = true;
    });

    let campoAtivar = document.getElementById(id);
    if (campoAtivar) {
        campoAtivar.disabled = false;
        campoAtivar.focus();
    }
}

// DOMContentLoaded agrupado
document.addEventListener('DOMContentLoaded', () => {
    // Transição de imagens
    const hamburguerDivs = document.querySelectorAll('.pecaAgora2 .hamburguer');
    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('aparecer');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    hamburguerDivs.forEach(div => observer.observe(div));

    // Máscaras do formulário
    $("#cep").mask('00000-000');
    $("#telefone").mask('(00) 00000-0000');
    $("#cpf").mask('000.000.000-00');

    // Data de nascimento
    let inputData = document.querySelector("input[name='data_nasc']");
    if (inputData) {
        inputData.addEventListener("change", function() {
            let data = this.value.split("-");
            if (data.length === 3) {
                this.value = `${data[0]}-${data[1]}-${data[2]}`;
            }
        });
    }

    // Fechar alerta ao clicar
    document.querySelectorAll('.alerta').forEach(alerta => {
        alerta.addEventListener('click', function () {
            this.style.display = 'none';
        });
    });

    // Tabs do cardápio
    const tabs = document.querySelectorAll('.menuCardapio button');
    const categorias = document.querySelectorAll('.categoria');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const id = tab.getAttribute('data-target');

            tabs.forEach(btn => btn.classList.remove('active'));
            tab.classList.add('active');

            categorias.forEach(cat => cat.classList.remove('active'));

            const categoriaAtiva = document.getElementById(id);
            if (categoriaAtiva) {
                categoriaAtiva.classList.add('active');
            }
        });
    });

// Pesquisa no cardápio
    const barraPesquisa = document.getElementById('barraPesquisa');
    if (barraPesquisa) {
        barraPesquisa.addEventListener('input', function () {
            const termo = this.value.toLowerCase().trim();
            const categorias = document.querySelectorAll('.categoria');

            categorias.forEach(categoria => {
                let encontrouAlgum = false;
                const itens = categoria.querySelectorAll('.burger');

                itens.forEach(item => {
                    const nomeItem = item.querySelector('.desc p');
                    if (nomeItem && nomeItem.textContent.toLowerCase().includes(termo)) {
                        item.style.display = '';
                        encontrouAlgum = true;
                    } else {
                        item.style.display = 'none';
                    }
                });

                categoria.style.display = (termo === '' || encontrouAlgum) ? '' : 'none';
            });
        });
    }
});


// Adicionar lanche no carrinho (+/-)
$('.mais, .menos').click(function (e) { 
    e.preventDefault();
        console.log("clicou");
        const row = $(this).closest('tr');
        const id = row.find('.produto-id').val();
        const spanQuantidade = row.find('.quantidade');
        console.log(spanQuantidade);
        const acao = $(this).hasClass('mais') ? 'adicionar' : 'remover';

        $.post('atualizaPedido.php', { id: id, acao: acao }, function (res) {
            const resposta = JSON.parse(res);
            if (resposta.success) {
                if (resposta.quantidade > 0) {
                    spanQuantidade.text(resposta.quantidade);
                } else {
                    row.remove(); // remove o item da tabela se a quantidade for 0
                }

                // Recarrega o total
                location.reload();
            }
        });
    });

//REMOVER TUDO X --- LINO
$('.remover').click(function (e) {
    e.preventDefault();
    const row = $(this).closest('tr');
    const id = row.find('.produto-id').val();

    $.post('atualizaPedido.php', { id: id, acao: 'remover_tudo' }, function (res) {
        const resposta = JSON.parse(res);
        if (resposta.success) {
            row.addClass('remover-animado'); // Aplica a animação

            setTimeout(() => {
                row.remove(); // Remove da tabela após a animação
                location.reload(); // Atualiza totais
            }, 1000); // Tempo igual ao do CSS
        }
    });
});
    
//Remover mensagem flutuante
setTimeout(() => {
    const msg = document.querySelector('.msg-flutuante');
    if (msg) {
        msg.remove();
    }
}, 5000);

//Mensagem de adicionar ao carrinho
function adicionarAoCarrinho(e) {
    e.preventDefault();
    const id = this.dataset.id;
    const categoria = this.dataset.categoria;

    fetch('adicionarCarrinho.act.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `id=${id}&categoria=${categoria}`
    })
    .then(res => res.text())
    .then(res => {
        if (res.trim() === "ok") {
            const msg = document.createElement('div');
            msg.className = 'msg-flutuante';
            msg.innerText = 'Adicionado ao pedido!';
            document.body.appendChild(msg);

            setTimeout(() => {
                msg.remove();
            }, 4500);
        } else {
            console.error('Resposta inesperada do servidor:', res);
        }
    })
    .catch(error => console.error('Erro ao adicionar ao pedido:', error));
}

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll('.btnAdicionar').forEach(btn => {
        btn.removeEventListener('click', adicionarAoCarrinho);
        btn.addEventListener('click', adicionarAoCarrinho);
    });
});

