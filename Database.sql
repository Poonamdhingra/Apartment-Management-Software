

CREATE TABLE `apartments` (
  `ApartmentNo` int(11) NOT NULL,
  `SquareFeet` decimal(10,0) DEFAULT NULL,
  `LeaseAmount` decimal(10,0) DEFAULT NULL,
  `MaintenaceFee` decimal(10,0) DEFAULT NULL,
  `Status` varchar(100) DEFAULT NULL
) ;



INSERT INTO `apartments` (`ApartmentNo`, `SquareFeet`, `LeaseAmount`, `MaintenaceFee`, `Status`) VALUES
(101, '1300', '750', '100', 'Leased'),
(102, '2500', '3000', '250', 'Blocked'),
(250, '1009', '1200', '150', 'Available');


CREATE TABLE `events` (
  `EventId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `Date` date DEFAULT NULL,
  `StartTime` time DEFAULT NULL,
  `EndTime` time DEFAULT NULL,
  `Details` varchar(250) DEFAULT NULL
) ;



INSERT INTO `events` (`EventId`, `UserId`, `Date`, `StartTime`, `EndTime`, `Details`) VALUES
(3, 5, '2016-11-22', '05:38:07', '15:14:21', 'Thanks giving party at the Caesmiers Hall at Nov 22nd. Eateries and free drinks available.'),
(4, 5, '2016-11-27', '02:16:27', '12:40:42', 'TownHall Meeting to discuss the annual budget and planning.');



CREATE TABLE `mails` (
  `MailId` int(11) NOT NULL,
  `UserIdReceiver` int(11) NOT NULL,
  `UserIdSender` int(11) NOT NULL,
  `Date` date DEFAULT NULL,
  `Content` varchar(750) DEFAULT NULL,
  `ReadStatus` varchar(50) DEFAULT NULL
) ;



INSERT INTO `mails` (`MailId`, `UserIdReceiver`, `UserIdSender`, `Date`, `Content`, `ReadStatus`) VALUES
(5, 6, 5, '2016-11-07', 'Hi, Please read the new instructions for Garbage Disposal', 'New'),
(6, 6, 5, '2016-11-01', 'Hi, There are few activities planned for kids on the eve of Xmas.', 'Read');



CREATE TABLE `requests` (
  `RequestId` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `Date` date DEFAULT NULL,
  `RequestType` varchar(50) DEFAULT NULL,
  `Description` varchar(250) DEFAULT NULL,
  `Status` varchar(25) DEFAULT NULL
) ;


INSERT INTO `requests` (`RequestId`, `UserId`, `Date`, `RequestType`, `Description`, `Status`) VALUES
(1, 6, '2016-11-07', 'Power Washing', 'Power wash all the apartments by end of November.', 'Closed'),
(2, 6, '2016-11-01', 'Water Pipe Leakage', 'Please fix the water pipe leakage in the kitchen cabinet.ASAP', 'New');


CREATE TABLE `residents` (
  `UserId` int(11) NOT NULL,
  `DateOfBirth` date DEFAULT NULL,
  `PreviousAddress` varchar(250) DEFAULT NULL,
  `NumPets` int(11) DEFAULT NULL,
  `SSN` varchar(50) DEFAULT NULL,
  `MoveInDate` date DEFAULT NULL,
  `MobileNumber` varchar(50) DEFAULT NULL,
  `SpouseFirstName` varchar(50) DEFAULT NULL,
  `SpouseLastName` varchar(50) DEFAULT NULL,
  `SpouseDateOfBirth` date DEFAULT NULL,
  `SpouseSSN` varchar(50) DEFAULT NULL
) ;



INSERT INTO `residents` (`UserId`, `DateOfBirth`, `PreviousAddress`, `NumPets`, `SSN`, `MoveInDate`, `MobileNumber`, `SpouseFirstName`, `SpouseLastName`, `SpouseDateOfBirth`, `SpouseSSN`) VALUES
(6, '1990-11-07', '2543 Hashwood Lane, Maple Street, IL 60060', 2, '12324234', '2016-07-01', '2234234234', 'Janet', 'Doe', '1990-05-16', '2312123');



CREATE TABLE `transactions` (
  `TransactionID` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `Date` date DEFAULT NULL,
  `Memo` varchar(250) DEFAULT NULL,
  `Amount` decimal(10,0) DEFAULT NULL,
  `Status` varchar(100) DEFAULT NULL
) ;



INSERT INTO `transactions` (`TransactionID`, `UserId`, `Date`, `Memo`, `Amount`, `Status`) VALUES
(1, 6, '2016-11-07', 'Association Fee and Monthly Rent', '1500', 'Pending'),
(2, 6, '2016-11-08', 'Association fees only', '500', 'Completed');


CREATE TABLE `users` (
  `UserId` int(11) NOT NULL,
  `FirstName` varchar(25) DEFAULT NULL,
  `LastName` varchar(25) DEFAULT NULL,
  `Email` varchar(25) DEFAULT NULL,
  `Password` char(60) DEFAULT NULL,
  `Privilege` varchar(15) DEFAULT NULL
) ;



INSERT INTO `users` (`UserId`, `FirstName`, `LastName`, `Email`, `Password`, `Privilege`) VALUES
(5, 'John', 'Doe', 'john@test.com', 'ASHKLX124624234', 'Manager'),
(6, 'Jane', 'Doe', 'jane@test.com', 'XZJUTFB!@#WQA', 'Resident');



CREATE TABLE `usersapartment` (
  `ApartmentNo` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `DateOfLease` date DEFAULT NULL
) ;



INSERT INTO `usersapartment` (`ApartmentNo`, `UserId`, `DateOfLease`) VALUES
(101, 6, '2015-03-29'),
(102, 6, '2016-11-01');


ALTER TABLE `apartments`
  ADD PRIMARY KEY (`ApartmentNo`);


ALTER TABLE `events`
  ADD PRIMARY KEY (`EventId`),
  ADD KEY `UserIdInEvents_FK` (`UserId`);

ALTER TABLE `mails`
  ADD PRIMARY KEY (`MailId`),
  ADD KEY `UserIdReceiver_FK` (`UserIdReceiver`),
  ADD KEY `UserIdSender_FK` (`UserIdSender`);


ALTER TABLE `requests`
  ADD PRIMARY KEY (`RequestId`),
  ADD KEY `UserId` (`UserId`);

ALTER TABLE `residents`
  ADD PRIMARY KEY (`UserId`);


ALTER TABLE `transactions`
  ADD PRIMARY KEY (`TransactionID`),
  ADD KEY `UserIdInTransactions_FK` (`UserId`);


ALTER TABLE `users`
  ADD PRIMARY KEY (`UserId`);
  
ALTER TABLE `usersapartment`
  ADD PRIMARY KEY (`ApartmentNo`,`UserId`),
  ADD KEY `UserIdInUsersApartment_FK` (`UserId`),
  ADD KEY `ApartmentNo` (`ApartmentNo`);


ALTER TABLE `events`
  MODIFY `EventId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `mails`
  MODIFY `MailId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `requests`
  MODIFY `RequestId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `transactions`
  MODIFY `TransactionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `users`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `events`
  ADD CONSTRAINT `UserIdInEvents_FK` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`);

ALTER TABLE `mails`
  ADD CONSTRAINT `UserIdReceiver_FK` FOREIGN KEY (`UserIdReceiver`) REFERENCES `users` (`UserId`),
  ADD CONSTRAINT `UserIdSender_FK` FOREIGN KEY (`UserIdSender`) REFERENCES `users` (`UserId`);

ALTER TABLE `requests`
  ADD CONSTRAINT `UserIdInRequests_FK` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`);


ALTER TABLE `residents`
  ADD CONSTRAINT `UserIdInResidents_FK` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`);

ALTER TABLE `transactions`
  ADD CONSTRAINT `UserIdInTransactions_FK` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`);


ALTER TABLE `usersapartment`
  ADD CONSTRAINT `ApartmentNo_FK` FOREIGN KEY (`ApartmentNo`) REFERENCES `apartments` (`ApartmentNo`),
  ADD CONSTRAINT `UserIdInUsersApartment_FK` FOREIGN KEY (`UserId`) REFERENCES `users` (`UserId`);
  
DROP TABLE `usersapartment`;
  
ALTER TABLE `mails` ADD `Subject` VARCHAR(100) NULL AFTER `Date`;
  
ALTER TABLE `requests` CHANGE Description Description text;

ALTER TABLE `requests` ADD Priority varchar(50), ADD ContactNo varchar(20);

