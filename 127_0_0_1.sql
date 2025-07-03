-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 04/06/2025 às 18:54
-- Versão do servidor: 9.1.0
-- Versão do PHP: 8.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `db_burgatto`
--
CREATE DATABASE IF NOT EXISTS `db_burgatto` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `db_burgatto`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_itens_pedido`
--

DROP TABLE IF EXISTS `tb_itens_pedido`;
CREATE TABLE IF NOT EXISTS `tb_itens_pedido` (
  `cod_item` int NOT NULL AUTO_INCREMENT,
  `cod_pedido` int DEFAULT NULL,
  `cod_produto` int DEFAULT NULL,
  `quantidade` int DEFAULT NULL,
  `valor_unitario` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`cod_item`),
  KEY `cod_pedido` (`cod_pedido`),
  KEY `cod_produto` (`cod_produto`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_pedidos`
--

DROP TABLE IF EXISTS `tb_pedidos`;
CREATE TABLE IF NOT EXISTS `tb_pedidos` (
  `cod_pedido` int NOT NULL AUTO_INCREMENT,
  `cod_usuario` int DEFAULT NULL,
  `data_pedido` datetime DEFAULT CURRENT_TIMESTAMP,
  `status_pagamento` enum('pendente','pago','cancelado') DEFAULT 'pendente',
  `valor_total` decimal(10,2) DEFAULT NULL,
  `referencia_pagamento` varchar(255) DEFAULT NULL,
  `forma_pagamento` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`cod_pedido`),
  KEY `cod_usuario` (`cod_usuario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_produtos`
--

DROP TABLE IF EXISTS `tb_produtos`;
CREATE TABLE IF NOT EXISTS `tb_produtos` (
  `cod_produto` int NOT NULL AUTO_INCREMENT,
  `descricao_produto` varchar(50) NOT NULL,
  `ingredientes_produto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor_produto` decimal(10,2) NOT NULL,
  `img_produto` varchar(255) NOT NULL,
  `categoria_produto` varchar(50) NOT NULL,
  `status_produto` varchar(50) NOT NULL,
  PRIMARY KEY (`cod_produto`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tb_produtos`
--

INSERT INTO `tb_produtos` (`cod_produto`, `descricao_produto`, `ingredientes_produto`, `valor_produto`, `img_produto`, `categoria_produto`, `status_produto`) VALUES
(1, 'Cheese Bacon', 'Pão brioche, hambúrguer artesanal, bacon, queijo cheddar e maionese caseira', 29.90, 'imgs/burger1.jpg', 'burgers', 'ativo'),
(2, 'Bacon Salad', 'Pão brioche, hambúrguer artesanal queijo, bacon, alface fresca, tomate e maionese caseira.', 34.90, 'imgs/burger2.jpg', 'burgers', 'ativo'),
(3, 'Pickle Brie', 'Pão brioche, hambúrguer artesanal com queijo brie, picles, cebola roxa e maionese caseira.', 34.50, 'imgs/burger3.jpg', 'burgers', 'ativo'),
(4, 'Cheddar Melt', 'Pão australiano, hambúrguer artesanal envolto em cheddar e cebola caramelizada.', 38.90, 'imgs/burger4.jpg', 'burgers', 'ativo'),
(5, 'Onion Rings Bacon', 'Pão brioche, hambúrguer artesanal, bacon, queijo cheddar, onion rings e molho barbecue', 34.90, 'imgs/burger5.jpg', 'burgers', 'ativo'),
(6, 'Supreme Salad', 'Pão brioche, hambúrguer artesanal, queijo cheddar, alface, tomate, picles e maionese caseira.', 34.90, 'imgs/burger6.jpg', 'burgers', 'ativo'),
(7, 'Pickle Mozzarella', 'Pão brioche, hambúrguer artesanal, queijo mussarela, picles, cebola roxa e maionese caseira.', 30.90, 'imgs/burger7.jpg', 'burgers', 'ativo'),
(8, 'Big Bacon', 'Pão brioche, hambúrguer artesanal, bacon, queijo, alface, tomate, cebola e maionese caseira.', 36.90, 'imgs/burger8.jpg', 'burgers', 'ativo'),
(9, 'Batata Frita', 'Batata frita crocante, coberta com cheddar e bacon.', 25.00, 'imgs/batata2.jpg', 'acompanhamentos', 'ativo'),
(10, 'Onion Rings', 'Anéis de cebola empanados.', 20.00, 'imgs/onionRings.png', 'acompanhamentos', 'ativo'),
(11, 'Queijo Empanado', 'Cubos de queijo provolone empanados.', 25.00, 'imgs/queijoEmpanado.jpg', 'acompanhamentos', 'ativo'),
(12, 'Frango Frito', 'Tiras de frango empanados.', 25.00, 'imgs/frangoEmpanado.jpg', 'acompanhamentos', 'ativo'),
(13, 'Sorvete', 'Taça de sorvete 500ml', 34.90, 'imgs/sobremesa1.jpg', 'sobremesas', 'ativo'),
(14, 'Churros', 'Mini Churros com doce de leite.', 29.90, 'imgs/sobremesaChurros2.jpg', 'sobremesas', 'ativo'),
(15, 'Brownie', 'Brownie com cobertura de chocolate.', 29.90, 'imgs/sobremesaBrownie.jpg', 'sobremesas', 'ativo'),
(16, 'Petit-Gateau', 'Petit-Gateau de chocolate com sorvete de baunilha.', 35.90, 'imgs/sobremesaPetitGateau.jpg', 'sobremesas', 'ativo'),
(17, 'Tiramisù', 'Queijo mascarpone, biscoitos champanhe, café, conhaque e chocolate em pó.', 35.90, 'imgs/sobremesaTiramisu.jpg', 'sobremesas', 'ativo'),
(18, 'Torta de Limão', 'Torta recheada com um creme a base de limão.', 29.90, 'imgs/sobremesaTorta.jpg', 'sobremesas', 'ativo'),
(19, 'Cerveja Heineken Long Neck', '330ml', 12.90, 'imgs/heinekenLong.png', 'bebidas', 'ativo'),
(20, 'Coca-cola Original Lata', '350ml', 5.00, 'imgs/cocaLata.jpg', 'bebidas', 'ativo'),
(21, 'Coca-cola Sem Açúcar Lata', '350ml', 5.00, 'imgs/cocaSemAcucarLata.jpg', 'bebidas', 'ativo'),
(22, 'Fanta Uva Lata', '350ml', 5.00, 'imgs/fantaUva.jpg', 'bebidas', 'ativo'),
(23, 'Fanta Laranja Lata', '350ml', 5.00, 'imgs/fantaLaranja.jpg', 'bebidas', 'ativo'),
(24, 'Guaraná Antarctica Lata', '350ml', 5.00, 'imgs/guarana.jpg', 'bebidas', 'ativo'),
(25, 'Água Crystal Sem Gás', '500ml', 2.50, 'imgs/agua.png', 'bebidas', 'ativo'),
(26, 'Água Crystal Com Gás', '500ml', 3.50, 'imgs/aguaGas.png', 'bebidas', 'ativo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tb_usuarios`
--

DROP TABLE IF EXISTS `tb_usuarios`;
CREATE TABLE IF NOT EXISTS `tb_usuarios` (
  `cod_usuario` int NOT NULL AUTO_INCREMENT,
  `nome_usuario` varchar(100) NOT NULL,
  `cpf_usuario` varchar(14) NOT NULL,
  `data_nasc_usuario` date DEFAULT NULL,
  `email_usuario` varchar(100) NOT NULL,
  `senha_usuario` varchar(255) NOT NULL,
  `telefone_usuario` varchar(15) NOT NULL,
  `cep_usuario` varchar(9) NOT NULL,
  `endereco_usuario` varchar(100) NOT NULL,
  `numero_endereco_usuario` int NOT NULL,
  `tipo_usuario` varchar(50) NOT NULL,
  `condicaoUsuario` char(1) NOT NULL DEFAULT 'a',
  PRIMARY KEY (`cod_usuario`),
  UNIQUE KEY `email_usuario` (`email_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tb_usuarios`
--

INSERT INTO `tb_usuarios` (`cod_usuario`, `nome_usuario`, `cpf_usuario`, `data_nasc_usuario`, `email_usuario`, `senha_usuario`, `telefone_usuario`, `cep_usuario`, `endereco_usuario`, `numero_endereco_usuario`, `tipo_usuario`, `condicaoUsuario`) VALUES
(1, 'Walter Lopes', '540.522.338-70', '2006-05-02', 'adm@gmail.com', '$2y$10$/xXpPgpxnJo2jLlrDwLKL.lujk71kjT/woQ7aMfSxNczha07zZJ4e', '(11) 93340-3659', '08420-410', 'Rua Professora Joana Fagundes', 300, 'admin', 'a'),
(2, 'Gabriel Cunha', '124.154.846-11', '1987-03-05', 'valdelice@gmail.com', '$2y$10$HZoYirRe6nIxkjiXZI0NEen.2GtW4VOlU9r6a1.dqHzvizWlHj6Ii', '(11) 98756-5222', '08420-300', 'Rua Ferreira de Camargo', 45, '', 'a'),
(3, 'Gabriel Soares', '250.554.205-40', '2004-02-17', 'gabigol@gmail.com', '$2y$10$3VkWg.O1ZiCNxhyYMvtXHeqvOUKKvwVjacxZiWis0wnSBvmtn/x1W', '(11) 91546-4545', '08452-210', 'Rua Padre Cataldino', 60, '', 'a'),
(5, 'Victoria Emanuelle Guesi', '756.467.567-56', '2004-04-02', 'victoria@gmail.com', '$2y$10$1Ej7USAo2jKvJaXQnLiSW.aHa0VwTVyVvhszZb5Bu5CFGHe2PiKfy', '(11) 98654-8236', '08255-740', 'Rua Francisco Albani', 12, '', 'a');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
