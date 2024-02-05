-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 05, 2024 at 06:28 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `narystes`
--

-- --------------------------------------------------------

--
-- Table structure for table `adresas`
--

CREATE TABLE `adresas` (
  `Namo_nr` int(11) NOT NULL,
  `Gatve` varchar(50) NOT NULL,
  `Pasto_kodas` varchar(50) NOT NULL,
  `id_Adresas` int(11) NOT NULL,
  `fk_Klubasid_Klubas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asmuo`
--

CREATE TABLE `asmuo` (
  `Vardas` varchar(50) NOT NULL,
  `Pavarde` varchar(50) NOT NULL,
  `Asmens_id` varchar(50) NOT NULL,
  `Gimimo_data` date NOT NULL,
  `Telefono_nr` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `asmuo`
--

INSERT INTO `asmuo` (`Vardas`, `Pavarde`, `Asmens_id`, `Gimimo_data`, `Telefono_nr`) VALUES
('Lukas', 'Lukelis', '5020012888', '1999-03-31', '862352852'),
('Rytis', 'Ricna', '5020051688', '1994-04-06', '861789902'),
('Rokas', 'Rokelis', '50200516888', '1993-03-19', '861252561'),
('Matas', 'Matonis', '50200547558', '1998-03-11', '861741285');

-- --------------------------------------------------------

--
-- Table structure for table `darbuotojas`
--

CREATE TABLE `darbuotojas` (
  `Vardas` varchar(50) NOT NULL,
  `Pavarde` varchar(50) NOT NULL,
  `Asmens_id` varchar(50) NOT NULL,
  `Gimimo_data` date NOT NULL,
  `Telefono_nr` varchar(50) NOT NULL,
  `id_Darbuotojas` int(11) NOT NULL,
  `fk_Klubasid_Klubas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `klubas`
--

CREATE TABLE `klubas` (
  `Pavadinimas` varchar(50) NOT NULL,
  `Darbo_laikas` varchar(50) NOT NULL,
  `Kontaktas` varchar(50) NOT NULL,
  `id_Klubas` int(11) NOT NULL,
  `fk_SutartisNr` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `naryste`
--

CREATE TABLE `naryste` (
  `Kaina` int(11) NOT NULL,
  `Pavadinimas` varchar(50) NOT NULL,
  `Narystes_pradzia` date NOT NULL,
  `Narystes_pabaiga` date NOT NULL,
  `id_Naryste` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `naryste`
--

INSERT INTO `naryste` (`Kaina`, `Pavadinimas`, `Narystes_pradzia`, `Narystes_pabaiga`, `id_Naryste`) VALUES
(19, 'MINI', '2023-03-08', '2024-04-01', 1),
(25, 'MID', '2023-03-01', '2023-04-01', 2),
(35, 'MAXI', '2023-03-08', '2024-05-08', 3);

-- --------------------------------------------------------

--
-- Table structure for table `papildoma_paslauga`
--

CREATE TABLE `papildoma_paslauga` (
  `Tipas` varchar(50) NOT NULL,
  `Trukme` varchar(50) NOT NULL,
  `Kaina` double NOT NULL,
  `id_Papildoma_Paslauga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `papildoma_paslauga`
--

INSERT INTO `papildoma_paslauga` (`Tipas`, `Trukme`, `Kaina`, `id_Papildoma_Paslauga`) VALUES
('Pirtis', '10 min', 3, 1),
('Baseinas', '1h', 7, 2),
('Boksavimas', '1h', 5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `pratimas`
--

CREATE TABLE `pratimas` (
  `Tipas` varchar(50) NOT NULL,
  `Trukme` varchar(50) NOT NULL,
  `Setu_kiekis` int(11) NOT NULL,
  `Pakartojimu_kiekis` int(11) NOT NULL,
  `id_Pratimas` int(11) NOT NULL,
  `fk_Programaid_Programa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `programa`
--

CREATE TABLE `programa` (
  `Tipas` varchar(50) NOT NULL,
  `Programos_pradzia` date NOT NULL,
  `Programos_pabaiga` date NOT NULL,
  `id_Programa` int(11) NOT NULL,
  `fk_Narysteid_Naryste` int(11) NOT NULL,
  `fk_Darbuotojasid_Darbuotojas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `saskaita`
--

CREATE TABLE `saskaita` (
  `Data` date NOT NULL,
  `Suma` double NOT NULL,
  `Numeris` int(11) NOT NULL,
  `Apmokejimo_data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `saskaita`
--

INSERT INTO `saskaita` (`Data`, `Suma`, `Numeris`, `Apmokejimo_data`) VALUES
('2023-03-08', 19, 178888, '2023-03-08'),
('2023-03-08', 19, 587654, '2023-03-08'),
('2023-03-08', 25, 699855, '2023-03-08'),
('2023-05-09', 35, 5487775, '2023-05-09');

-- --------------------------------------------------------

--
-- Table structure for table `sutartis`
--

CREATE TABLE `sutartis` (
  `Nr` int(11) NOT NULL,
  `Pasirasymo_data` date NOT NULL,
  `Baigia_galioti` date NOT NULL,
  `busena` varchar(20) NOT NULL,
  `fk_Saskaitaid_Saskaita` int(11) NOT NULL,
  `fk_Asmens_id` varchar(50) NOT NULL,
  `fk_Narysteid_Naryste` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sutartis`
--

INSERT INTO `sutartis` (`Nr`, `Pasirasymo_data`, `Baigia_galioti`, `busena`, `fk_Saskaitaid_Saskaita`, `fk_Asmens_id`, `fk_Narysteid_Naryste`) VALUES
(687753, '2022-12-27', '2023-05-27', 'Aktyvi', 178888, '5020012888', 1),
(84413133, '2022-10-27', '2023-12-27', 'Aktvyi', 178888, '50200516888', 1),
(477165132, '2022-10-27', '2023-07-27', 'Aktyvi', 699855, '50200547558', 2),
(786413681, '2023-05-19', '2024-03-22', 'Blokuota', 699855, '50200516888', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tipas`
--

CREATE TABLE `tipas` (
  `Pavadinimas` varchar(50) NOT NULL,
  `id_Tipas` int(11) NOT NULL,
  `fk_Narysteid_Naryste` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `uzsakyta_paslauga`
--

CREATE TABLE `uzsakyta_paslauga` (
  `kiekis` int(11) NOT NULL,
  `Sumine_kaina` double NOT NULL,
  `id_uzsakyta_paslauga` int(11) NOT NULL,
  `fk_Papildoma_Paslaugaid_Papildoma_Paslauga` int(11) NOT NULL,
  `fk_SutartisNr` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uzsakyta_paslauga`
--

INSERT INTO `uzsakyta_paslauga` (`kiekis`, `Sumine_kaina`, `id_uzsakyta_paslauga`, `fk_Papildoma_Paslaugaid_Papildoma_Paslauga`, `fk_SutartisNr`) VALUES
(3, 10, 49, 2, 687753),
(10, 20, 54, 3, 477165132),
(3, 15, 55, 3, 84413133);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adresas`
--
ALTER TABLE `adresas`
  ADD PRIMARY KEY (`id_Adresas`),
  ADD KEY `pastatytas` (`fk_Klubasid_Klubas`);

--
-- Indexes for table `asmuo`
--
ALTER TABLE `asmuo`
  ADD PRIMARY KEY (`Asmens_id`);

--
-- Indexes for table `darbuotojas`
--
ALTER TABLE `darbuotojas`
  ADD PRIMARY KEY (`id_Darbuotojas`),
  ADD KEY `dirba` (`fk_Klubasid_Klubas`);

--
-- Indexes for table `klubas`
--
ALTER TABLE `klubas`
  ADD PRIMARY KEY (`id_Klubas`),
  ADD KEY `sudaro` (`fk_SutartisNr`);

--
-- Indexes for table `naryste`
--
ALTER TABLE `naryste`
  ADD PRIMARY KEY (`id_Naryste`);

--
-- Indexes for table `papildoma_paslauga`
--
ALTER TABLE `papildoma_paslauga`
  ADD PRIMARY KEY (`id_Papildoma_Paslauga`);

--
-- Indexes for table `pratimas`
--
ALTER TABLE `pratimas`
  ADD PRIMARY KEY (`id_Pratimas`),
  ADD KEY `priskirtas` (`fk_Programaid_Programa`);

--
-- Indexes for table `programa`
--
ALTER TABLE `programa`
  ADD PRIMARY KEY (`id_Programa`),
  ADD KEY `Itraukta` (`fk_Narysteid_Naryste`),
  ADD KEY `sukuria` (`fk_Darbuotojasid_Darbuotojas`);

--
-- Indexes for table `saskaita`
--
ALTER TABLE `saskaita`
  ADD PRIMARY KEY (`Numeris`);

--
-- Indexes for table `sutartis`
--
ALTER TABLE `sutartis`
  ADD PRIMARY KEY (`Nr`),
  ADD KEY `israsoma` (`fk_Saskaitaid_Saskaita`),
  ADD KEY `pasiraso` (`fk_Asmens_id`),
  ADD KEY `turi` (`fk_Narysteid_Naryste`);

--
-- Indexes for table `tipas`
--
ALTER TABLE `tipas`
  ADD PRIMARY KEY (`id_Tipas`),
  ADD KEY `Galimas` (`fk_Narysteid_Naryste`);

--
-- Indexes for table `uzsakyta_paslauga`
--
ALTER TABLE `uzsakyta_paslauga`
  ADD PRIMARY KEY (`id_uzsakyta_paslauga`),
  ADD KEY `Ieina` (`fk_Papildoma_Paslaugaid_Papildoma_Paslauga`),
  ADD KEY `priklauso` (`fk_SutartisNr`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `uzsakyta_paslauga`
--
ALTER TABLE `uzsakyta_paslauga`
  MODIFY `id_uzsakyta_paslauga` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adresas`
--
ALTER TABLE `adresas`
  ADD CONSTRAINT `pastatytas` FOREIGN KEY (`fk_Klubasid_Klubas`) REFERENCES `klubas` (`id_Klubas`);

--
-- Constraints for table `darbuotojas`
--
ALTER TABLE `darbuotojas`
  ADD CONSTRAINT `dirba` FOREIGN KEY (`fk_Klubasid_Klubas`) REFERENCES `klubas` (`id_Klubas`);

--
-- Constraints for table `klubas`
--
ALTER TABLE `klubas`
  ADD CONSTRAINT `sudaro` FOREIGN KEY (`fk_SutartisNr`) REFERENCES `sutartis` (`Nr`);

--
-- Constraints for table `pratimas`
--
ALTER TABLE `pratimas`
  ADD CONSTRAINT `priskirtas` FOREIGN KEY (`fk_Programaid_Programa`) REFERENCES `programa` (`id_Programa`);

--
-- Constraints for table `programa`
--
ALTER TABLE `programa`
  ADD CONSTRAINT `Itraukta` FOREIGN KEY (`fk_Narysteid_Naryste`) REFERENCES `naryste` (`id_Naryste`),
  ADD CONSTRAINT `sukuria` FOREIGN KEY (`fk_Darbuotojasid_Darbuotojas`) REFERENCES `darbuotojas` (`id_Darbuotojas`);

--
-- Constraints for table `sutartis`
--
ALTER TABLE `sutartis`
  ADD CONSTRAINT `israsoma` FOREIGN KEY (`fk_Saskaitaid_Saskaita`) REFERENCES `saskaita` (`Numeris`),
  ADD CONSTRAINT `pasiraso` FOREIGN KEY (`fk_Asmens_id`) REFERENCES `asmuo` (`Asmens_id`),
  ADD CONSTRAINT `turi` FOREIGN KEY (`fk_Narysteid_Naryste`) REFERENCES `naryste` (`id_Naryste`);

--
-- Constraints for table `tipas`
--
ALTER TABLE `tipas`
  ADD CONSTRAINT `Galimas` FOREIGN KEY (`fk_Narysteid_Naryste`) REFERENCES `naryste` (`id_Naryste`);

--
-- Constraints for table `uzsakyta_paslauga`
--
ALTER TABLE `uzsakyta_paslauga`
  ADD CONSTRAINT `Ieina` FOREIGN KEY (`fk_Papildoma_Paslaugaid_Papildoma_Paslauga`) REFERENCES `papildoma_paslauga` (`id_Papildoma_Paslauga`),
  ADD CONSTRAINT `priklauso` FOREIGN KEY (`fk_SutartisNr`) REFERENCES `sutartis` (`Nr`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
