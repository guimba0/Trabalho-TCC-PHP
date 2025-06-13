-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06/06/2025 às 18:18
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
-- Banco de dados: `consultaagenda`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `agenda`
--

CREATE TABLE `agenda` (
  `codigo` int(11) NOT NULL,
  `data_hora` datetime NOT NULL,
  `local` varchar(255) NOT NULL,
  `prof_orientador_id` int(11) DEFAULT NULL,
  `prof_convidado1_id` int(11) DEFAULT NULL,
  `prof_convidado2_id` int(11) DEFAULT NULL,
  `id_tcc` int(11) DEFAULT NULL,
  `nota_final` decimal(4,2) DEFAULT NULL,
  `aprovado` tinyint(1) DEFAULT NULL,
  `curso` varchar(255) DEFAULT NULL,
  `cidade` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `aluno`
--

CREATE TABLE `aluno` (
  `RA` varchar(20) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `aluno`
--

INSERT INTO `aluno` (`RA`, `nome`, `email`) VALUES
('1001', 'Ana Silva', 'ana.silva@email.com'),
('1002', 'Bruno Santos', 'bruno.santos@email.com'),
('1003', 'Carla Oliveira', 'carla.oliver@email.com'),
('1004', 'Daniel Costa', 'daniel.costa@email.com'),
('1005', 'Eduarda Pereira', 'eduarda.pereira@email.com'),
('1006', 'Felipe Rodrigues', 'felipe.rodri@email.com'),
('1007', 'Gabriela Almeida', 'gabi.almeida@email.com'),
('1008', 'Hugo Fernandes', 'hugo.fernan@email.com'),
('1009', 'Isabela Gomes', 'isabela.gomes@email.com'),
('1010', 'João Martins', 'joao.martins@email.com'),
('1011', 'Karen Ribeiro', 'karen.ribeiro@email.com'),
('1012', 'Leonardo Lima', 'leo.lima@email.com'),
('1013', 'Mariana Rocha', 'mariana.rocha@email.com'),
('1014', 'Nicolas Souza', 'nicolas.souza@email.com'),
('1015', 'Olivia Barros', 'olivia.barros@email.com'),
('1016', 'Pedro Henrique', 'pedro.henrique@email.com'),
('1017', 'Quiteria Dias', 'quiteria.dias@email.com'),
('1018', 'Rafael Barbosa', 'rafael.barbosa@email.com'),
('1019', 'Sofia Carvalho', 'sofia.carvalho@email.com'),
('1020', 'Thiago Pires', 'thiago.pires@email.com'),
('1021', 'Ursula Antunes', 'ursula.antunes@email.com'),
('1022', 'Victor Nogueira', 'victor.nog@email.com'),
('1023', 'Wanessa Correia', 'wanessa.corr@email.com'),
('1024', 'Xavier Neves', 'xavier.neves@email.com'),
('1025', 'Yara Camargo', 'yara.camargo@email.com'),
('1026', 'Zeca Ferreira', 'zeca.ferreira@email.com'),
('1027', 'Amanda Brito', 'amanda.brito@email.com'),
('1028', 'Bruno Cordeiro', 'bruno.cordeiro@email.com'),
('1029', 'Clara Dantas', 'clara.dantas@email.com'),
('1030', 'Diego Esteves', 'diego.esteves@email.com'),
('1031', 'Erica Fagundes', 'erica.fagundes@email.com'),
('1032', 'Gustavo Rocha', 'gustavo.rocha@email.com'),
('1033', 'Helena Viana', 'helena.viana@email.com'),
('1034', 'Igor Mendonça', 'igor.mend@email.com'),
('1035', 'Julia Navarro', 'julia.navarro@email.com'),
('1036', 'Kleber Pires', 'kleber.pires@email.com'),
('1037', 'Luiza Queiroz', 'luiza.queiroz@email.com'),
('1038', 'Marcelo Ramos', 'marcelo.ramos@email.com'),
('1039', 'Natalia Sales', 'natalia.sales@email.com'),
('1040', 'Otavio Toledo', 'otavio.toledo@email.com');

-- --------------------------------------------------------

--
-- Estrutura para tabela `professor`
--

CREATE TABLE `professor` (
  `id_professor` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `professor`
--

INSERT INTO `professor` (`id_professor`, `nome`, `email`) VALUES
(101, 'Dr. Arthur Almeida', 'arthur.almeida@universidade.com'),
(102, 'Dra. Beatriz Costa', 'beatriz.costa@universidade.com'),
(103, 'Prof. Carlos Eduardo', 'carlos.eduardo@universidade.com'),
(104, 'Profa. Denise Ferreira', 'denise.ferreira@universidade.com'),
(105, 'Dr. Eduardo Gomes', 'eduardo.gomes@universidade.com'),
(106, 'Dra. Fernanda Rocha', 'fernanda.rocha@universidade.com'),
(107, 'Prof. Gustavo Silva', 'gustavo.silva@universidade.com'),
(108, 'Profa. Helena Souza', 'helena.souza@universidade.com');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tcc`
--

CREATE TABLE `tcc` (
  `id_tcc` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `resumo` text DEFAULT NULL,
  `id_tipoTCC` int(11) DEFAULT NULL,
  `RA_aluno` varchar(20) DEFAULT '',
  `RA_aluno2` varchar(100) DEFAULT NULL,
  `RA_aluno3` varchar(100) DEFAULT NULL,
  `id_professor_orientador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipotcc`
--

CREATE TABLE `tipotcc` (
  `id_tipoTCC` int(11) NOT NULL,
  `nome_Tipo` varchar(100) NOT NULL,
  `descricao` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tipotcc`
--

INSERT INTO `tipotcc` (`id_tipoTCC`, `nome_Tipo`, `descricao`) VALUES
(1, 'Monografia', 'Trabalho acadêmico individual aprofundado sobre um tema específico, geralmente exigido como requisito para conclusão de curso de graduação ou pós-graduação lato sensu.'),
(2, 'Artigo Científico', 'Texto conciso que apresenta resultados de pesquisa original ou revisões críticas sobre um tema, destinado à publicação em periódicos científicos para disseminação do conhecimento.'),
(3, 'Projeto Técnico', 'Desenvolvimento de uma solução prática ou produto para um problema específico, comum em cursos técnicos e tecnológicos, aplicando conhecimentos teóricos para um fim prático.');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`codigo`),
  ADD KEY `prof_orientador_id` (`prof_orientador_id`),
  ADD KEY `prof_convidado1_id` (`prof_convidado1_id`),
  ADD KEY `prof_convidado2_id` (`prof_convidado2_id`),
  ADD KEY `id_tcc` (`id_tcc`);

--
-- Índices de tabela `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`RA`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `professor`
--
ALTER TABLE `professor`
  ADD PRIMARY KEY (`id_professor`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `tcc`
--
ALTER TABLE `tcc`
  ADD PRIMARY KEY (`id_tcc`),
  ADD KEY `fk_tipo_tcc_1` (`id_tipoTCC`),
  ADD KEY `fk_id_aluno` (`RA_aluno`),
  ADD KEY `fk_id_aluno2` (`RA_aluno2`),
  ADD KEY `fk_id_aluno3` (`RA_aluno3`),
  ADD KEY `fk_id_professor` (`id_professor_orientador`);

--
-- Índices de tabela `tipotcc`
--
ALTER TABLE `tipotcc`
  ADD PRIMARY KEY (`id_tipoTCC`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agenda`
--
ALTER TABLE `agenda`
  MODIFY `codigo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `professor`
--
ALTER TABLE `professor`
  MODIFY `id_professor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT de tabela `tcc`
--
ALTER TABLE `tcc`
  MODIFY `id_tcc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tipotcc`
--
ALTER TABLE `tipotcc`
  MODIFY `id_tipoTCC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `agenda`
--
ALTER TABLE `agenda`
  ADD CONSTRAINT `agenda_ibfk_1` FOREIGN KEY (`prof_orientador_id`) REFERENCES `professor` (`id_professor`),
  ADD CONSTRAINT `agenda_ibfk_2` FOREIGN KEY (`prof_convidado1_id`) REFERENCES `professor` (`id_professor`),
  ADD CONSTRAINT `agenda_ibfk_3` FOREIGN KEY (`prof_convidado2_id`) REFERENCES `professor` (`id_professor`),
  ADD CONSTRAINT `agenda_ibfk_4` FOREIGN KEY (`id_tcc`) REFERENCES `tcc` (`id_tcc`);

--
-- Restrições para tabelas `tcc`
--
ALTER TABLE `tcc`
  ADD CONSTRAINT `fk_id_aluno` FOREIGN KEY (`RA_aluno`) REFERENCES `aluno` (`RA`),
  ADD CONSTRAINT `fk_id_aluno2` FOREIGN KEY (`RA_aluno2`) REFERENCES `aluno` (`RA`),
  ADD CONSTRAINT `fk_id_aluno3` FOREIGN KEY (`RA_aluno3`) REFERENCES `aluno` (`RA`),
  ADD CONSTRAINT `fk_id_professor` FOREIGN KEY (`id_professor_orientador`) REFERENCES `professor` (`id_professor`),
  ADD CONSTRAINT `fk_tipo_tcc_1` FOREIGN KEY (`id_tipoTCC`) REFERENCES `tipotcc` (`id_tipoTCC`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
