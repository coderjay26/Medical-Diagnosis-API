-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2024 at 01:30 AM
-- Server version: 8.0.33
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `medicaldiagnosis`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `createPatient` (IN `p_name` VARCHAR(50), IN `p_gender` VARCHAR(10), IN `p_height` INT, IN `p_weight` INT, IN `p_age` INT, IN `p_userId` INT)   BEGIN
declare p_description varchar(10);
declare patientId int;

select "Patient" into p_description;

select Id into patientId from patients
where Name = p_name and Gender = p_gender and Height = p_height and Weight = p_height and Age = p_age and UserId = p_userId;
if Id is not null then
insert into patients(Name, Description, Gender, Height, Weight, Age, UserId)
values(p_name, p_description, p_gender, p_height, p_weight, p_age, p_userId);
select "success" as message;
else
select "exist" as message;
end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `createUsers` (IN `userEmail` VARCHAR(50), IN `userName` VARCHAR(50), IN `userPassword` VARCHAR(255), IN `userNumber` VARCHAR(15))   BEGIN
    declare userId int;

    select Id into userId from users where Email = userEmail;

    IF userId is null THEN
        insert into users (Email, Name, Password, Phone)
        values (userEmail, userName, SHA2(userPassword, 512), userNumber);
        
        select "success" as message;
	else
		select null as Id, "exist" as message;
	end if;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetPatient` (IN `userIds` INT, IN `patientName` VARCHAR(50))   BEGIN

declare patientId int;

select Id into patientId from patients
where UserId = userIds AND Name = patientName;

IF patientId is not null then
	select * from patients where Id = patientId order by Id asc;
ElSE
	select null as Id, "Patient not found!" as message;
END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetPatients` (IN `userIds` INT)   BEGIN
select * from patients where UserId = userIds order by Id asc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetUsers` ()   BEGIN
SELECT * FROM users order by Id asc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `LoginUser` (IN `userEmail` VARCHAR(50), IN `userPassword` VARCHAR(255))   BEGIN
declare userId int;

select Id INTO userId from users
where Email = userEmail and Password = SHA2(userPassword, 512);
IF userId is not null then
	select * from users where Id = userId;
ELSE
	 SELECT NULL AS Id, 'User not found' AS Message;
END if;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `Id` int NOT NULL,
  `Name` longtext COLLATE utf32_bin NOT NULL,
  `Description` longtext COLLATE utf32_bin,
  `Gender` longtext COLLATE utf32_bin,
  `Height` float DEFAULT NULL,
  `Weight` float DEFAULT NULL,
  `Age` int DEFAULT NULL,
  `UserId` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`Id`, `Name`, `Description`, `Gender`, `Height`, `Weight`, `Age`, `UserId`) VALUES
(1, 'Nonay', 'Patient', 'Female', 155, 55, 22, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` int NOT NULL,
  `Email` varchar(50) COLLATE utf32_bin NOT NULL,
  `Name` varchar(50) COLLATE utf32_bin NOT NULL,
  `Password` varchar(255) COLLATE utf32_bin NOT NULL,
  `Phone` varchar(15) COLLATE utf32_bin NOT NULL,
  `Gender` varchar(10) CHARACTER SET utf32 COLLATE utf32_bin DEFAULT NULL,
  `Height` varchar(5) CHARACTER SET utf32 COLLATE utf32_bin DEFAULT NULL,
  `Weight` varchar(3) CHARACTER SET utf32 COLLATE utf32_bin DEFAULT NULL,
  `Age` varchar(3) CHARACTER SET utf32 COLLATE utf32_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `Email`, `Name`, `Password`, `Phone`, `Gender`, `Height`, `Weight`, `Age`) VALUES
(1, 'jayfuego052620gmail.com', 'Jay Fuego', '3d40c9058c9cc685bbbaff94489421f1e530d6cb93c9b4050d684b1a51b194c85e49843721259c139af77a466c501a29f670670ca4e4cb7f51cfbe62c9f18d5f', '09667004308', NULL, NULL, NULL, NULL),
(2, 'jayfuego9@gmail.com', 'Jay Fueego', '3d40c9058c9cc685bbbaff94489421f1e530d6cb93c9b4050d684b1a51b194c85e49843721259c139af77a466c501a29f670670ca4e4cb7f51cfbe62c9f18d5f', '09667004308', NULL, NULL, NULL, NULL),
(3, 'jayfuego9gmail.com', 'Jay Fueego', '3d40c9058c9cc685bbbaff94489421f1e530d6cb93c9b4050d684b1a51b194c85e49843721259c139af77a466c501a29f670670ca4e4cb7f51cfbe62c9f18d5f', '09667004308', NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
