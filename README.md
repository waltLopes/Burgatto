# 🍔 Burgatto - Sistema de Pedidos Online para Hamburgueria

Este projeto faz parte do Trabalho de Conclusão de Curso (TCC) de Desenvolvimento de Sistemas e consiste na criação de um sistema web completo para uma hamburgueria fictícia chamada **Burgatto**. O objetivo é digitalizar e automatizar o processo de pedidos, gerenciamento de produtos e controle de vendas.

## 🔧 Tecnologias Utilizadas

- **PHP** (Lógica do servidor)
- **MySQL** (Banco de dados relacional)
- **HTML, CSS e JavaScript** (Interface do usuário)
- **Mercado Pago SDK (via QR Code Estático)** (Sistema de pagamento)
- **WAMP** (Ambiente de desenvolvimento local)

## 🧩 Funcionalidades

### Área do Cliente:
- Navegação pelo cardápio com imagens e descrições
- Adição de produtos ao carrinho
- Atualização de quantidades no pedido
- Pagamento por QR Code (Pix)
- Registro automático do pedido no banco de dados após confirmação

### Área Administrativa:
- Cadastro, edição e exclusão de produtos
- Controle de estoque e status dos itens
- Gerenciamento de usuários e permissões
- Controle de entregas e pedidos realizados
- Histórico de pedidos pagos

## 🗃️ Estrutura do Banco de Dados

As principais tabelas utilizadas são:

- `tb_produtos` – produtos do cardápio
- `tb_pedidos` – pedidos realizados
- `tb_itens_pedido` – itens de cada pedido
- `tb_usuarios` – controle de acesso dos usuários
- `tb_entregas` – registro e status de entrega
- `tb_pagamentos` – dados de confirmação de pagamento

## 💡 Objetivo

O sistema foi desenvolvido com foco em **simplicidade, funcionalidade e escalabilidade**, podendo ser facilmente adaptado para uso real em pequenas hamburguerias ou lanchonetes.
