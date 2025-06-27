-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27/06/2025 às 07:00
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
(3, 'Teste', 'teste', 'MG', 'Teste', 'Teste', '2025-06-12 22:02:23'),
(4, 'Teste 2', 'Teste 2', 'DF', 'Brasilia', 'Teste 2', '2025-06-27 02:30:36');

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

--
-- Despejando dados para a tabela `caderneta`
--

INSERT INTO `caderneta` (`id`, `usuario_id`, `produto`, `quantidade`, `valor`, `data`, `observacoes`, `tipo_cadastro`, `data_registro`) VALUES
(3, 3, '23', 123.00, 321.00, '2025-06-09', NULL, 'CONSUMO', '2025-06-26 01:38:32'),
(4, 3, '213', 11.00, 22.00, '2025-06-20', NULL, 'TROCA', '2025-06-26 01:41:55');

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
-- Estrutura para tabela `fotos_agricultor`
--

CREATE TABLE `fotos_agricultor` (
  `id` int(11) NOT NULL,
  `agricultor_id` int(11) NOT NULL,
  `caminho` varchar(255) NOT NULL,
  `nome_arquivo` varchar(255) NOT NULL,
  `data_upload` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `fotos_agricultor`
--

INSERT INTO `fotos_agricultor` (`id`, `agricultor_id`, `caminho`, `nome_arquivo`, `data_upload`) VALUES
(2, 3, 'uploads/agricultores/3/Figura-1-Caderneta-Agroecologica-CAMPONESA-C.png', 'Figura-1-Caderneta-Agroecologica-CAMPONESA-C.png', '2025-06-27 02:20:17');

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
  `senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `cpf`, `data_nascimento`, `email`, `telefone`, `endereco`, `data_cadastro`, `senha`) VALUES
(3, 'Gleidson', '051.397.371-08', '2025-06-05', 'bob_glei@hotmail.com', '(61) 98672-7673', NULL, '2025-05-13 17:36:41', '$2y$10$lDfBjjjMd2MNUGmQb2X8N.8YqxZ/UBf4jHESOctChx5T8sKCatrgG'),
(5, 'teste', '471.888.680-50', '2025-06-25', 'teste@teste', '(61) 98672-7673', NULL, '2025-06-27 03:52:06', '$2y$10$6jtiSry8fLzmfFK4kJWrveSsJn9.E6rfdWVcj6iZXTBfgWJywquS.');

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
-- Índices de tabela `fotos_agricultor`
--
ALTER TABLE `fotos_agricultor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agricultor_id` (`agricultor_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `caderneta`
--
ALTER TABLE `caderneta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `configuracoes`
--
ALTER TABLE `configuracoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `fotos_agricultor`
--
ALTER TABLE `fotos_agricultor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- Restrições para tabelas `fotos_agricultor`
--
ALTER TABLE `fotos_agricultor`
  ADD CONSTRAINT `fotos_agricultor_ibfk_1` FOREIGN KEY (`agricultor_id`) REFERENCES `agricultores` (`id`);

--
-- Restrições para tabelas `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
