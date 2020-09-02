DROP DATABASE IF EXISTS `RD5_Assignment`;
CREATE DATABASE IF NOT EXISTS `RD5_Assignment` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `RD5_Assignment`;

DROP TABLE IF EXISTS `Members`;
CREATE TABLE `Members`(
    `userID` VARCHAR(20) NOT NULL,
    `userPassword` TEXT NOT NULL,
    `userName` VARCHAR(20) NOT NULL,
    `userEmail` VARCHAR(50) NOT NULL,
    `userPhone` VARCHAR(20) NOT NULL,
    `userStatus` BOOLEAN NOT NULL,
    `creationDate` datetime NOT NULL,
    `changeDate` datetime NOT NULL,
    PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `TransactionRecord`;
CREATE TABLE `TransactionRecord` (
  `recordID` int NOT NULL AUTO_INCREMENT,
  `userID` varchar(20) NOT NULL,
  `transactionAmount` int NOT NULL,
  `transactionDate` datetime NOT NULL,
  `transactionChangeDate` datetime NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`recordID`),
  FOREIGN KEY (`userID`) REFERENCES `Members`(`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `Members`(`userID`, `userPassword`, `userName`, `userEmail`, `userPhone`, `userStatus`, `creationDate`, `changeDate`) VALUES 
('a00001','123456','a01','a01@gmail.com','0911111111',true,NOW(),NOW()),
('a00002','123456','a02','a02@gmail.com','0922222222',true,NOW(),NOW()),
('a00003','123456','a03','a03@gmail.com','0933333333',false,NOW(),NOW()),
('a00004','123456','a04','a04@gmail.com','0944444444',true,NOW(),NOW()),
('a00005','123456','a05','a05@gmail.com','0955555555',true,NOW(),NOW()),
('a00006','123456','a06','a06@gmail.com','0966666666',false,NOW(),NOW());

INSERT INTO `TransactionRecord`(`userID`, `transactionAmount`, `transactionDate`, `transactionChangeDate`, `status`) VALUES 
('a00001',1000,NOW(),NOW(),'success'),
('a00002',1000,NOW(),NOW(),'success'),
('a00001',-900,NOW(),NOW(),'fail'),
('a00001',22000,NOW(),NOW(),'processing'),
('a00003',1000000000,NOW(),NOW(),'fail');