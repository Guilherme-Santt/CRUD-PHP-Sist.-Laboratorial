-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 21/01/2024 às 20:31
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
-- Banco de dados: `crud_clientes`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `nascimento` date DEFAULT NULL,
  `data` datetime NOT NULL DEFAULT current_timestamp(),
  `senha` longtext NOT NULL,
  `unidade` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `email`, `telefone`, `nascimento`, `data`, `senha`, `unidade`) VALUES
(46, 'Gui', 'admin@admin.com', '11988888123', '2001-03-12', '2024-01-16 14:00:05', '$2y$10$KXKZ1xev.tnfU6yplONhM.a/pZBrG/my.2Zh/pX9Eq9S3Doi/KLdu', 'Matriz');

-- --------------------------------------------------------

--
-- Estrutura para tabela `exames`
--

CREATE TABLE `exames` (
  `exameid` int(11) NOT NULL,
  `codigo` varchar(3) NOT NULL,
  `descricao` longtext NOT NULL,
  `nome` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `exames`
--

INSERT INTO `exames` (`exameid`, `codigo`, `descricao`, `nome`) VALUES
(2, 'COL', 'BIOQUIMICA', 'Colesterol'),
(3, 'HDL', 'BIOQUIMICA', 'Colesterol HDL'),
(4, 'TRI', 'BIOQUÍMICA', 'TRIGLICERIDES'),
(5, 'HEM', 'HEMOGRAMA', 'HEMOGRAMA');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pacientes`
--

CREATE TABLE `pacientes` (
  `ID` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `endereco` varchar(100) NOT NULL,
  `telefone` varchar(15) NOT NULL,
  `sexo` varchar(100) NOT NULL,
  `data` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `nascimento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pacientes`
--

INSERT INTO `pacientes` (`ID`, `nome`, `email`, `endereco`, `telefone`, `sexo`, `data`, `nascimento`) VALUES
(10, 'Guilherme', 'guisant@icloud.com', 'R.St', '11995910318', 'Masculino', '2024-01-21 15:41:36', '2001-03-12'),
(11, 'Mayra', 'Mayra@icloud.com', 'R.St', '11995910318', 'Feminino', '2024-01-21 15:41:56', '2001-03-12');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pacientes_exames`
--

CREATE TABLE `pacientes_exames` (
  `id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `exame_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pacientes_exames`
--

INSERT INTO `pacientes_exames` (`id`, `paciente_id`, `exame_id`) VALUES
(17, 1, 2),
(18, 1, 3),
(19, 1, 4),
(20, 1, 5),
(21, 10, 2),
(22, 10, 3),
(23, 10, 4),
(26, 10, 5);

-- --------------------------------------------------------

--
-- Estrutura para tabela `sugestoes`
--

CREATE TABLE `sugestoes` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `sugestao` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `exames`
--
ALTER TABLE `exames`
  ADD PRIMARY KEY (`exameid`);

--
-- Índices de tabela `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`ID`);

--
-- Índices de tabela `pacientes_exames`
--
ALTER TABLE `pacientes_exames`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pacienteid` (`paciente_id`),
  ADD KEY `exame_id` (`exame_id`);

--
-- Índices de tabela `sugestoes`
--
ALTER TABLE `sugestoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de tabela `exames`
--
ALTER TABLE `exames`
  MODIFY `exameid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `pacientes_exames`
--
ALTER TABLE `pacientes_exames`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de tabela `sugestoes`
--
ALTER TABLE `sugestoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
