-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 09-Out-2020 às 16:04
-- Versão do servidor: 10.1.37-MariaDB
-- versão do PHP: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elian`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `empresa`
--

CREATE TABLE `empresa` (
  `empresaId` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `cnpj` bigint(14) UNSIGNED NOT NULL,
  `dataCadastro` date NOT NULL,
  `dataAlteracao` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `empresa`
--

INSERT INTO `empresa` (`empresaId`, `nome`, `cnpj`, `dataCadastro`, `dataAlteracao`) VALUES
(95, 'Denis teste', 23423423423432, '2020-10-09', '2020-10-09');

-- --------------------------------------------------------

--
-- Estrutura da tabela `empresacontato`
--

CREATE TABLE `empresacontato` (
  `contatoId` int(11) NOT NULL,
  `empresaId` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefone` bigint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `empresacontato`
--

INSERT INTO `empresacontato` (`contatoId`, `empresaId`, `email`, `telefone`) VALUES
(71, 95, 'contato@teste.com.br', 47999999999);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`empresaId`);

--
-- Indexes for table `empresacontato`
--
ALTER TABLE `empresacontato`
  ADD PRIMARY KEY (`contatoId`),
  ADD KEY `FK_EMPRESA_CONTATO_EMPRESA` (`empresaId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `empresa`
--
ALTER TABLE `empresa`
  MODIFY `empresaId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `empresacontato`
--
ALTER TABLE `empresacontato`
  MODIFY `contatoId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `empresacontato`
--
ALTER TABLE `empresacontato`
  ADD CONSTRAINT `FK_EMPRESA_CONTATO_EMPRESA` FOREIGN KEY (`empresaId`) REFERENCES `empresa` (`empresaId`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
