-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2022 at 01:00 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pendaftaran`
--

-- --------------------------------------------------------

--
-- Table structure for table `report_acitivity_temp`
--

CREATE TABLE `report_acitivity_temp` (
  `id` int(11) NOT NULL,
  `eviden` varchar(100) NOT NULL,
  `lokasi` varchar(100) NOT NULL,
  `aktivitas` varchar(100) NOT NULL,
  `chat_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `report_acitivity_temp`
--

INSERT INTO `report_acitivity_temp` (`id`, `eviden`, `lokasi`, `aktivitas`, `chat_id`) VALUES
(37, '', '', '', '405823084');

-- --------------------------------------------------------

--
-- Table structure for table `report_activity`
--

CREATE TABLE `report_activity` (
  `id` int(11) NOT NULL,
  `eviden` varchar(100) NOT NULL,
  `lokasi` varchar(100) NOT NULL,
  `aktivitas` varchar(100) NOT NULL,
  `chat_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `report_activity`
--

INSERT INTO `report_activity` (`id`, `eviden`, `lokasi`, `aktivitas`, `chat_id`) VALUES
(21, 'https://api.telegram.org/file/bot5105549933:AAH4DNhHwU5xzX3CQqssq61N-sWHrfpISe4/photos/file_7.jpg', 'palu', 'palu', '405823084'),
(22, 'https://api.telegram.org/file/bot5105549933:AAH4DNhHwU5xzX3CQqssq61N-sWHrfpISe4/photos/file_7.jpg', 'palu', 'palu', '405823084'),
(23, 'https://api.telegram.org/file/bot5105549933:AAH4DNhHwU5xzX3CQqssq61N-sWHrfpISe4/photos/file_1.jpg', 'palu', 'foto', '405823084'),
(24, 'https://api.telegram.org/file/bot5105549933:AAH4DNhHwU5xzX3CQqssq61N-sWHrfpISe4/photos/file_5.jpg', 'palu', 'palu', '405823084'),
(25, 'https://api.telegram.org/file/bot5105549933:AAH4DNhHwU5xzX3CQqssq61N-sWHrfpISe4/photos/file_5.jpg', 'palu', 'palu', '405823084'),
(26, 'https://api.telegram.org/file/bot5105549933:AAH4DNhHwU5xzX3CQqssq61N-sWHrfpISe4/photos/file_8.jpg', 'palu', 'palu', '405823084'),
(27, 'https://api.telegram.org/file/bot5105549933:AAH4DNhHwU5xzX3CQqssq61N-sWHrfpISe4/photos/file_9.jpg', 'palu', 'palu', '405823084'),
(28, 'https://api.telegram.org/file/bot5105549933:AAH4DNhHwU5xzX3CQqssq61N-sWHrfpISe4/photos/file_9.jpg', 'palu', 'palu', '405823084'),
(29, '', '', '', '-473234728'),
(30, 'https://api.telegram.org/file/bot5105549933:AAH4DNhHwU5xzX3CQqssq61N-sWHrfpISe4/photos/file_9.jpg', 'palu', 'palu', '405823084'),
(31, 'https://api.telegram.org/file/bot5105549933:AAH4DNhHwU5xzX3CQqssq61N-sWHrfpISe4/photos/file_10.jpg', 'palu', 'Monitoring dan evaluasi', '405823084'),
(32, 'https://api.telegram.org/file/bot5105549933:AAH4DNhHwU5xzX3CQqssq61N-sWHrfpISe4/photos/file_10.jpg', 'Kota palu', 'Monitoring dan evaluasi', '405823084'),
(33, 'https://api.telegram.org/file/bot5105549933:AAH4DNhHwU5xzX3CQqssq61N-sWHrfpISe4/photos/file_11.jpg', 'Tanaris Cafee', 'Meeting collabor-action', '405823084'),
(34, 'https://api.telegram.org/file/bot5105549933:AAH4DNhHwU5xzX3CQqssq61N-sWHrfpISe4/photos/file_11.jpg', 'Tanaris cafe', 'Meeting collabor-action', '405823084'),
(35, 'https://api.telegram.org/file/bot5105549933:AAH4DNhHwU5xzX3CQqssq61N-sWHrfpISe4/photos/file_12.jpg', 'Masjid', 'Pengajian', '405823084'),
(36, 'https://api.telegram.org/file/bot5105549933:AAH4DNhHwU5xzX3CQqssq61N-sWHrfpISe4/photos/file_13.jpg', 'Palu', 'Meeting bersama', '405823084');

-- --------------------------------------------------------

--
-- Table structure for table `tpendaftaran`
--

CREATE TABLE `tpendaftaran` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `agama` varchar(100) NOT NULL,
  `chat_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `report_acitivity_temp`
--
ALTER TABLE `report_acitivity_temp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `report_activity`
--
ALTER TABLE `report_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tpendaftaran`
--
ALTER TABLE `tpendaftaran`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `report_acitivity_temp`
--
ALTER TABLE `report_acitivity_temp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tpendaftaran`
--
ALTER TABLE `tpendaftaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
