CREATE DATABASE test;

USE test;

CREATE TABLE `results` (
  `id` int(11) NOT NULL,
  `index_number` varchar(20) DEFAULT NULL,
  `course_code` varchar(10) DEFAULT NULL,
  `course_name` varchar(100) DEFAULT NULL,
  `grade` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


INSERT INTO `results` (`id`, `index_number`, `course_code`, `course_name`, `grade`) VALUES
(3, '17133284', 'CSSD231', 'English', 'B+'),
(4, '17133284', 'CSSD231', 'English', 'B+'),
(5, '17133284', 'CSSD231', 'English', 'B+'),
(6, '17133284', 'CSSD231', 'English', 'B-');


CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;



INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'lecturer1', 'password123'),
(2, 'lecturer2', 'password456');


ALTER TABLE `results`
  ADD PRIMARY KEY (`id`);



ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

ALTER TABLE `results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;


ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;
