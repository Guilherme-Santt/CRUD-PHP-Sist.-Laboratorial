-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28/01/2025 às 17:30
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
-- Banco de dados: `system`
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
  `unidade` varchar(50) DEFAULT NULL,
  `assinatura` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `email`, `telefone`, `nascimento`, `data`, `senha`, `unidade`, `assinatura`) VALUES
(68, 'Guilherme', 'admin@admin.com', '11995910318', '2000-01-12', '2025-01-28 13:08:27', '$2y$10$o/GiZHHYR6UYFoA5Q7axi.hilyfy6x85BTxXlUhMU3tg/VphhuY.e', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `exames`
--

CREATE TABLE `exames` (
  `exameid` int(11) NOT NULL,
  `codigo` varchar(3) NOT NULL,
  `descricao` longtext NOT NULL,
  `valor` int(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `exames`
--

INSERT INTO `exames` (`exameid`, `codigo`, `descricao`, `valor`) VALUES
(1, 'COL', 'Colesterol', 51),
(2, 'HDL', 'Colesterol HDL', 43),
(3, 'TRI', 'Triglicerides', 77),
(6, 'AUR', 'Acido úrico', 55),
(7, 'CAI', 'Cálcio Ionico', 33),
(10, 'FOS', 'Fosforo', 99),
(16, 'HEM', 'Hemograma', 100);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pacientes`
--

CREATE TABLE `pacientes` (
  `ID` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `endereco` varchar(100) NOT NULL,
  `CEP` int(50) DEFAULT NULL,
  `cidade` text DEFAULT NULL,
  `telefone` varchar(15) NOT NULL,
  `sexo` varchar(100) NOT NULL,
  `data` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `nascimento` date NOT NULL,
  `RG` varchar(100) DEFAULT NULL,
  `CPF` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pacientes`
--

INSERT INTO `pacientes` (`ID`, `nome`, `email`, `endereco`, `CEP`, `cidade`, `telefone`, `sexo`, `data`, `nascimento`, `RG`, `CPF`) VALUES
(45, 'Guilherme', 'admin@admin.com', 'Cotia', 6700505, 'cotia', '11995910318', 'Masculino', '2025-01-28 11:38:04', '2001-03-12', '60036043440', '51366329848');

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
(76, 31, 3),
(77, 31, 2),
(78, 32, 3),
(79, 32, 2),
(80, 33, 1),
(82, 33, 3),
(86, 45, 1),
(87, 45, 3),
(88, 45, 2);

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
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT de tabela `exames`
--
ALTER TABLE `exames`
  MODIFY `exameid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de tabela `pacientes_exames`
--
ALTER TABLE `pacientes_exames`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
