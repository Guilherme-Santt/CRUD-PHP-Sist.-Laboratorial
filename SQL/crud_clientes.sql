-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 02/02/2024 às 19:00
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.0.28

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
-- Estrutura para tabela `convenio`
--

CREATE TABLE `convenio` (
  `id` int(11) NOT NULL,
  `nome` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `exames`
--

CREATE TABLE `exames` (
  `exameid` int(11) NOT NULL,
  `codigo` varchar(3) NOT NULL,
  `descricao` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `exames`
--

INSERT INTO `exames` (`exameid`, `codigo`, `descricao`) VALUES
(1, 'COL', 'Colesterol'),
(2, 'HDL', 'Colesterol HDL'),
(3, 'TRI', 'Triglicerides'),
(4, 'HEM', 'Hemograma');

-- --------------------------------------------------------

--
-- Estrutura para tabela `médico`
--

CREATE TABLE `médico` (
  `id` int(11) NOT NULL,
  `nome` longtext NOT NULL,
  `CRM` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `médico`
--

INSERT INTO `médico` (`id`, `nome`, `CRM`) VALUES
(1, 'teste', '123');

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
  `CRM` varchar(100) NOT NULL,
  `Convenio` varchar(100) DEFAULT NULL,
  `diagnostico` longtext DEFAULT NULL,
  `medicamentos` longtext DEFAULT NULL,
  `observacoes` longtext DEFAULT NULL,
  `RG` int(100) DEFAULT NULL,
  `CPF` int(100) DEFAULT NULL,
  `nome_mae` longtext DEFAULT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pacientes`
--

INSERT INTO `pacientes` (`ID`, `nome`, `email`, `endereco`, `CEP`, `cidade`, `telefone`, `sexo`, `data`, `nascimento`, `CRM`, `Convenio`, `diagnostico`, `medicamentos`, `observacoes`, `RG`, `CPF`, `nome_mae`, `id_user`) VALUES
(16, 'Mayra', 'admin123@admin.com', 'R Santa Genoveva, 217 - Jardim Araruama', NULL, NULL, '11995910318', 'Feminino', '2024-02-01 17:38:38', '2000-01-01', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(21, 'Gui', 'guisant@icloud.com', 'R Santa Genoveva, 217 - Jardim Araruama', NULL, NULL, '11995910318', 'Feminino', '2024-02-02 13:46:34', '2001-03-12', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0),
(22, 'Gui', 'guisant@icloud.com', 'R Santa Genoveva, 217 - Jardim Araruama', NULL, NULL, '119959103182', 'Masculino', '2024-02-02 13:47:09', '2001-03-12', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 46),
(23, 'José Guilherme Santos Silva', 'guisant@icloud.com', 'R Santa Genoveva, 217 - Jardim Araruama', 6700505, 'Cotia', '11995910318', 'Masculino', '2024-02-02 14:09:29', '2001-03-12', '123', 'Particular', '', '', '', 123, 2147483647, 'Cristina', 46);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pacientes_exames`
--

CREATE TABLE `pacientes_exames` (
  `id` int(11) NOT NULL,
  `paciente_id` int(11) NOT NULL,
  `exame_id` int(11) NOT NULL,
  `resultado` int(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pacientes_exames`
--

INSERT INTO `pacientes_exames` (`id`, `paciente_id`, `exame_id`, `resultado`) VALUES
(27, 12, 1, 1),
(28, 12, 2, NULL),
(29, 12, 3, NULL),
(31, 13, 1, 1),
(32, 13, 2, 3),
(36, 11, 2, 2),
(38, 11, 1, 4),
(42, 11, 4, NULL),
(50, 48, 2, NULL),
(52, 51, 1, NULL),
(59, 16, 1, NULL),
(60, 16, 2, NULL),
(61, 16, 3, NULL),
(62, 16, 4, NULL);

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
-- Despejando dados para a tabela `sugestoes`
--

INSERT INTO `sugestoes` (`id`, `id_user`, `sugestao`) VALUES
(9, 46, 'aaa');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `convenio`
--
ALTER TABLE `convenio`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `exames`
--
ALTER TABLE `exames`
  ADD PRIMARY KEY (`exameid`);

--
-- Índices de tabela `médico`
--
ALTER TABLE `médico`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `CRM` (`CRM`),
  ADD KEY `id_user` (`id_user`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT de tabela `convenio`
--
ALTER TABLE `convenio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `exames`
--
ALTER TABLE `exames`
  MODIFY `exameid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `médico`
--
ALTER TABLE `médico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `pacientes_exames`
--
ALTER TABLE `pacientes_exames`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de tabela `sugestoes`
--
ALTER TABLE `sugestoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
