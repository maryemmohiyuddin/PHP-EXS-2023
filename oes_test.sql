-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2023 at 06:01 PM
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
-- Database: `oes_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `pending_students`
--

CREATE TABLE `pending_students` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `subject` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `question` text NOT NULL,
  `answerA` varchar(255) NOT NULL,
  `answerB` varchar(255) NOT NULL,
  `answerC` varchar(255) NOT NULL,
  `answerD` varchar(255) NOT NULL,
  `correctAnswer` varchar(1) NOT NULL,
  `topic_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `subject`, `class`, `question`, `answerA`, `answerB`, `answerC`, `answerD`, `correctAnswer`, `topic_id`) VALUES
(1, 'Maths', '9', 'What is 2 + 2?', '3', '4', '5', '6', 'B', 1),
(2, 'English', '10', 'What is the chemical symbol for water?', 'H2O', 'CO2', 'O2', 'H2SO4', 'A', 4),
(3, 'Computer Science', '11', 'Who was the first President of the United States?', 'John Adams', 'Thomas Jefferson', 'George Washington', 'Benjamin Franklin', 'C', 2),
(4, 'English', '12', 'What is the past tense of \"eat\"?', 'Ate', 'Eaten', 'Eating', 'Ating', 'A', 5),
(5, 'Maths', '9', 'Which continent is known as the \"Land Down Under\"?', 'Europe', 'Africa', 'Asia', 'Australia', 'D', 3),
(7, 'english', '9', 'She _____ to the store yesterday.\r\n', 'will go', ' went', 'goes', 'is going', 'B', 8),
(8, 'english', '9', 'By the time I get home, they _____ dinner.\r\n', 'are having', 'will have had', 'had', 'have', 'B', 8),
(9, 'english', '9', 'I _____ my keys this morning.\r\na) \r\nb) \r\nc) \r\nd) lose', 'am losing', 'will lose', 'lose', 'lost', 'D', 8),
(10, 'english', '9', 'They _____ to the concert tomorrow night.\r\na) \r\nb) \r\nc) going\r\nd) gone', 'goes', 'will go', 'going', 'go', 'B', 8),
(11, 'english', '9', 'She _____ to the beach last summer.\r\na) \r\nb) went\r\nc) going\r\nd) will go', 'goes', 'went', 'going', 'will go', 'B', 8),
(12, 'english', '9', 'By next year, they _____ here for five years.\r\n', 'are', 'have been', 'will be', 'were', 'C', 8),
(13, 'english', '9', 'I _____ to the gym every day.\r\n', 'am going', 'will go', 'went', 'goes', 'A', 8),
(14, 'english', '9', 'She _____ studying for hours.', 'have been', 'is', 'will be', 'are', 'B', 8),
(15, 'english', '9', 'By the time they arrive, I _____ the preparations.\r\n', 'will have finished', 'finished', 'am finishing', 'will finish', 'A', 8),
(16, 'english', '9', 'He _____ his lunch when the phone rang.\r\n', ' is eating', 'was eating ', 'eats', 'will  eat', 'B', 8),
(17, 'english', '10', 'She _____ to the store when it started raining.\r\n', 'goes', 'gone', 'go', 'went', 'D', 4),
(18, 'english', '10', 'My dog is always _____ after a long walk.\r\nA) tiring\r\nB) tired\r\nC) tire\r\nD) tires', 'tiring', 'tired', 'tire', 'tires', 'B', 4),
(19, 'english', '10', 'My dog is always _____ after a long walk.\r\n', 'tiring', 'tired', 'tire', 'tires', 'B', 4),
(20, 'english', '10', 'I haven\'t seen Sarah _____ last week.\r\n', 'since', 'for', 'during', 'at', 'A', 4),
(21, 'english', '10', 'The book on the shelf _____ to me.\r\n', 'belongs', 'belonging', 'belong', 'belonged', 'A', 4),
(22, 'english', '10', '_____ you ever been to Paris?\r\n', 'Have', 'Has', 'Are', 'Is', 'A', 4),
(23, 'english', '10', 'Please pass me _____ salt.\r\n', 'no article needed', 'a', 'an', 'the', 'D', 4),
(24, 'english', '10', 'The car _____ we rented was very comfortable.\r\n', 'that', 'who', 'which', 'whom', 'C', 4),
(25, 'english', '10', 'I\'ll call you _____ I arrive at the airport.\r\n', 'while', 'as soon as', 'before', 'during', 'B', 4),
(26, 'english', '10', 'She\'s the _____ student in the class.\r\n', 'intelligentest', 'intelligenter', 'most intelligent', 'more intelligent', 'C', 4),
(27, 'english', '10', 'I can\'t believe _____ he said.\r\n', 'what', 'that', 'which', 'when', 'A', 4),
(37, 'computer_science', '12', 'Which of the following is NOT a type of network topology?\r\na) ', 'Star ', ' Bus ', ' Linear  ', 'Mesh', 'C', 12),
(38, 'computer_science', '12', 'Which of the following is NOT a commonly used network top-level domain (TLD)?\r\n', '.com ', ' .net', '.gov', '.exe', 'D', 12),
(39, 'computer_science', '12', 'What is the purpose of a firewall in a computer network?\r\n', 'To establish a connection with external networks', 'To increase network speed ', 'To filter and block unauthorized access', 'To provide internet access ', 'C', 12),
(40, 'computer_science', '12', 'In the context of networking, what does DNS stand for?\r\n', 'Dynamic Network Service', 'Domain Name System', 'Digital Network Security', 'Data Network Service', 'B', 12),
(41, 'computer_science', '12', 'Which of the following is a commonly used wireless networking standard?\r\n', 'Ethernet', 'Bluetooth', 'Fiber Optics', 'Coaxial Cable', 'B', 12),
(42, 'computer_science', '12', 'What is the maximum number of IPv4 addresses that can exist?\r\n', '256  ', '65536', '4294967296', '128', 'C', 12),
(43, 'computer_science', '12', 'Which device is used to connect multiple computers in a local area network (LAN)?\r\n', 'Modem ', 'Router', 'Switch ', 'Firewall', 'C', 12),
(44, 'computer_science', '12', 'What protocol is used for sending emails over the Internet?\r\n', 'SMTP', 'HTTP ', ' FTP ', 'TCP', 'A', 12),
(45, 'computer_science', '12', 'Which layer of the OSI model is responsible for routing and forwarding packets?\r\n', 'Data Link Layer ', 'Network Layer', ' Transport Layer ', 'Physical Layer', 'B', 12),
(46, 'computer_science', '12', 'What does TCP stand for in the context of computer networking?\r\n', ' Transmission Control Protocol ', 'Total Control Protocol ', ' Transport Control Protocol ', 'Terminal Control Protocol', 'A', 12);

-- --------------------------------------------------------

--
-- Table structure for table `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `class` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `topic_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `topics`
--

INSERT INTO `topics` (`id`, `class`, `subject`, `topic_name`) VALUES
(1, '9', 'maths', 'Algebra'),
(2, '11', 'computer Science', 'Chemistry'),
(3, '9', 'maths', 'American Revolution'),
(4, '10', 'english', 'Grammar'),
(5, '12', 'english', 'Countries of the World'),
(7, '12', 'computer_science', 'Data Base Management'),
(8, '9', 'english', 'Tenses '),
(9, '10', 'english', 'Grammar'),
(10, '11', 'english', 'Grammar'),
(11, '12', 'english', 'Grammar'),
(12, '12', 'computer_science', 'Computer Networks'),
(13, '12', 'computer_science', 'Data Base Management');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `type` enum('admin','student') NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `type`, `username`, `email`, `full_name`, `date_of_birth`, `subject`, `class`, `password`) VALUES
(2, 'admin', 'admin', NULL, NULL, NULL, NULL, NULL, 'admin'),
(10, 'student', 'nimo jutti2005', 'nimo69@hotmail.com', 'nimo jutti', '2005-01-01', 'computer_science', '9', 'mCHhn'),
(11, 'student', 'Aqsa Majid', 'aqsaparveen03@gmail.com', 'Aqsa Parveen', '1997-10-03', 'computer_science', '12', 'Aqsa,1997'),
(13, 'student', 'Miss Jutt1997', 'missjutt03@gmail.com', 'Miss Jutt', '1997-10-03', 'computer_science', '12', 'l4QtT'),
(14, 'student', 'zeeshna atta1994', 'zeeshanatta@yahoo.com', 'zeeshna atta', '1994-01-31', 'maths', '12', 'KIZyL'),
(20, 'student', 'khan1994', 'ali@gmail.com', 'ali khan', '1994-01-01', 'english', '10', 'zoBnd'),
(21, 'student', 'Jutt1997', 'aqsaparveen03@gmail.com', 'Miss Jutt', '1997-03-10', 'english', '9', 'cv66e'),
(22, 'student', 'veen1997', 'aqsaparveen03@gmail.com', 'Aqsa Parveen', '1997-03-10', 'english', '9', 'LCCf8');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pending_students`
--
ALTER TABLE `pending_students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Indexes for table `topics`
--
ALTER TABLE `topics`
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
-- AUTO_INCREMENT for table `pending_students`
--
ALTER TABLE `pending_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
