-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13/06/2025 às 19:46
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `agricultor_db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `agricultores`
--

CREATE TABLE `agricultores` (
  `id` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `organizacao` varchar(150) DEFAULT NULL,
  `uf` char(2) DEFAULT NULL,
  `municipio` varchar(100) DEFAULT NULL,
  `comunidade` varchar(100) DEFAULT NULL,
  `data_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `agricultores`
--

INSERT INTO `agricultores` (`id`, `nome`, `organizacao`, `uf`, `municipio`, `comunidade`, `data_registro`) VALUES
(3, 'Teste', 'teste', 'MG', 'Teste', 'Teste', '2025-06-12 22:02:23');

-- --------------------------------------------------------

--
-- Estrutura para tabela `caderneta`
--

CREATE TABLE `caderneta` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `produto` varchar(100) NOT NULL,
  `quantidade` decimal(10,2) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `data` date NOT NULL,
  `observacoes` text DEFAULT NULL,
  `tipo_cadastro` enum('CONSUMO','TROCA','DOAÇÃO','VENDA') NOT NULL,
  `data_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `configuracoes`
--

CREATE TABLE `configuracoes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `tema` varchar(20) DEFAULT 'claro',
  `notificacoes` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `acao` varchar(50) NOT NULL,
  `descricao` text DEFAULT NULL,
  `data_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `data_nascimento` date NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `endereco` text DEFAULT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp(),
  `senha` varchar(255) NOT NULL,
  `perfil` enum('Administrador','Pesquisador Popular','Agricultor') NOT NULL DEFAULT 'Agricultor'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `cpf`, `data_nascimento`, `email`, `telefone`, `endereco`, `data_cadastro`, `senha`, `perfil`) VALUES
(1, 'Administrador', '000.000.000-00', '2000-01-01', 'admin@example.com', '(00) 00000-0000', 'Endereço inicial', '2025-04-03 12:33:50', '1234', 'Agricultor'),
(2, 'dasdsa', '2132131211', '0000-00-00', 'dsadas@dsadsa', '2312321312', NULL, '2025-05-13 17:00:42', '$2y$10$QfbCrjARKpcqmRCeeI3UU.rO6CfB/hWkrgl5ZkDWRCGh98ylTJ3/S', 'Agricultor'),
(3, 'Gleidson', '051.397.371-08', '0000-00-00', 'bob_glei@hotmail.com', '(61) 98672-7673', NULL, '2025-05-13 17:36:41', '$2y$10$lDfBjjjMd2MNUGmQb2X8N.8YqxZ/UBf4jHESOctChx5T8sKCatrgG', 'Administrador');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `agricultores`
--
ALTER TABLE `agricultores`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `caderneta`
--
ALTER TABLE `caderneta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_usuario_caderneta` (`usuario_id`),
  ADD KEY `idx_data_caderneta` (`data`);

--
-- Índices de tabela `configuracoes`
--
ALTER TABLE `configuracoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_usuario_log` (`usuario_id`),
  ADD KEY `idx_data_log` (`data_registro`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD KEY `idx_cpf` (`cpf`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agricultores`
--
ALTER TABLE `agricultores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `caderneta`
--
ALTER TABLE `caderneta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `configuracoes`
--
ALTER TABLE `configuracoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `caderneta`
--
ALTER TABLE `caderneta`
  ADD CONSTRAINT `caderneta_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `configuracoes`
--
ALTER TABLE `configuracoes`
  ADD CONSTRAINT `configuracoes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
