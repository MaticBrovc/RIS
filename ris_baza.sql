-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 17, 2021 at 06:45 PM
-- Server version: 8.0.13-4
-- PHP Version: 7.2.24-0ubuntu0.18.04.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jSMN5gWYsq`
--

-- --------------------------------------------------------

--
-- Table structure for table `odsotnosti`
--

CREATE TABLE `odsotnosti` (
  `IDOdsotnosti` int(11) NOT NULL,
  `datumOdsotnosti` date NOT NULL,
  `UserID` int(11) NOT NULL,
  `tipOdsotnosti` varchar(10) CHARACTER SET utf8 COLLATE utf8_slovenian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `odsotnosti`
--

INSERT INTO `odsotnosti` (`IDOdsotnosti`, `datumOdsotnosti`, `UserID`, `tipOdsotnosti`) VALUES
(1, '2021-04-27', 2, 'Bol'),
(2, '2021-04-26', 2, 'Dop'),
(3, '2021-04-26', 6, 'Bol'),
(4, '2021-03-25', 6, 'Bol');

-- --------------------------------------------------------

--
-- Table structure for table `placilneliste`
--

CREATE TABLE `placilneliste` (
  `IDplacilnaLista` int(11) NOT NULL,
  `datumIzracuna` date NOT NULL,
  `UserID` int(11) NOT NULL,
  `placa` decimal(10,2) NOT NULL,
  `mesec` int(11) NOT NULL,
  `leto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `placilneliste`
--

INSERT INTO `placilneliste` (`IDplacilnaLista`, `datumIzracuna`, `UserID`, `placa`, `mesec`, `leto`) VALUES
(15, '2021-05-17', 2, '49.50', 3, 2021),
(16, '2021-05-17', 6, '111.10', 3, 2021),
(17, '2021-05-17', 6, '152.60', 4, 2021);

-- --------------------------------------------------------

--
-- Table structure for table `prisotnosti`
--

CREATE TABLE `prisotnosti` (
  `IDPrisotnosti` int(11) NOT NULL,
  `casPrihoda` datetime NOT NULL,
  `casOdhoda` datetime NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `prisotnosti`
--

INSERT INTO `prisotnosti` (`IDPrisotnosti`, `casPrihoda`, `casOdhoda`, `UserID`) VALUES
(1, '2021-04-29 08:06:41', '2021-04-29 16:06:41', 2),
(3, '2021-04-28 08:07:24', '2021-04-28 16:07:24', 2),
(4, '2021-05-04 04:27:05', '2021-05-04 12:27:05', 5),
(5, '2021-04-28 08:07:24', '2021-04-28 16:07:24', 6),
(6, '2021-04-08 08:00:00', '2021-04-08 16:00:00', 6),
(7, '2021-03-10 10:00:00', '2021-03-10 15:00:00', 2),
(8, '2021-03-15 10:00:00', '2021-03-15 20:00:00', 6);

-- --------------------------------------------------------

--
-- Table structure for table `tipiodsotnosti`
--

CREATE TABLE `tipiodsotnosti` (
  `tipOdsotnosti` varchar(10) CHARACTER SET utf8 COLLATE utf8_slovenian_ci NOT NULL,
  `opisOdsotnosti` varchar(45) CHARACTER SET utf8 COLLATE utf8_slovenian_ci NOT NULL,
  `koeficient` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `tipiodsotnosti`
--

INSERT INTO `tipiodsotnosti` (`tipOdsotnosti`, `opisOdsotnosti`, `koeficient`) VALUES
('Bol', 'Bolniška', '0.95'),
('Dop', 'Dopust', '1.00');

-- --------------------------------------------------------

--
-- Table structure for table `uporabniki`
--

CREATE TABLE `uporabniki` (
  `IDUser` int(11) NOT NULL,
  `username` varchar(45) CHARACTER SET utf8 COLLATE utf8_slovenian_ci NOT NULL,
  `pass` varchar(45) CHARACTER SET utf8 COLLATE utf8_slovenian_ci NOT NULL,
  `ime` varchar(45) CHARACTER SET utf8 COLLATE utf8_slovenian_ci NOT NULL,
  `priimek` varchar(45) CHARACTER SET utf8 COLLATE utf8_slovenian_ci NOT NULL,
  `urnaPostavka` decimal(10,2) DEFAULT NULL,
  `aktiven` tinyint(1) NOT NULL,
  `datumPrekinitveDela` date DEFAULT NULL,
  `dobilZadnjoPlaco` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_slovenian_ci;

--
-- Dumping data for table `uporabniki`
--

INSERT INTO `uporabniki` (`IDUser`, `username`, `pass`, `ime`, `priimek`, `urnaPostavka`, `aktiven`, `datumPrekinitveDela`, `dobilZadnjoPlaco`) VALUES
(2, 'matic', 'matic123', 'Matic', 'Brovč', '8.80', 1, NULL, NULL),
(3, 'adnan', 'adnan123', 'adnan', 'ciksuc', '5.50', 1, NULL, NULL),
(5, 'userNull', 'userNull', 'user', 'user', NULL, 1, NULL, NULL),
(6, 'neaktiven', 'neaktiven123', 'Nima', 'Veze', '6.00', 0, '2021-04-28', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `odsotnosti`
--
ALTER TABLE `odsotnosti`
  ADD PRIMARY KEY (`IDOdsotnosti`),
  ADD KEY `fk_uporabnik_odsotnosti` (`UserID`),
  ADD KEY `fk_odsotnost_tipiOdsotnosti` (`tipOdsotnosti`);

--
-- Indexes for table `placilneliste`
--
ALTER TABLE `placilneliste`
  ADD PRIMARY KEY (`IDplacilnaLista`),
  ADD KEY `fk_uporabnik_placilneListe` (`UserID`);

--
-- Indexes for table `prisotnosti`
--
ALTER TABLE `prisotnosti`
  ADD PRIMARY KEY (`IDPrisotnosti`),
  ADD KEY `fk_uporabnik_prisotnost` (`UserID`);

--
-- Indexes for table `tipiodsotnosti`
--
ALTER TABLE `tipiodsotnosti`
  ADD PRIMARY KEY (`tipOdsotnosti`);

--
-- Indexes for table `uporabniki`
--
ALTER TABLE `uporabniki`
  ADD PRIMARY KEY (`IDUser`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `odsotnosti`
--
ALTER TABLE `odsotnosti`
  MODIFY `IDOdsotnosti` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `placilneliste`
--
ALTER TABLE `placilneliste`
  MODIFY `IDplacilnaLista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `prisotnosti`
--
ALTER TABLE `prisotnosti`
  MODIFY `IDPrisotnosti` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `uporabniki`
--
ALTER TABLE `uporabniki`
  MODIFY `IDUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `odsotnosti`
--
ALTER TABLE `odsotnosti`
  ADD CONSTRAINT `fk_odsotnost_tipiOdsotnosti` FOREIGN KEY (`tipOdsotnosti`) REFERENCES `tipiodsotnosti` (`tipodsotnosti`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_uporabnik_odsotnosti` FOREIGN KEY (`UserID`) REFERENCES `uporabniki` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `placilneliste`
--
ALTER TABLE `placilneliste`
  ADD CONSTRAINT `fk_uporabnik_placilneListe` FOREIGN KEY (`UserID`) REFERENCES `uporabniki` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prisotnosti`
--
ALTER TABLE `prisotnosti`
  ADD CONSTRAINT `fk_uporabnik_prisotnost` FOREIGN KEY (`UserID`) REFERENCES `uporabniki` (`iduser`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
