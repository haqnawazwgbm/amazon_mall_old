-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 17, 2017 at 02:14 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `amazon`
--

-- --------------------------------------------------------

--
-- Table structure for table `basic_floors`
--

CREATE TABLE `basic_floors` (
  `floor_id` int(11) NOT NULL,
  `floor_types` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `project_id` int(11) NOT NULL,
  `size_sqft` decimal(20,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `basic_floors`
--

INSERT INTO `basic_floors` (`floor_id`, `floor_types`, `created_at`, `updated_at`, `project_id`, `size_sqft`) VALUES
(6, 'Testing Project', '2017-12-11 09:11:43', '2017-12-10 22:54:15', 1, '300'),
(7, 'First Site', '2017-12-11 09:23:51', '0000-00-00 00:00:00', 1, '500');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `country_code` varchar(2) NOT NULL DEFAULT '',
  `country_name` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `country_code`, `country_name`) VALUES
(1, 'AF', 'Afghanistan'),
(2, 'PK', 'Pakistan'),
(3, 'AE', 'United Arab Emirates'),
(4, 'GB', 'United Kingdom'),
(5, 'US', 'United States');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` int(11) NOT NULL,
  `district_name` varchar(250) NOT NULL,
  `province_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `district_name`, `province_id`) VALUES
(1, 'Attock', 1),
(2, 'Attock', 1),
(3, 'Lodhran', 1),
(4, 'Bahawalnagar', 1),
(5, 'Mandi Bahauddin', 1),
(6, 'Bahawalpur', 1),
(7, 'Mianwali', 1),
(8, 'Bhakkar', 1),
(9, 'Multan', 1),
(10, 'Chakwal', 1),
(11, 'Muzaffargarh', 1),
(12, 'Chiniot', 1),
(13, 'Narowal', 1),
(14, 'Dera Ghazi Khan', 1),
(15, 'Nankana Sahib', 1),
(16, 'Faisalabad', 1),
(17, 'Okara', 1),
(18, 'Pakpattan', 1),
(19, 'Gujranwala', 1),
(20, 'Gujrat', 1),
(21, 'Hafizabad', 1),
(22, 'Rajanpur', 1),
(23, 'Jhang', 1),
(24, 'Rahim Yar Khan', 1),
(25, 'Rawalpindi', 1),
(26, 'Sahiwal', 1),
(27, 'Kasur', 1),
(28, 'Sargodha', 1),
(29, 'Khanewal', 1),
(30, 'Sheikhupura', 1),
(31, 'Khushab', 1),
(32, 'Sialkot', 1),
(33, 'Lahore', 1),
(34, 'Toba Tek Singh', 1),
(35, 'Layyah', 1),
(36, 'Vehari', 1),
(59, 'Badin', 2),
(60, 'Dadu', 2),
(61, 'Ghotki', 2),
(62, 'Hyderabad', 2),
(63, 'Jacobabad', 2),
(64, 'Jamshoro', 2),
(65, 'Karachi', 2),
(66, 'Kashmore', 2),
(67, 'Khairpur', 2),
(68, 'Larkana', 2),
(69, 'Matiari', 2),
(70, 'Mirpurkhas', 2),
(71, 'Naushahro Firoz', 2),
(72, 'Shaheed Benazirabad (Nawab Shah)', 2),
(73, 'Qamber and Shahdad Kot', 2),
(74, 'Sanghar', 2),
(75, 'Shikarpur', 2),
(76, 'Sukkur', 2),
(77, 'Tando Allahyar', 2),
(78, 'Hafizabad', 2),
(79, 'Tando Muhammad Khan', 2),
(80, 'Thatta', 2),
(81, 'Umer Kot', 2),
(82, 'Sujawal', 2),
(83, 'Malir', 2),
(84, 'Korangi', 2),
(85, 'Sujawal', 2),
(86, 'Lower Kohistan', 3),
(87, 'Torghar', 3),
(88, 'Upper Dir', 3),
(89, 'Tank', 3),
(90, 'Swat', 3),
(91, 'Swabi', 3),
(92, 'Shangla', 3),
(93, 'Peshawar', 3),
(94, 'Nowshera', 3),
(95, 'Mardan', 3),
(96, 'Mansehra', 3),
(97, 'Malakand', 3),
(98, 'Lower Dir', 3),
(99, 'Lakki Marwat', 3),
(100, 'Upper Kohistan', 3),
(101, 'Kohat', 3),
(102, 'Haripur', 3),
(103, 'Hangu', 3),
(104, 'Dera Ismail Khan', 3),
(105, 'Chitral', 3),
(106, 'Charsadda', 3),
(107, 'Buner', 3),
(108, 'Batagram', 3),
(109, 'Bannu', 3),
(110, 'Abbottabad', 3);

-- --------------------------------------------------------

--
-- Table structure for table `installments`
--

CREATE TABLE `installments` (
  `installment_id` int(11) NOT NULL,
  `month` varchar(20) NOT NULL,
  `amount` double(20,3) NOT NULL,
  `remaining` double(20,3) NOT NULL,
  `paid` double(20,3) NOT NULL,
  `year` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `sale_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `installments`
--

INSERT INTO `installments` (`installment_id`, `month`, `amount`, `remaining`, `paid`, `year`, `created_at`, `updated_at`, `sale_id`, `status`) VALUES
(1, 'December', 80000.000, 80000.000, 0.000, '2017', '2017-12-17 12:54:30', '0000-00-00 00:00:00', 7, 0),
(2, 'January', 80000.000, 80000.000, 0.000, '2018', '2017-12-17 12:54:30', '0000-00-00 00:00:00', 7, 0),
(3, 'February', 80000.000, 80000.000, 0.000, '2018', '2017-12-17 12:54:30', '0000-00-00 00:00:00', 7, 0),
(4, 'March', 80000.000, 80000.000, 0.000, '2018', '2017-12-17 12:54:30', '0000-00-00 00:00:00', 7, 0),
(5, 'April', 80000.000, 80000.000, 0.000, '2018', '2017-12-17 12:54:30', '0000-00-00 00:00:00', 7, 0),
(6, 'May', 80000.000, 80000.000, 0.000, '2018', '2017-12-17 12:54:30', '0000-00-00 00:00:00', 7, 0),
(7, 'June', 80000.000, 80000.000, 0.000, '2018', '2017-12-17 12:54:30', '0000-00-00 00:00:00', 7, 0),
(8, 'July', 80000.000, 80000.000, 0.000, '2018', '2017-12-17 12:54:30', '0000-00-00 00:00:00', 7, 0),
(9, 'August', 80000.000, 80000.000, 0.000, '2018', '2017-12-17 12:54:30', '0000-00-00 00:00:00', 7, 0),
(10, 'September', 80000.000, 80000.000, 0.000, '2018', '2017-12-17 12:54:30', '0000-00-00 00:00:00', 7, 0),
(11, 'October', 80000.000, 80000.000, 0.000, '2018', '2017-12-17 12:54:30', '0000-00-00 00:00:00', 7, 0),
(12, 'November', 80000.000, 80000.000, 0.000, '2018', '2017-12-17 12:54:30', '0000-00-00 00:00:00', 7, 0);

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `project_id` int(11) NOT NULL,
  `project_name` varchar(250) NOT NULL,
  `project_location` varchar(250) NOT NULL,
  `starting_date` date NOT NULL,
  `expected_end` date NOT NULL,
  `size_sqft` decimal(20,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`project_id`, `project_name`, `project_location`, `starting_date`, `expected_end`, `size_sqft`, `created_at`, `updated_at`) VALUES
(1, 'Amazon', 'Islamabad', '2017-12-02', '2018-03-31', '3000.00', '2017-12-11 08:29:09', '2017-12-11 08:29:09');

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE `provinces` (
  `province_id` int(11) NOT NULL,
  `province_name` varchar(250) NOT NULL,
  `ct_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`province_id`, `province_name`, `ct_id`) VALUES
(1, 'Punjab', 2),
(2, 'Sindh', 2),
(3, 'KP', 2),
(4, 'Balochistan', 2),
(5, 'Gilgit - Baltistan', 2),
(6, 'FATA', 2),
(7, 'Azad Jummu & Kashmir', 2);

-- --------------------------------------------------------

--
-- Table structure for table `relation`
--

CREATE TABLE `relation` (
  `relation_id` int(11) NOT NULL,
  `relationship` varchar(250) NOT NULL,
  `relation_name` varchar(250) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `relation`
--

INSERT INTO `relation` (`relation_id`, `relationship`, `relation_name`, `user_id`, `created_at`) VALUES
(1, 'Brother', 'Amis', 28, '2017-12-14 18:31:15'),
(2, 'Brother', 'Doe John', 29, '2017-12-15 14:12:45');

-- --------------------------------------------------------

--
-- Table structure for table `sale`
--

CREATE TABLE `sale` (
  `sale_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `total_payment` double(20,3) NOT NULL,
  `token_money` double(20,3) NOT NULL,
  `down_payment` double(20,3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `upload_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `years` varchar(20) NOT NULL,
  `added_by` int(11) NOT NULL,
  `floor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sale`
--

INSERT INTO `sale` (`sale_id`, `user_id`, `unit_id`, `total_payment`, `token_money`, `down_payment`, `created_at`, `upload_at`, `years`, `added_by`, `floor_id`) VALUES
(7, 5, 28, 1000000.000, 20000.000, 20000.000, '2017-12-17 12:54:30', '0000-00-00 00:00:00', '1', 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `sales_units`
--

CREATE TABLE `sales_units` (
  `unit_id` int(11) NOT NULL,
  `unit_type` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `floor_id` int(11) NOT NULL,
  `size_sqft` decimal(20,0) NOT NULL,
  `price_sqft` decimal(20,0) NOT NULL,
  `total_price` decimal(20,0) NOT NULL,
  `archi__plans` text NOT NULL,
  `sold` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales_units`
--

INSERT INTO `sales_units` (`unit_id`, `unit_type`, `created_at`, `updated_at`, `floor_id`, `size_sqft`, `price_sqft`, `total_price`, `archi__plans`, `sold`) VALUES
(5, 'Cafeteria', '2017-12-11 15:42:12', '0000-00-00 00:00:00', 6, '100', '200', '1000000', '[{\"orignal\":\"nature.jpg\",\"filename\":\"2017-12-14-11-17-47nature.jpg\",\"url\":\"http:\\/\\/localhost\\/realone\\/\\/assets\\/uploads\\/Sales_Unit\\/Sale_id_5\",\"ext\":\"jpg\",\"isShown\":true,\"isDeleted\":false}]', 1),
(8, 'Shop', '2017-12-11 18:00:19', '0000-00-00 00:00:00', 7, '100', '220', '1200000', '[{\"orignal\":\"ocean.jpg\",\"filename\":\"2017-12-14-11-13-05ocean.jpg\",\"url\":\"http:\\/\\/localhost\\/realone\\/\\/assets\\/uploads\\/Sales_Unit\\/Sale_id_8\",\"ext\":\"jpg\",\"isShown\":true,\"isDeleted\":false},{\"orignal\":\"nature.jpg\",\"filename\":\"2017-12-14-11-13-09nature.jpg\",\"url\":\"http:\\/\\/localhost\\/realone\\/\\/assets\\/uploads\\/Sales_Unit\\/Sale_id_8\",\"ext\":\"jpg\",\"isShown\":true,\"isDeleted\":false}]', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sale_documents`
--

CREATE TABLE `sale_documents` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `document` varchar(50) NOT NULL,
  `file` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `url` varchar(250) NOT NULL,
  `orignal` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sale_documents`
--

INSERT INTO `sale_documents` (`id`, `sale_id`, `document`, `file`, `created_at`, `url`, `orignal`) VALUES
(1, 6, 'Biometric', '2017-12-17-01-46-57Picture1.png', '2017-12-17 12:46:57', 'http://localhost/realone//assets/uploads/SaleUnits/SaleUnit_id6', 'Picture1.png'),
(2, 6, 'CNIC', '2017-12-17-01-47-03Picture1.png', '2017-12-17 12:47:03', 'http://localhost/realone//assets/uploads/SaleUnits/SaleUnit_id6', 'Picture1.png'),
(3, 6, 'Document', '2017-12-17-01-47-08Picture1.png', '2017-12-17 12:47:08', 'http://localhost/realone//assets/uploads/SaleUnits/SaleUnit_id6', 'Picture1.png'),
(4, 7, 'Biometric', '2017-12-17-01-56-01Picture1.png', '2017-12-17 12:56:01', 'http://localhost/realone//assets/uploads/SaleUnits/SaleUnit_id7', 'Picture1.png'),
(5, 7, 'CNIC', '2017-12-17-01-56-10Picture1.png', '2017-12-17 12:56:10', 'http://localhost/realone//assets/uploads/SaleUnits/SaleUnit_id7', 'Picture1.png'),
(6, 7, 'Document', '2017-12-17-01-56-13Picture1.png', '2017-12-17 12:56:13', 'http://localhost/realone//assets/uploads/SaleUnits/SaleUnit_id7', 'Picture1.png');

-- --------------------------------------------------------

--
-- Table structure for table `unit_changes`
--

CREATE TABLE `unit_changes` (
  `unit_change_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `change_in_size` decimal(20,0) NOT NULL,
  `change_in_price` decimal(20,0) NOT NULL,
  `change_in_tprice` decimal(20,0) NOT NULL,
  `authorized_files` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unit_changes`
--

INSERT INTO `unit_changes` (`unit_change_id`, `unit_id`, `change_in_size`, `change_in_price`, `change_in_tprice`, `authorized_files`, `created_at`, `status`) VALUES
(1, 8, '2312', '31221', '123173239028418', '[{\"orignal\":\"Radio Listner in Kalam.jpg\",\"filename\":\"2017-12-14-03-42-02Radio Listner in Kalam.jpg\",\"url\":\"http:\\/\\/localhost\\/realone\\/\\/assets\\/uploads\\/Unit_Authorization_files\\/Unit_Change_id_1\",\"ext\":\"jpg\",\"isShown\":true,\"isDeleted\":false},{\"orignal\":\"youth dans in bannu.JPG\",\"filename\":\"2017-12-14-03-43-05youth dans in bannu.JPG\",\"url\":\"http:\\/\\/localhost\\/realone\\/\\/assets\\/uploads\\/Unit_Authorization_files\\/Unit_Change_id_1\",\"ext\":\"jpg\",\"isShown\":true,\"isDeleted\":false},{\"orignal\":\"Radio Listner in Kalam.jpg\",\"filename\":\"2017-12-14-03-43-24Radio Listner in Kalam.jpg\",\"url\":\"http:\\/\\/localhost\\/realone\\/\\/assets\\/uploads\\/Unit_Authorization_files\\/Unit_Change_id_1\",\"ext\":\"jpg\",\"isShown\":true,\"isDeleted\":false},{\"orignal\":\"Security (2).JPG\",\"filename\":\"2017-12-14-03-43-24Security (2).JPG\",\"url\":\"http:\\/\\/localhost\\/realone\\/\\/assets\\/uploads\\/Unit_Authorization_files\\/Unit_Change_id_1\",\"ext\":\"jpg\",\"isShown\":true,\"isDeleted\":false},{\"orignal\":\"youth dans in bannu.JPG\",\"filename\":\"2017-12-14-03-43-24youth dans in bannu.JPG\",\"url\":\"http:\\/\\/localhost\\/realone\\/\\/assets\\/uploads\\/Unit_Authorization_files\\/Unit_Change_id_1\",\"ext\":\"jpg\",\"isShown\":true,\"isDeleted\":false},{\"orignal\":\"Picture1.png\",\"filename\":\"2017-12-14-04-36-14Picture1.png\",\"url\":\"http:\\/\\/localhost\\/realone\\/\\/assets\\/uploads\\/Unit_Authorization_files\\/Unit_Change_id_1\",\"ext\":\"png\",\"isShown\":true,\"isDeleted\":false}]', '2017-12-11 18:05:43', 0),
(2, 5, '21', '232', '116928', 's', '2017-12-14 10:32:05', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(200) NOT NULL,
  `title` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `country` varchar(50) NOT NULL,
  `province` varchar(50) NOT NULL,
  `district` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `nationality` varchar(50) NOT NULL,
  `phone_login` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email_id` varchar(50) NOT NULL,
  `password` varchar(60) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `token` varchar(60) NOT NULL,
  `porfile_pic` varchar(250) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '0',
  `type` enum('Admin','Agent','User','Accountant') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fullname`, `title`, `address`, `country`, `province`, `district`, `city`, `nationality`, `phone_login`, `phone`, `email_id`, `password`, `created_at`, `updated_at`, `token`, `porfile_pic`, `status`, `type`) VALUES
(28, 'Sima', 'Miss.', 'Peshawar Nora Pata Ye Neshta', '2', '2', '60', 'Dadu', '2', '23978498', '89372948723849', 'sima@nothing.com', '', '2017-12-14 18:31:14', '2017-12-14 18:31:14', '', '', '0', 'User'),
(29, 'John Doe', 'Miss.', 'Address of John Doe', '2', '1', '1', 'Attock', '2', '232343242', '2342342342', 'john@doe.com', '', '2017-12-15 14:12:45', '2017-12-15 14:12:45', '', '', '0', 'User');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `basic_floors`
--
ALTER TABLE `basic_floors`
  ADD PRIMARY KEY (`floor_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `installments`
--
ALTER TABLE `installments`
  ADD PRIMARY KEY (`installment_id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`province_id`);

--
-- Indexes for table `relation`
--
ALTER TABLE `relation`
  ADD PRIMARY KEY (`relation_id`);

--
-- Indexes for table `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`sale_id`);

--
-- Indexes for table `sales_units`
--
ALTER TABLE `sales_units`
  ADD PRIMARY KEY (`unit_id`);

--
-- Indexes for table `sale_documents`
--
ALTER TABLE `sale_documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit_changes`
--
ALTER TABLE `unit_changes`
  ADD PRIMARY KEY (`unit_change_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `basic_floors`
--
ALTER TABLE `basic_floors`
  MODIFY `floor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=246;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `installments`
--
ALTER TABLE `installments`
  MODIFY `installment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `province_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `relation`
--
ALTER TABLE `relation`
  MODIFY `relation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `sale_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sales_units`
--
ALTER TABLE `sales_units`
  MODIFY `unit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sale_documents`
--
ALTER TABLE `sale_documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `unit_changes`
--
ALTER TABLE `unit_changes`
  MODIFY `unit_change_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
