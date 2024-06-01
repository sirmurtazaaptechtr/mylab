-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 01, 2024 at 02:19 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mylab_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `genders`
--

CREATE TABLE `genders` (
  `gender_id` int(11) NOT NULL,
  `gender` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genders`
--

INSERT INTO `genders` (`gender_id`, `gender`) VALUES
(1, 'male'),
(2, 'female'),
(3, 'other');

-- --------------------------------------------------------

--
-- Table structure for table `logins`
--

CREATE TABLE `logins` (
  `username` varchar(16) NOT NULL,
  `password` varchar(16) NOT NULL,
  `person_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logins`
--

INSERT INTO `logins` (`username`, `password`, `person_id`) VALUES
('admin', 'admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `maritial_statuses`
--

CREATE TABLE `maritial_statuses` (
  `ms_id` int(11) NOT NULL,
  `status` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `maritial_statuses`
--

INSERT INTO `maritial_statuses` (`ms_id`, `status`) VALUES
(1, 'single'),
(2, 'married'),
(3, 'divorced'),
(4, 'widowed');

-- --------------------------------------------------------

--
-- Table structure for table `persons`
--

CREATE TABLE `persons` (
  `person_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `dob` date DEFAULT NULL,
  `age` decimal(10,0) NOT NULL,
  `contact` varchar(16) DEFAULT NULL,
  `gender_id` int(11) DEFAULT NULL,
  `ms_id` int(11) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `persons`
--

INSERT INTO `persons` (`person_id`, `name`, `dob`, `age`, `contact`, `gender_id`, `ms_id`, `role_id`) VALUES
(1, 'Syed Murtaza Hussain', '1984-12-03', '0', '0314-2308332', 1, 2, 1),
(7, 'aaaa', '2024-05-31', '0', '11111', 2, 2, 3),
(8, 'Ali Baba', '2024-05-31', '0', '0312-1234567', 1, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `result_id` int(11) NOT NULL,
  `result_date` date DEFAULT NULL,
  `result_value` varchar(16) DEFAULT NULL,
  `test_id` int(11) DEFAULT NULL,
  `test_date` date DEFAULT NULL,
  `person_id` int(11) DEFAULT NULL,
  `lab_no` varchar(25) DEFAULT NULL,
  `dept_no` varchar(25) DEFAULT NULL,
  `ref_phy` varchar(25) DEFAULT NULL,
  `result_desc` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`result_id`, `result_date`, `result_value`, `test_id`, `test_date`, `person_id`, `lab_no`, `dept_no`, `ref_phy`, `result_desc`) VALUES
(9, '2024-05-31', '1', 1, '2024-05-31', 7, '1', '1', NULL, '111'),
(10, '2024-05-31', '1', 2, '2024-05-31', 7, '1', '1', NULL, '111'),
(11, '2024-05-31', '1', 3, '2024-05-31', 7, '1', '1', NULL, '111'),
(12, '2024-05-31', '1', 4, '2024-05-31', 7, '1', '1', NULL, '111'),
(13, '2024-05-31', '1', 5, '2024-05-31', 7, '1', '1', NULL, '111'),
(14, '2024-05-31', '1', 6, '2024-05-31', 7, '1', '1', NULL, '111'),
(15, '2024-05-31', '1', 7, '2024-05-31', 7, '1', '1', NULL, '111'),
(16, '2024-05-31', '1', 8, '2024-05-31', 7, '1', '1', NULL, '111'),
(17, '2024-05-31', NULL, 9, '2024-05-31', 7, '1', '1', NULL, '111'),
(18, '2024-05-31', '10', 1, '2024-05-31', 8, '1', '1', NULL, 'ABC ++ PQR --'),
(19, '2024-05-31', '12', 2, '2024-05-31', 8, '1', '1', NULL, 'ABC ++ PQR --'),
(20, '2024-05-31', '17.5', 3, '2024-05-31', 8, '1', '1', NULL, 'ABC ++ PQR --'),
(21, '2024-05-31', '19', 4, '2024-05-31', 8, '1', '1', NULL, 'ABC ++ PQR --'),
(22, '2024-05-31', '66.8', 5, '2024-05-31', 8, '1', '1', NULL, 'ABC ++ PQR --'),
(23, '2024-05-31', '123456', 6, '2024-05-31', 8, '1', '1', NULL, 'ABC ++ PQR --'),
(24, '2024-05-31', '321848', 7, '2024-05-31', 8, '1', '1', NULL, 'ABC ++ PQR --'),
(25, '2024-05-31', '21684161613', 8, '2024-05-31', 8, '1', '1', NULL, 'ABC ++ PQR --'),
(26, '2024-05-31', NULL, 9, '2024-05-31', 8, '1', '1', NULL, 'ABC ++ PQR --');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role`) VALUES
(1, 'administrator'),
(2, 'employee'),
(3, 'patient');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `test_id` int(11) NOT NULL,
  `test_name` varchar(64) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`test_id`, `test_name`, `description`) VALUES
(1, 'HB', 'Hemoglobin'),
(2, 'WBC', 'White Blood Cells '),
(3, 'MP', 'Malarial Parasite'),
(4, 'PCV', 'Packed Cell Volume'),
(5, 'MCV', 'Mean Corpuscular Volume'),
(6, 'MCH', 'Mean Corpuscular Hemoglobin'),
(7, 'MCHC', 'Mean Corpuscular Hemoglobin Concentration'),
(8, 'RBC', 'Red Blood Cell'),
(9, 'Platelets', 'Platelets'),
(10, 'Hypochromic', 'Hypochromic'),
(11, 'Macrocytosis', 'Macrocytosis'),
(12, 'Microcytosis', 'Microcytosis'),
(13, 'Anisocytosis', 'Anisocytosis'),
(14, 'Poikilocytosis', 'Poikilocytosis');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `genders`
--
ALTER TABLE `genders`
  ADD PRIMARY KEY (`gender_id`);

--
-- Indexes for table `logins`
--
ALTER TABLE `logins`
  ADD PRIMARY KEY (`username`),
  ADD KEY `person_id` (`person_id`);

--
-- Indexes for table `maritial_statuses`
--
ALTER TABLE `maritial_statuses`
  ADD PRIMARY KEY (`ms_id`);

--
-- Indexes for table `persons`
--
ALTER TABLE `persons`
  ADD PRIMARY KEY (`person_id`),
  ADD KEY `gender_id` (`gender_id`),
  ADD KEY `ms_id` (`ms_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY `test_id` (`test_id`),
  ADD KEY `person_id` (`person_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`test_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `genders`
--
ALTER TABLE `genders`
  MODIFY `gender_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `maritial_statuses`
--
ALTER TABLE `maritial_statuses`
  MODIFY `ms_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `persons`
--
ALTER TABLE `persons`
  MODIFY `person_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `test_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `logins`
--
ALTER TABLE `logins`
  ADD CONSTRAINT `logins_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `persons` (`person_id`);

--
-- Constraints for table `persons`
--
ALTER TABLE `persons`
  ADD CONSTRAINT `persons_ibfk_1` FOREIGN KEY (`gender_id`) REFERENCES `genders` (`gender_id`),
  ADD CONSTRAINT `persons_ibfk_2` FOREIGN KEY (`ms_id`) REFERENCES `maritial_statuses` (`ms_id`),
  ADD CONSTRAINT `persons_ibfk_3` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`test_id`) REFERENCES `tests` (`test_id`),
  ADD CONSTRAINT `results_ibfk_2` FOREIGN KEY (`person_id`) REFERENCES `persons` (`person_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
