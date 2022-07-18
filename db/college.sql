-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 02, 2022 at 07:16 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `college`
--

-- --------------------------------------------------------

--
-- Table structure for table `dept`
--

CREATE TABLE `dept` (
  `did` int(11) NOT NULL,
  `dname` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dept`
--

INSERT INTO `dept` (`did`, `dname`, `name`) VALUES
(1, 'CHE', 'Chemical Engineering'),
(2, 'CE', 'Civil Engineering'),
(3, 'COE', 'Computer Engineering'),
(7, 'MCA', 'Master of Computer Application');

-- --------------------------------------------------------

--
-- Table structure for table `fac`
--

CREATE TABLE `fac` (
  `fid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `did` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fac`
--

INSERT INTO `fac` (`fid`, `name`, `did`) VALUES
(1, 'Milan Murali', 1),
(3, 'Mehta sahehb', 2),
(4, 'himat mehta', 2),
(5, 'Prasant sir', 7);

-- --------------------------------------------------------

--
-- Table structure for table `list`
--

CREATE TABLE `list` (
  `id` int(11) NOT NULL,
  `gno` varchar(100) NOT NULL,
  `ino` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `rfrom` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `img` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `list`
--

INSERT INTO `list` (`id`, `gno`, `ino`, `date`, `rfrom`, `subject`, `img`) VALUES
(3, 'CHE', 'CHE002', '2022-03-17', 'Milan Murali', 'milan murali data dfgvbf', NULL),
(5, 'CE', 'CE003', '2022-04-01', 'Mehta sahehb', 'sdfvsvsvfvcfvsfdvsdfvsdfvsfvfs', NULL),
(6, 'ITS', 'ITS004', '2022-04-01', 'MyGujrat', 'hello Gujrat Lionce', NULL),
(7, 'COE', 'COE005', '2022-04-01', 'manmohak', 'its manmoyhak events from COE department', 'MTCA13205_CC.pdf'),
(9, 'MCA', 'MCA007', '2022-04-02', 'mitisha mam', 'hey its my new mca data', NULL),
(10, 'CHE', 'CHE008', '2022-04-02', 'Milan Murali', 'Font Awesome is the internet\'s icon library and toolkit used by millions of designers, developers, and content creators.\r\n\r\nMade with  and  in Bentonville, Boston, Joplin, Seattle, Tampa, and Vergennes.', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trash`
--

CREATE TABLE `trash` (
  `tid` int(11) NOT NULL,
  `gno` varchar(100) NOT NULL,
  `ino` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `rfrom` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `trash`
--

INSERT INTO `trash` (`tid`, `gno`, `ino`, `date`, `rfrom`, `subject`) VALUES
(8, 'MCA', 'MCA006', '2022-04-02', 'Prasant sir', 'its my today new data');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', 'admin', 1),
(2, 'admin2', 'admin2', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dept`
--
ALTER TABLE `dept`
  ADD PRIMARY KEY (`did`);

--
-- Indexes for table `fac`
--
ALTER TABLE `fac`
  ADD PRIMARY KEY (`fid`);

--
-- Indexes for table `list`
--
ALTER TABLE `list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trash`
--
ALTER TABLE `trash`
  ADD PRIMARY KEY (`tid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dept`
--
ALTER TABLE `dept`
  MODIFY `did` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `fac`
--
ALTER TABLE `fac`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `list`
--
ALTER TABLE `list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
