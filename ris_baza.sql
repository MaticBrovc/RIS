-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2021 at 05:02 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ris_baza`
--

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
-- Indexes for dumped tables
--

--
-- Indexes for table `placilneliste`
--
ALTER TABLE `placilneliste`
  ADD PRIMARY KEY (`IDplacilnaLista`),
  ADD KEY `fk_uporabnik_placilneListe` (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `placilneliste`
--
ALTER TABLE `placilneliste`
  MODIFY `IDplacilnaLista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `placilneliste`
--
ALTER TABLE `placilneliste`
  ADD CONSTRAINT `fk_uporabnik_placilneListe` FOREIGN KEY (`UserID`) REFERENCES `uporabniki` (`IDUser`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
