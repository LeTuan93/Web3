-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:4306:4306
-- Generation Time: Dec 23, 2024 at 06:23 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dangkytinchiptit`
--

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `total_slots` int(11) DEFAULT NULL,
  `registered_slots` int(11) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `address`, `total_slots`, `registered_slots`, `create_at`, `update_at`) VALUES
(1, 'Công ty An ninh mạng Viettel - VCS', 'Tòa nhà The Light, Tố Hữu, Trung Văn, Nam Từ Liêm, Hà Nội, Việt Nam', 300, 101, '2024-12-18 15:13:35', '2024-12-04 15:13:35'),
(2, 'Công ty Cổ phần Công nghệ An ninh không gian mạng Việt Nam - VNCS', 'Tầng 4, Tòa nhà Khâm Thiên, 195 Khâm Thiên, Đống Đa, Hà Nội, Việt Nam', 300, 1, '2024-12-04 15:13:35', '2024-12-04 15:13:35'),
(3, 'Công ty FPT Software (Bộ phận Dịch vụ An toàn Thông tin - SAS)', 'Tòa nhà FPT, Khu Công nghệ cao Hòa Lạc, Km29 Đại lộ Thăng Long, Thạch Thất, Hà Nội, Việt Nam', 500, 2, '2024-12-04 15:17:28', '2024-12-04 15:17:28'),
(4, 'Công ty Cổ phần An ninh mạng Việt Nam – VSEC', 'Tòa nhà N01A – Tầng M – Golden Land Building, 275 Nguyễn Trãi, Hà Nội, Việt Nam', 150, 0, '2024-12-04 16:38:23', '2024-12-04 16:38:23'),
(5, 'Trung tâm An toàn Thông tin – VNPT-IT', '57 Huỳnh Thúc Kháng, Đống Đa, Hà Nội, Việt Nam', 100, 1, NULL, NULL),
(6, 'Công ty Cổ phần Công nghệ Savis', 'Tầng 6, Tòa nhà Savis, 21 Lê Đức Thọ, Mỹ Đình 2, Nam Từ Liêm, Hà Nội, Việt Nam', 50, 50, NULL, NULL),
(7, 'Công ty PwC Việt Nam', 'Địa chỉ: Tầng 16, Tòa nhà Keangnam Landmark 72, Phạm Hùng, Nam Từ Liêm, Hà Nội, Việt Nam', 100, 20, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `grade`
--

CREATE TABLE `grade` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  `gpa_10` float DEFAULT NULL,
  `final_exam_score` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grade`
--

INSERT INTO `grade` (`id`, `user_id`, `subject_id`, `gpa_10`, `final_exam_score`) VALUES
(1, 4, 3, 7.1, 6),
(2, 4, 6, 6, 7.5),
(3, 4, 4, 8.5, 8.5),
(4, 4, 1, 7.9, 8.2),
(5, 4, 2, 7.8, 9),
(6, 4, 5, 8.2, 7.5),
(7, 4, 7, 9.2, 8.5),
(8, 4, 8, 6.2, 8),
(9, 8, 29, 8.2, 10),
(10, 8, 28, 8.2, 8.6),
(11, 8, 27, 9.8, 9.5),
(12, 8, 26, 7.2, 8),
(13, 8, 25, 8.9, 8),
(14, 8, 24, 9.1, 10),
(15, 8, 23, 7.5, 6),
(16, 8, 22, 6.2, 5),
(17, 8, 18, 7.2, 8);

-- --------------------------------------------------------

--
-- Table structure for table `logintoken`
--

CREATE TABLE `logintoken` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `logintoken`
--

INSERT INTO `logintoken` (`id`, `user_id`, `token`, `create_at`) VALUES
(117, 2, '895cb59507cb4f260d2906a09befb1144adc5ee3', '2024-12-13 22:57:32');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE `registration` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`id`, `user_id`, `company_id`, `priority`, `status`, `create_at`) VALUES
(103, 10, 1, 1, 'Chưa duyệt', '2024-12-12 11:39:39'),
(104, 10, 3, 2, 'Chưa duyệt', '2024-12-12 11:39:39'),
(105, 10, 2, 3, 'Chưa duyệt', '2024-12-12 11:39:39'),
(107, 7, 2, 2, 'Đã duyệt', '2024-12-12 11:40:28'),
(109, 6, 2, 1, 'Chưa duyệt', '2024-12-12 11:41:32'),
(110, 6, 3, 2, 'Chưa duyệt', '2024-12-12 11:41:32'),
(111, 6, 4, 3, 'Chưa duyệt', '2024-12-12 11:41:32'),
(112, 5, 5, 1, 'Đã duyệt', '2024-12-12 11:42:01'),
(115, 4, 1, 1, 'Chưa duyệt', '2024-12-12 11:42:24'),
(116, 4, 4, 2, 'Chưa duyệt', '2024-12-12 11:42:24'),
(117, 4, 3, 3, 'Chưa duyệt', '2024-12-12 11:42:24');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int(11) NOT NULL,
  `code` varchar(200) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `credit` int(11) DEFAULT NULL,
  `subject_group` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `code`, `name`, `credit`, `subject_group`) VALUES
(1, 'INT1154', 'Tin học cơ sở 1', 2, 1),
(2, 'BAS1203', 'Giải tích 1', 3, 1),
(3, 'BAS1201', 'Đại số', 3, 1),
(4, 'BAS1150', 'Triết học Mác - Lênin', 3, 1),
(5, 'BAS1106', 'Giáo dục thể chất 1', 2, 1),
(6, 'BAS1105M', 'Giáo dục quốc phòng', 8, 1),
(7, 'INT1155', 'Tin học cơ sở 2', 2, 17),
(8, 'ELE1433', 'Kỹ thuật số', 2, 12),
(9, 'BAS1226', 'Xác suất thống kê', 2, 16),
(10, 'BAS1224', 'Vật lý 1 và thí nghiệm', 4, 6),
(11, 'BAS1204', 'Giải tích 2', 3, 8),
(12, 'BAS1157', 'Tiếng Anh (Course 1)', 4, 21),
(13, 'BAS1151', 'Kinh tế chính trị Mác- Lênin', 3, 2),
(14, 'BAS1107', 'Giáo dục thể chất 2', 2, 23),
(15, 'SKD1102', 'Kỹ năng làm việc nhóm', 1, 8),
(16, 'INT1358', 'Toán rời rạc 1', 3, 10),
(17, 'INT1339', 'Ngôn ngữ lập trình C++', 3, 16),
(18, 'INT13145', 'Kiến trúc máy tính', 3, 2),
(19, 'BAS1227', 'Vật lý 3 và thí nghiệm', 4, 11),
(20, 'BAS1158', 'Tiếng Anh (Course 2)', 4, 32),
(21, 'BAS1152', 'Chủ nghĩa xã hội khoa học', 2, 2),
(22, 'SKD1103', 'Kỹ năng tạo lập Văn bản', 1, 7),
(23, 'INT1359', 'Toán rời rạc 2', 3, 1),
(24, 'INT1336', 'Mạng máy tính', 3, 1),
(25, 'INT1306', 'Cấu trúc dữ liệu và giải thuật', 3, 18),
(26, 'ELE1319', 'Lý thuyết thông tin', 3, 12),
(27, 'BAS1159', 'Tiếng Anh (Course 3)', 4, 54),
(28, 'BAS1122', 'Tư tưởng Hồ Chí Minh', 2, 28),
(29, 'INT1487', 'Hệ điều hành Windows và Linux/Unix', 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `role` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `citizen_identification` varchar(100) NOT NULL,
  `ethnic` varchar(100) DEFAULT NULL,
  `class` varchar(200) DEFAULT NULL,
  `permanent_residence` varchar(200) DEFAULT NULL,
  `specialized` varchar(200) DEFAULT NULL,
  `gpa` float DEFAULT NULL,
  `degree` varchar(200) DEFAULT NULL,
  `training_school` varchar(200) DEFAULT NULL,
  `professional_certifications` text DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `department` varchar(200) DEFAULT NULL,
  `religion` varchar(200) NOT NULL,
  `status` varchar(200) NOT NULL,
  `training_level` varchar(200) NOT NULL,
  `school_year` varchar(200) NOT NULL,
  `rank` varchar(200) DEFAULT NULL,
  `years_of_experience` int(11) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `registration_status` tinyint(1) NOT NULL,
  `password` varchar(200) DEFAULT NULL,
  `forgotToken` varchar(100) DEFAULT NULL,
  `activeToken` varchar(100) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `role`, `email`, `phone`, `gender`, `birth_date`, `citizen_identification`, `ethnic`, `class`, `permanent_residence`, `specialized`, `gpa`, `degree`, `training_school`, `professional_certifications`, `title`, `department`, `religion`, `status`, `training_level`, `school_year`, `rank`, `years_of_experience`, `code`, `avatar`, `registration_status`, `password`, `forgotToken`, `activeToken`, `create_at`, `update_at`) VALUES
(2, 'Lê Anh Tuấn', 'Quản trị viên', 'latuan9303@gmail.com', '0369288612', 'Nam', '2003-03-09', '017203001984', 'Kinh', 'D21CQAT03-B', 'Hà Nội', 'An toàn thông tin', NULL, 'Thạc sĩ', 'Học viện Công Nghệ Bưu Chính Viễn Thông', 'CCNA, AWS Certified', 'Giảng viên', 'An toàn thông tin', '', '', '', '', 'Thạc sĩ', 5, 'B21DCAT205', 'C:/xampp/htdocs/Dang ky tin chi ptit/manager_users/templates/image/1733428563_123.jpg', 0, '$2y$10$6bed6grRcYQ.Kz4QSQLfMu44tKM7JFott8q4tgwyKcqHhhhF7uRCO', 'a10f9db32dd7e37374d026e10823d0a86f7172ea', NULL, '2024-12-12 11:31:45', '2024-12-06 17:00:00'),
(4, 'Bùi Thanh Tùng', 'Người dùng', 'tungthanh131203@gmail.com', '0369288612', 'Nam', '2003-03-09', '', 'Kinh', 'D21CQAT02-B', 'Hòa Bình', 'Công nghệ thông tin', 3.025, NULL, NULL, NULL, NULL, 'Công nghệ thông tin', 'Không', 'Hiện diện', '4,5 năm', '2021-2026', NULL, NULL, 'B21DCAT214', NULL, 1, '$2y$10$/zjRSee5JNrEbuE/5FexNe3Vwg.KjkTCBWziJYnrTDpLmsXh/LLqi', NULL, NULL, '2024-12-04 05:19:31', '2024-12-12 11:42:24'),
(5, 'Lê Thị Mạnh', 'Người dùng', 'manhqq@gmail.com', '0357845258', 'Nữ', NULL, '', 'Mường', 'D21CQQT01-B', 'Thanh hóa', 'Công nghệ thông tin', 3.89, NULL, NULL, NULL, NULL, 'Công nghệ thông tin', 'Không', 'Hiện diện', '4,5 năm', '2021-2026', NULL, NULL, 'B21DCQT123', 'C:/xampp/htdocs/Dang ky tin chi ptit/manager_users/templates/image/1733504269_123.jpg', 1, '$2y$10$UfaEV8Dam7lfdcsS/6WUWupfo27qYfNM5vwNIiXeTqdqs8XwCu27K', NULL, NULL, '2024-12-05 16:54:46', '2024-12-12 11:42:01'),
(6, 'Lê Thành Trung', 'Người dùng', 'latuanchatgpt@gmail.com', '0369288612', 'Nam', NULL, '', 'Kinh', 'D21CQCN01-B', 'Hòa Bình', 'Công nghệ thông tin', 3.23, NULL, NULL, NULL, NULL, 'Công nghệ thông tin', 'Không', 'Hiện diện', '4,5 năm', '2021-2026', NULL, NULL, 'B21DCCN125', NULL, 1, '$2y$10$lJvuXGY/BuRxLBc0qeoQNOgWxSSXcylvRuP.R540GgfkSKoPqK7Ma', NULL, NULL, '2024-12-05 20:50:45', '2024-12-12 11:41:32'),
(7, 'Lê Quý Toàn', 'Người dùng', 'toanlee@gmail.com', '0357845258', 'Nam', '2003-03-03', '081542684584', 'Kinh', 'D21CQCN04-B', 'Thái Bình', 'Công nghệ thông tin', 3.69, NULL, NULL, NULL, NULL, 'Công nghệ thông tin', 'Không', 'Hiện diện', '4,5 năm', '2021-2026', NULL, NULL, 'B21DCCN118', 'C:/xampp/htdocs/Dang ky tin chi ptit/manager_users/templates/image/1733428561_123.jpeg', 1, '$2y$10$9n1hm3ljrhj3ZFW1o1ClROYl8fOtQOeLQIpU/xWAueY7SCqEqfQhO', NULL, NULL, '2024-12-06 18:18:53', '2024-12-12 11:40:28'),
(8, 'Lê Anh Tuấn', 'Người dùng', 'tuanla.b21at205@stu.ptit.edu.vn', '0369288612', 'Nam', NULL, '', 'Kinhh', 'D21CQAT01-B', 'Việt Nam', 'Công nghệ thông tin', 3.3, NULL, NULL, NULL, NULL, 'Công nghệ thông tin', 'Không', 'Hiện diện', '4,5 năm', '2021-2026', NULL, NULL, 'B21DCAT206', 'C:/xampp/htdocs/Dang ky tin chi ptit/manager_users/templates/image/1733504266_123.jpg', 0, '$2y$10$d6lzg3mrQGQ1zMkTr0PsEuQHDAbDfW50j2aDjVZNbF9BV38haN3.i', NULL, NULL, '2024-12-13 19:21:31', NULL),
(10, 'Lương Hà Em Quân', 'Người dùng', 'qlh2404@gmail.com', '0964817758', 'Nữ', NULL, '015304001856', 'Thái', 'D21CQAT01-B', 'Thanh Hóa', 'An toàn thông tin', 2.45, NULL, '', NULL, NULL, 'An toàn thông tin', 'Phật Giáo', 'Hiện diện', '4,5 năm', '2021-2026', NULL, NULL, 'B21DCAT153', 'C:/xampp/htdocs/Dang ky tin chi ptit/manager_users/templates/image/1733544572_z5678715258201_0fb007665edd91e981a873d842e5ef0e.jpg', 1, '$2y$10$y.kY.lgw8KaelbNukhABG.Hou1vPDRBLUpYxpJI3.33GogtOllyNe', '646791cb33acb7a8577e9c9fc1d23bca0a42c8a0', NULL, '2024-12-07 11:09:32', '2024-12-12 11:39:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grade`
--
ALTER TABLE `grade`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `subject_id` (`subject_id`);

--
-- Indexes for table `logintoken`
--
ALTER TABLE `logintoken`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `grade`
--
ALTER TABLE `grade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `logintoken`
--
ALTER TABLE `logintoken`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `grade`
--
ALTER TABLE `grade`
  ADD CONSTRAINT `grade_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `grade_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subject` (`id`);

--
-- Constraints for table `logintoken`
--
ALTER TABLE `logintoken`
  ADD CONSTRAINT `logintoken_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `registration`
--
ALTER TABLE `registration`
  ADD CONSTRAINT `registration_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `registration_ibfk_2` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
