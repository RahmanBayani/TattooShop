-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2018 at 10:55 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tattoo`
--

-- --------------------------------------------------------

--
-- Table structure for table `accessibility`
--

CREATE TABLE `accessibility` (
  `id` int(11) NOT NULL,
  `name` varchar(25) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `accessibility`
--

INSERT INTO `accessibility` (`id`, `name`) VALUES
(1, 'Users'),
(2, 'Artists'),
(3, 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `ID` int(11) NOT NULL,
  `FirstName` varchar(50) COLLATE utf8_bin NOT NULL,
  `LastName` varchar(50) COLLATE utf8_bin NOT NULL,
  `DateBirth` date NOT NULL,
  `ParentID` int(11) NOT NULL DEFAULT '1',
  `ProcedureID` int(11) NOT NULL,
  `AppointmentDate` date NOT NULL,
  `AppointmentTimeID` int(11) NOT NULL,
  `ArtistID` int(11) NOT NULL,
  `Email` varchar(50) COLLATE utf8_bin NOT NULL,
  `PhoneNumber` varchar(50) COLLATE utf8_bin NOT NULL,
  `Status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`ID`, `FirstName`, `LastName`, `DateBirth`, `ParentID`, `ProcedureID`, `AppointmentDate`, `AppointmentTimeID`, `ArtistID`, `Email`, `PhoneNumber`, `Status`) VALUES
(24, 'Marcelo', 'Garcia', '1978-09-10', 1, 1, '2018-09-06', 1, 7, 'marcelo@gmail.com', '5143358979', 0),
(25, 'Marcelo', 'Garcia', '1978-09-10', 1, 1, '2018-09-07', 1, 8, 'marcelo@gmail.com', '5143358979', 0),
(27, 'Daniel', 'Boy', '2004-02-05', 6, 1, '2018-09-13', 1, 7, 'boy@gmail.com', '1234567899', 0),
(28, 'Daniel', 'Boy', '2004-02-05', 1, 1, '2018-09-13', 2, 7, 'boy@gmail.com', '1234567899', 0),
(29, 'Daniel', 'Boy', '2004-02-05', 1, 1, '2018-09-13', 3, 7, 'boy@gmail.com', '1234567899', 0),
(30, 'Daniel', 'Boy', '2004-02-05', 7, 1, '2018-09-13', 4, 7, 'boy@gmail.com', '1234567899', 0),
(31, 'Daniel', 'Boy', '2004-02-05', 2, 1, '2018-09-13', 5, 7, 'boy@gmail.com', '1234567899', 0),
(32, 'hamid', 'seyedian', '1970-01-01', 1, 1, '2018-09-12', 1, 5, 'hamid@yahoo.com', '12345', 0),
(33, 'Daniel', 'Garcia', '1982-02-05', 1, 2, '2018-09-19', 3, 6, 'daniel@gmail.com', '5141112222', 0);

-- --------------------------------------------------------

--
-- Table structure for table `appointment_times`
--

CREATE TABLE `appointment_times` (
  `ID` int(11) NOT NULL,
  `AppointmentTime` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `appointment_times`
--

INSERT INTO `appointment_times` (`ID`, `AppointmentTime`) VALUES
(1, '09:00:00'),
(2, '11:00:00'),
(3, '13:00:00'),
(4, '15:00:00'),
(5, '17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `ID` int(11) NOT NULL,
  `FirstName` varchar(50) COLLATE utf8_bin NOT NULL,
  `LastName` varchar(50) COLLATE utf8_bin NOT NULL,
  `BirthDate` date NOT NULL,
  `Email` varchar(50) COLLATE utf8_bin NOT NULL,
  `PhoneNumber` varchar(15) COLLATE utf8_bin NOT NULL,
  `Password` varchar(50) COLLATE utf8_bin NOT NULL,
  `LoginTypeID` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`ID`, `FirstName`, `LastName`, `BirthDate`, `Email`, `PhoneNumber`, `Password`, `LoginTypeID`) VALUES
(1, 'Daniel', 'Garcia', '1982-02-05', 'daniel@gmail.com', '5141112222', '202cb962ac59075b964b07152d234b70', 1),
(2, 'Joao', 'Santos', '1948-12-04', 'joao@yahoo.com', '5142223333', '202cb962ac59075b964b07152d234b70', 1),
(3, 'Giovana', 'Ourique', '1986-05-28', 'giovana@gmail.com', '5143334444', '202cb962ac59075b964b07152d234b70', 1),
(4, 'Rodrigo', 'Ruas', '1984-10-22', 'ruas@gmail.com', '5146668888', '202cb962ac59075b964b07152d234b70', 1),
(5, 'Djalba', 'Viana', '1954-05-23', 'viana@gmail.com', '5142225555', '202cb962ac59075b964b07152d234b70', 1),
(6, 'Marcelo', 'Garcia', '1978-09-10', 'marcelo@gmail.com', '5143358979', '202cb962ac59075b964b07152d234b70', 1),
(7, 'Daniel', 'Boy', '2004-02-05', 'boy@gmail.com', '1234567899', '202cb962ac59075b964b07152d234b70', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contactus`
--

CREATE TABLE `contactus` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `email` varchar(50) COLLATE utf8_bin NOT NULL,
  `phone` varchar(50) COLLATE utf8_bin NOT NULL,
  `subject` varchar(50) COLLATE utf8_bin NOT NULL,
  `message` int(250) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `contactus`
--

INSERT INTO `contactus` (`id`, `name`, `email`, `phone`, `subject`, `message`, `status`) VALUES
(1, 'hamid reza', 'ehsan_agha@yahoo.com', '3456234', 'tattoo', 0, 1),
(2, 'hamid reza', 'seyedian@gmail.com', '1236555', 'tattoo', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `ID` int(11) NOT NULL,
  `Question` varchar(50) NOT NULL,
  `Answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`ID`, `Question`, `Answer`) VALUES
(1, 'How should I prepare for my appointment?', 'Make sure you are well rested, have eaten recently, make sure you bathe before you come in and make sure you’re hydrated. You can bring snacks and drinks, anything with some sugar in it. Fruit, energy bars, juice, candy and soda are all helpful while your tattoo gets underway. Have your phone or tablet charged, you can bring headphones and music. Only one person is allowed in the back while you get tattooed, and please do not bring children with you on the day of the appointment. Make sure you bring a valid ID that has a photo and birthdate on it (driver’s license, state-issued non-driver’s license, and passports are all good examples).'),
(2, 'How do I make an appointment?', 'To make an appointment we require a $100 deposit. This assures the date and time of the appointment, and will get deducted from the balance once the tattoo is completed. This can be done in person, or over the phone with a credit card. We recommend you schedule a free consultation to speak to an artist in person if something needs to be drawn up ahead of time. This gives the artist time to draw, and can give you a better idea of what the tattoo will cost. For cover ups or reworking an existing tattoo, a consultation is mandatory.'),
(3, 'Can I just walk in?', ' We do take “walk ins” as long as the tattooers are available. We suggest you call the day you want to walk in just to check how busy the artists are and so we can suggest the best time to come in so the wait time is minimal. If your tattoo needs to be drawn up, we suggest you schedule a consultation with an artist so when you do come in, you aren’t waiting around while the tattoo is drawn up.'),
(4, 'What if I have to reschedule?', 'If you need to cancel or reschedule your appointment, we require 48 hours notice to have your deposit returned or rolled over for a rescheduled appointment. A portion of the deposit may apply as an art fee for cancellations if the artist has put a fair amount of time into the drawing.'),
(5, 'Can you fix or cover up old tattoos?', 'We specialize in cover ups and revitalizing old tattoos. Consultations are mandatory for these so we can see the work in person, and can go over your options for the best result.'),
(6, 'Hand/foot/finger tattoos?', 'Hands and feet are tricky areas to tattoo. The skin exfoliates at a much higher rate than other parts of the body, which means you are shedding skin cells at a much higher rate than the rest of the body. This can result in fading, “bleeding” (when the ink spreads under the skin), or parts of the tattoo disappearing altogether. A lot of tattooers refuse to tattoo these parts of the body for those reasons. We are willing to tattoo hands and feet as long as the client has all the information we can give on what the outcome could be. These are parts of the body where there is no guarantee of how it will heal. You can google image “healed hand tattoo,” “healed finger tattoo,” or “healed foot tattoo” to get an idea of what a tattoo on these areas can look like after healing.');

-- --------------------------------------------------------

--
-- Table structure for table `loginlist`
--

CREATE TABLE `loginlist` (
  `ID` int(11) NOT NULL,
  `LoginType` varchar(50) COLLATE utf8_bin NOT NULL,
  `Level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `loginlist`
--

INSERT INTO `loginlist` (`ID`, `LoginType`, `Level`) VALUES
(1, 'Client', 0),
(2, 'Employee', 1),
(3, 'Admnistrator', 2);

-- --------------------------------------------------------

--
-- Table structure for table `navbar`
--

CREATE TABLE `navbar` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_bin NOT NULL,
  `href` varchar(50) COLLATE utf8_bin NOT NULL,
  `authorisation` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `navbar`
--

INSERT INTO `navbar` (`id`, `name`, `href`, `authorisation`) VALUES
(9, 'FAQ', 'FAQ.php', 1),
(10, 'Contact', 'contactus.php', 1),
(11, 'Appointments', 'calendar.php', 1),
(12, 'Artists', 'artists.php', 1),
(13, 'Your Appointments', 'artist_appointment.php', 2),
(14, 'Admin', 'admin.php', 3),
(15, 'Messages', 'admin_contact.php', 3);

-- --------------------------------------------------------

--
-- Table structure for table `parents`
--

CREATE TABLE `parents` (
  `ID` int(11) NOT NULL,
  `Name` varchar(50) COLLATE utf8_bin NOT NULL,
  `Phone` varchar(50) COLLATE utf8_bin NOT NULL,
  `Email` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `parents`
--

INSERT INTO `parents` (`ID`, `Name`, `Phone`, `Email`) VALUES
(1, 'Client is not under aged', 'No phone', 'No email'),
(2, 'Joao Batista', '514-222-5555', 'joao@gmail.com'),
(3, 'Djalba Viana', '8749652323', 'viana@gmail.com'),
(4, 'Heloisa Moraes', '154 653 2211', 'moraes@gmail.com'),
(5, 'Heloisa Moraes', '1458692211', 'moraes@gmail.com'),
(6, 'Heloisa Moraes', '1472205555', 'moraes@gmail.com'),
(7, 'Heloisa Moraes', '2201458888', 'moraes@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `procedures`
--

CREATE TABLE `procedures` (
  `ID` int(11) NOT NULL,
  `ProcedureName` varchar(50) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `procedures`
--

INSERT INTO `procedures` (`ID`, `ProcedureName`) VALUES
(1, 'Tattoo'),
(2, 'Piercing');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `FirstName` varchar(50) COLLATE utf8_bin NOT NULL,
  `LastName` varchar(50) COLLATE utf8_bin NOT NULL,
  `Email` varchar(50) COLLATE utf8_bin NOT NULL,
  `Password` varchar(100) COLLATE utf8_bin NOT NULL,
  `Photo` varchar(50) COLLATE utf8_bin NOT NULL,
  `bio` text COLLATE utf8_bin NOT NULL,
  `ProcedureID` int(11) NOT NULL,
  `Price` int(11) NOT NULL,
  `LoginTypeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `FirstName`, `LastName`, `Email`, `Password`, `Photo`, `bio`, `ProcedureID`, `Price`, `LoginTypeID`) VALUES
(5, 'Melissa', 'Becker', 'mbecker@gmail.com', '202cb962ac59075b964b07152d234b70', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris \r\nnisi ut aliquip ex ea commodo consequat. ', 1, 100, 2),
(6, 'Jenniffer', 'Doe', 'jdoe@gmail.com', '202cb962ac59075b964b07152d234b70', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris \r\nnisi ut aliquip ex ea commodo consequat.', 1, 100, 2),
(7, 'Brad', 'Smith', 'bsmith@gmail.com', '202cb962ac59075b964b07152d234b70', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris \r\nnisi ut aliquip ex ea commodo consequat.', 1, 100, 2),
(8, 'Alex', 'Sanchez', 'asanchez@gmail.com', '202cb962ac59075b964b07152d234b70', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris \r\nnisi ut aliquip ex ea commodo consequat.', 2, 100, 2),
(10, 'Daniel', 'Garcia dos Santos', 'dgarciasantos@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '', '', 1, 0, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accessibility`
--
ALTER TABLE `accessibility`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ArtistID` (`ArtistID`),
  ADD KEY `ProcedureID` (`ProcedureID`),
  ADD KEY `AppointmentTimeID` (`AppointmentTimeID`);

--
-- Indexes for table `appointment_times`
--
ALTER TABLE `appointment_times`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `contactus`
--
ALTER TABLE `contactus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `loginlist`
--
ALTER TABLE `loginlist`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `navbar`
--
ALTER TABLE `navbar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parents`
--
ALTER TABLE `parents`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `procedures`
--
ALTER TABLE `procedures`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ProcedureID` (`ProcedureID`),
  ADD KEY `LoginTypeID` (`LoginTypeID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accessibility`
--
ALTER TABLE `accessibility`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `appointment_times`
--
ALTER TABLE `appointment_times`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `contactus`
--
ALTER TABLE `contactus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `loginlist`
--
ALTER TABLE `loginlist`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `navbar`
--
ALTER TABLE `navbar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `parents`
--
ALTER TABLE `parents`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `procedures`
--
ALTER TABLE `procedures`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`ArtistID`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`ProcedureID`) REFERENCES `procedures` (`ID`),
  ADD CONSTRAINT `appointments_ibfk_3` FOREIGN KEY (`AppointmentTimeID`) REFERENCES `appointment_times` (`ID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`ProcedureID`) REFERENCES `procedures` (`ID`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`LoginTypeID`) REFERENCES `loginlist` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
