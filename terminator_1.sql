-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 20. Okt 2020 um 17:00
-- Server-Version: 10.4.11-MariaDB
-- PHP-Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `terminator`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `termine`
--

CREATE TABLE `termine` (
  `ID` int(10) UNSIGNED NOT NULL,
  `Titel` varchar(50) NOT NULL,
  `Datum` date NOT NULL,
  `Uhrzeit` time NOT NULL,
  `Notizen` varchar(100) DEFAULT NULL,
  `Ersteller` varchar(20) NOT NULL,
  `Fach` varchar(20) NOT NULL,
  `Art` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `termine`
--

INSERT INTO `termine` (`ID`, `Titel`, `Datum`, `Uhrzeit`, `Notizen`, `Ersteller`, `Fach`, `Art`) VALUES
(1, 'Klausur 1 LF3', '2020-11-04', '09:50:00', '3/4h', 'Heinz', 'LF 3', 'Klausur'),
(2, 'Klausur 3', '2020-10-30', '13:30:00', '7/8h', 'Fiete', 'Deutsch', 'Klausur'),
(3, 'Praktikum ', '2021-04-07', '08:00:00', 'Außerhalb der Schule', 'Karl', '/', 'Praktikum'),
(4, 'Projekt Abgabe', '2020-11-18', '18:30:00', 'Abgabe der ersten Projekte', 'Anne', 'LF 8', 'Abgabe'),
(5, 'Test 4', '2020-10-21', '12:05:00', '5h  Unbewertet(Stoffabfrage)', 'Claudia', 'LF 5', 'Test'),
(6, 'Vortrag Gruppe 1', '2020-11-19', '09:50:00', 'Projekt Vortrag der ersten Gruppe', 'Ben', 'LF 8', 'Vortrag');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `termine`
--
ALTER TABLE `termine`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `termine`
--
ALTER TABLE `termine`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
