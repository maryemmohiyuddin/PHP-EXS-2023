SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Create the `pending_students` table
CREATE TABLE `pending_students` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `email` varchar(255) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `subject` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create the `objective` table
CREATE TABLE `objective` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `subject` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `question` text NOT NULL,
  `answerA` varchar(255) NOT NULL,
  `answerB` varchar(255) NOT NULL,
  `answerC` varchar(255) NOT NULL,
  `answerD` varchar(255) NOT NULL,
  `correctAnswer` varchar(1) NOT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `marks` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create the `subjective` table
CREATE TABLE `subjective` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `subject` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `question` text NOT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `marks` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create the `topics` table
CREATE TABLE `topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `class` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `topic_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create the `users` table
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `type` enum('admin','student') NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create the `student_objective_answers` table
CREATE TABLE `student_objective_answers` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer_text` TEXT,
  `submission_time` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `topic_id` int(11) NOT NULL, -- Add topic_id column
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  FOREIGN KEY (`question_id`) REFERENCES `objective` (`id`),
  FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) -- Add foreign key for topic_id
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create the `student_subjective_answers` table
CREATE TABLE `student_subjective_answers` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT,
  `question_id` INT,
  `answer_text` TEXT,
  `submission_time` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `topic_id` INT NOT NULL, -- Add topic_id column
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  FOREIGN KEY (`question_id`) REFERENCES `subjective` (`id`),
  FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`) -- Add foreign key for topic_id
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create the `result` table
CREATE TABLE `result` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT,
  `topic_id` INT,
  `total_marks` INT NOT NULL,
  `obtained_marks` INT NOT NULL,
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert data into the `objective` table
INSERT INTO `objective` (`id`, `subject`, `class`, `question`, `answerA`, `answerB`, `answerC`, `answerD`, `correctAnswer`, `topic_id`) VALUES
(1, 'Maths', '9', 'What is 2 + 2?', '3', '4', '5', '6', 'B', 1),
(2, 'English', '10', 'What is the chemical symbol for water?', 'H2O', 'CO2', 'O2', 'H2SO4', 'A', 4),
(3, 'Computer Science', '11', 'Who was the first President of the United States?', 'John Adams', 'Thomas Jefferson', 'George Washington', 'Benjamin Franklin', 'C', 2),
(4, 'English', '12', 'What is the past tense of \"eat\"?', 'Ate', 'Eaten', 'Eating', 'Ating', 'A', 5),
(5, 'Maths', '9', 'Which continent is known as the \"Land Down Under\"?', 'Europe', 'Africa', 'Asia', 'Australia', 'D', 3);

-- Insert data into the `topics` table
INSERT INTO `topics` (`id`, `class`, `subject`, `topic_name`) VALUES
(1, '9', 'maths', 'Algebra'),
(2, '11', 'computer Science', 'Chemistry'),
(3, '9', 'maths', 'American Revolution'),
(4, '10', 'english', 'Grammar'),
(5, '12', 'english', 'Countries of the World'),
(6, '11', 'maths', 'aaa');

-- Insert data into the `users` table
INSERT INTO `users` (`id`, `type`, `username`, `email`, `full_name`, `date_of_birth`, `subject`, `class`, `password`) VALUES
(2, 'admin', 'admin', NULL, NULL, NULL, NULL, NULL, 'admin'),
(3, 'student', 'student1', 'student12@example.com', 'John Doe', '1995-05-15', 'Maths', '9', 'password1'),
(4, 'student', 'student2', 'student2@example.com', 'Jane Smith', '1996-08-25', 'Maths', '9', 'password2'),
(5, 'student', 'student3', 'student3@example.com', 'Alice Johnson', '1997-11-10', 'Computer Science', '10', 'password3'),
(6, 'student', 'student4', 'student4@example.com', 'Bob Wilson', '1998-03-07', 'English', '11', 'password4'),
(8, 'student', 'zeeshan atta1994', 'zeeshanatta@yahoo.com', 'zeeshan atta', '1994-11-11', 'english', '12', 'bmS1D'),
(9, 'student', 'xeeshan1994', 'zeeshanatta21@gmail.com', 'xeeshan', '1994-11-23', 'maths', '11', 'W0ssY'),
(10, 'student', 'nimo jutti2005', 'nimo69@hotmail.com', 'nimo jutti', '2005-01-01', 'computer_science', '9', 'mCHhn');

-- Insert data into the `subjective` table
INSERT INTO `subjective` (`id`,`subject`, `class`, `question`, `topic_id`) VALUES
(1,'Maths', '9', 'Solve the equation: 2x + 5 = 15', 1),
(2,'English', '10', 'Write a short story about a magical adventure', 4);

-- Insert data into the `result` table
-- (Please adjust the data as needed)

-- Apply necessary ALTER TABLE statements




-- AUTO_INCREMENT for dumped tables
-- AUTO_INCREMENT for table `pending_students`
ALTER TABLE `pending_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

-- AUTO_INCREMENT for table `objective`
ALTER TABLE `objective`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

-- AUTO_INCREMENT for table `topics`
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

-- AUTO_INCREMENT for table `users`
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `subjective`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

-- Constraints for dumped tables
-- Constraints for table `objective`
ALTER TABLE `objective`
  ADD CONSTRAINT `objective_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`);

ALTER TABLE `subjective`
  ADD CONSTRAINT `subjective_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`);

COMMIT;
