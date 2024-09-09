-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Tempo de geração: 09/09/2024 às 03:02
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ppi`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `aluno`
--

CREATE TABLE `aluno` (
  `CPF` varchar(50) NOT NULL,
  `Acompanhamento` int(11) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Nome` varchar(50) DEFAULT NULL,
  `Aux_permanencia` int(11) DEFAULT NULL,
  `Cidade` varchar(50) DEFAULT NULL,
  `Genero` varchar(50) DEFAULT NULL,
  `Reprovacoes` int(11) DEFAULT NULL,
  `Apoio_psic` int(11) DEFAULT NULL,
  `Cotista` int(11) DEFAULT NULL,
  `Data_nasc` date DEFAULT NULL,
  `UF` varchar(50) DEFAULT NULL,
  `Estagio` int(11) DEFAULT NULL,
  `Interno` int(11) DEFAULT NULL,
  `Matricula` int(11) DEFAULT NULL,
  `Acomp_saude` int(11) DEFAULT NULL,
  `Proj_pesq` int(11) DEFAULT NULL,
  `Proj_ext` int(11) DEFAULT NULL,
  `Proj_ens` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `aluno`
--

INSERT INTO `aluno` (`CPF`, `Acompanhamento`, `Email`, `Nome`, `Aux_permanencia`, `Cidade`, `Genero`, `Reprovacoes`, `Apoio_psic`, `Cotista`, `Data_nasc`, `UF`, `Estagio`, `Interno`, `Matricula`, `Acomp_saude`, `Proj_pesq`, `Proj_ext`, `Proj_ens`) VALUES
('04861168082', 0, 'jean.2022303457@aluno.iffar.edu.br', 'Jean Ferrari', 0, 'Frederico Westphalen', 'Masculino', 0, 1, 0, '2006-06-27', 'RS', 0, 1, 2022303457, 0, 1, 0, 1),
('43423423', 0, 'lorenzo@gmail.com', 'lorenzo', 0, 'frederico', 'masculino', 0, 0, 0, '2024-08-12', 'RS', 0, 0, 34513, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `curso`
--

CREATE TABLE `curso` (
  `ID` int(11) NOT NULL,
  `Nome` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `curso`
--

INSERT INTO `curso` (`ID`, `Nome`) VALUES
(1, 'Informática'),
(3, 'ADM'),
(14, 'Agropecuária');

-- --------------------------------------------------------

--
-- Estrutura para tabela `disciplina`
--

CREATE TABLE `disciplina` (
  `ID` int(11) NOT NULL,
  `Nome` varchar(50) DEFAULT NULL,
  `idTurma` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `disciplina`
--

INSERT INTO `disciplina` (`ID`, `Nome`, `idTurma`) VALUES
(1, 'Matemática', 4),
(3, 'Português', 8),
(4, 'Arte', 7),
(8, 'Educação Física', 9),
(9, 'Inglês', 10),
(10, 'Redes 2', 4),
(16, 'Português', 5),
(18, 'Programação 2', 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `disciplina_aluno`
--

CREATE TABLE `disciplina_aluno` (
  `PPI` float DEFAULT NULL,
  `MC` float DEFAULT NULL,
  `AIA` float DEFAULT NULL,
  `Observacoes` varchar(50) DEFAULT NULL,
  `AIS` float DEFAULT NULL,
  `Faltas` int(11) DEFAULT NULL,
  `Nota1` float DEFAULT NULL,
  `Nota2` float DEFAULT NULL,
  `CPF` int(11) NOT NULL,
  `ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `leciona`
--

CREATE TABLE `leciona` (
  `ID` int(11) NOT NULL,
  `idProfessor` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `turma`
--

CREATE TABLE `turma` (
  `Data_entrega` date DEFAULT NULL,
  `Nome` varchar(50) DEFAULT NULL,
  `ID` int(11) NOT NULL,
  `idCurso` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `turma`
--

INSERT INTO `turma` (`Data_entrega`, `Nome`, `ID`, `idCurso`) VALUES
('2024-12-12', '24', 4, 1),
('2024-12-12', '35', 5, 3),
('2024-12-12', '14', 7, 1),
('2024-12-12', '34', 8, 1),
('2024-12-12', '15', 9, 3),
('2024-12-12', '25', 10, 3),
('0000-00-00', '21', 25, 14);

-- --------------------------------------------------------

--
-- Estrutura para tabela `turma_aluno`
--

CREATE TABLE `turma_aluno` (
  `ID` int(11) NOT NULL,
  `CPF` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_setor_professor_administrador`
--

CREATE TABLE `usuario_setor_professor_administrador` (
  `Email` varchar(50) DEFAULT NULL,
  `Senha` varchar(50) DEFAULT NULL,
  `Tipo_usuario` varchar(50) DEFAULT NULL,
  `Nome` varchar(50) DEFAULT NULL,
  `ID` int(11) NOT NULL,
  `Alt_list_prof` int(11) DEFAULT NULL,
  `G_alunos` int(11) DEFAULT NULL,
  `G_emiss` int(11) DEFAULT NULL,
  `G_datas` int(11) DEFAULT NULL,
  `G_orient` int(11) DEFAULT NULL,
  `G_obs` int(11) DEFAULT NULL,
  `G_notas` int(11) DEFAULT NULL,
  `G_faltas` int(11) DEFAULT NULL,
  `MatriculaSiape` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario_setor_professor_administrador`
--

INSERT INTO `usuario_setor_professor_administrador` (`Email`, `Senha`, `Tipo_usuario`, `Nome`, `ID`, `Alt_list_prof`, `G_alunos`, `G_emiss`, `G_datas`, `G_orient`, `G_obs`, `G_notas`, `G_faltas`, `MatriculaSiape`) VALUES
('Jean@gmail.com', 'e8d95a51f3af4a3b134bf6bb680a213a', 'admin', 'Jean', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`CPF`);

--
-- Índices de tabela `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`ID`);

--
-- Índices de tabela `disciplina`
--
ALTER TABLE `disciplina`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `idTurma` (`idTurma`);

--
-- Índices de tabela `disciplina_aluno`
--
ALTER TABLE `disciplina_aluno`
  ADD PRIMARY KEY (`CPF`,`ID`);

--
-- Índices de tabela `leciona`
--
ALTER TABLE `leciona`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `idProfessor` (`idProfessor`);

--
-- Índices de tabela `turma`
--
ALTER TABLE `turma`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `idCurso` (`idCurso`);

--
-- Índices de tabela `turma_aluno`
--
ALTER TABLE `turma_aluno`
  ADD PRIMARY KEY (`ID`,`CPF`);

--
-- Índices de tabela `usuario_setor_professor_administrador`
--
ALTER TABLE `usuario_setor_professor_administrador`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `curso`
--
ALTER TABLE `curso`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de tabela `disciplina`
--
ALTER TABLE `disciplina`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `turma`
--
ALTER TABLE `turma`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de tabela `usuario_setor_professor_administrador`
--
ALTER TABLE `usuario_setor_professor_administrador`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `disciplina`
--
ALTER TABLE `disciplina`
  ADD CONSTRAINT `disciplina_ibfk_1` FOREIGN KEY (`idTurma`) REFERENCES `turma` (`ID`);

--
-- Restrições para tabelas `leciona`
--
ALTER TABLE `leciona`
  ADD CONSTRAINT `leciona_ibfk_1` FOREIGN KEY (`ID`) REFERENCES `disciplina` (`ID`),
  ADD CONSTRAINT `leciona_ibfk_2` FOREIGN KEY (`idProfessor`) REFERENCES `usuario_setor_professor_administrador` (`ID`);

--
-- Restrições para tabelas `turma`
--
ALTER TABLE `turma`
  ADD CONSTRAINT `turma_ibfk_1` FOREIGN KEY (`idCurso`) REFERENCES `curso` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
