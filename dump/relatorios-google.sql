-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 04-Out-2017 às 20:04
-- Versão do servidor: 5.7.19
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `relatorios-google`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `campanha`
--

DROP TABLE IF EXISTS `campanha`;
CREATE TABLE IF NOT EXISTS `campanha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `campanha`
--

INSERT INTO `campanha` (`id`, `nome`, `id_cliente`) VALUES
(1, 'campanhaTeste', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `canal`
--

DROP TABLE IF EXISTS `canal`;
CREATE TABLE IF NOT EXISTS `canal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `source` varchar(255) NOT NULL,
  `medium` varchar(255) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=70 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `canal`
--

INSERT INTO `canal` (`id`, `nome`, `source`, `medium`, `id_cliente`) VALUES
(1, 'canal', 'sourcetest', 'mediumtest', 1),
(62, 'teste', 'teste', 'teste', 1),
(61, 'teste', 'teste', 'teste', 1),
(59, 'testeCanal', 'testeSource', 'testeMedium', 1),
(58, 'testeCanal', 'source', 'testemedium', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `id_view` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `cliente`
--

INSERT INTO `cliente` (`id`, `nome`, `url`, `id_view`) VALUES
(1, 'master', '', ''),
(2, 'boldercom', '', ''),
(3, 'boldermark', '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `nivel` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `foto`, `id_cliente`, `nivel`) VALUES
(2, 'Administrador', 'admin@master', '21232f297a57a5a743894a0e4a801fc3', '6f73375bc1e492b1a336985544e5d015.jpg', 1, 0),
(5, 'Administrador', 'admin@com', '21232f297a57a5a743894a0e4a801fc3', '6f73375bc1e492b1a336985544e5d015.jpg', 2, 0),
(6, 'Administrador', 'admin@mark', '21232f297a57a5a743894a0e4a801fc3', '6f73375bc1e492b1a336985544e5d015.jpg', 3, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
