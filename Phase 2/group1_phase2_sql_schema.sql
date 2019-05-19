-- CREATE/DROP database

DROP DATABASE IF EXISTS `cis197_group1_cert_db`;
SET default_storage_engine=InnoDB;
SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE DATABASE IF NOT EXISTS cis197_group1_cert_db
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_unicode_ci;
USE cis197_group1_cert_db;

-- CREATE and GRANT PRIVILEGES to a user
CREATE USER IF NOT EXISTS 'admin1'@'localhost';
SET PASSWORD FOR 'admin1'@'localhost' = 'admin1';
GRANT ALL PRIVILEGES ON `admin1`.* TO 'admin1'@'localhost' WITH GRANT OPTION;

CREATE USER IF NOT EXISTS 'admin1'@'%';
SET PASSWORD FOR 'admin1'@'%' = 'admin';
GRANT ALL PRIVILEGES ON `admin1`.* TO 'admin1'@'%' WITH GRANT OPTION;

GRANT ALL PRIVILEGES ON `cis197_group1_cert_db`.* TO 'admin1'@'localhost';

FLUSH PRIVILEGES;


-- Table `admin`

CREATE TABLE `admin` (
  `username` varchar(100) NOT NULL,
  `email` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table `cert_member`

CREATE TABLE `cert_member` (
  `username` varchar(100) NOT NULL,
  `phone_number` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table `cost_unit`

CREATE TABLE `cost_unit` (
  `unit_id` int(15) NOT NULL,
  `unit` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table `function`

CREATE TABLE `function` (
  `function_id` int(15) NOT NULL,
  `description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table `resource`

CREATE TABLE `resource` (
  `resource_id` int(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `primary_function_id` int(15) NOT NULL,
  `resource_name` varchar(500) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `capabilities` varchar(1000) DEFAULT NULL,
  `distance` decimal(4,1) DEFAULT NULL,
  `cost` decimal(5,2) NOT NULL,
  `unit_id` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table `resource_provider`

CREATE TABLE `resource_provider` (
  `username` varchar(100) NOT NULL,
  `street_number` int(4) NOT NULL,
  `street` varchar(30) NOT NULL,
  `apt_number` varchar(4) DEFAULT NULL,
  `city` varchar(30) NOT NULL,
  `state` varchar(2) NOT NULL,
  `zip` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table `user`

CREATE TABLE `user` (
  `username` varchar(100) NOT NULL,
  `disp_name` varchar(100) NOT NULL,
  `password` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table `category`

CREATE TABLE `category` (
  `category_id` int(15) NOT NULL,
  `type` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table `incident`

CREATE TABLE `incident` (
  `username` varchar(100) NOT NULL,
  `category_id` int(15) NOT NULL,
  `incident_id` int(15) NOT NULL,
  `date` datetime NOT NULL,
  `description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Indexes for table `admin`
ALTER TABLE `admin`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `admin.email_uk` (`email`);

-- Indexes for table `cert_member`
ALTER TABLE `cert_member`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `cert_member.phone_number_uk` (`phone_number`) USING BTREE;

-- Indexes for table `cost_unit`
ALTER TABLE `cost_unit`
  ADD PRIMARY KEY (`unit_id`);

-- Indexes for table `function`
ALTER TABLE `function`
  ADD PRIMARY KEY (`function_id`);

-- Indexes for table `resource`
ALTER TABLE `resource`
  ADD PRIMARY KEY (`resource_id`),
  ADD KEY `function.function_id-resource.primary_function_id_fk` (`primary_function_id`),
  ADD KEY `user.username-resource.username_fk` (`username`),
  ADD KEY `cost_unit.unit_id-resource.unit_id_fk` (`unit_id`);

-- Indexes for table `resource_provider`
ALTER TABLE `resource_provider`
  ADD PRIMARY KEY (`username`);

-- Indexes for table `user`
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

-- Indexes for table `category`
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

-- Indexes for table `incident`
ALTER TABLE `incident`
  ADD PRIMARY KEY(`incident_id`),
  ADD KEY `user.username-incident.username_fk` (`username`),
  ADD KEY `category.category_id-incident.category_id_fk` (`category_id`);


-- AUTO_INCREMENT for table `cost_unit`
ALTER TABLE `cost_unit` MODIFY unit_id int(15) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT for table `function`
ALTER TABLE `function` MODIFY function_id int(15) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT for table `resource`
ALTER TABLE `resource` MODIFY resource_id int(15) NOT NULL AUTO_INCREMENT;

-- AUTO_INCREMENT for table `category`
ALTER TABLE `category` MODIFY category_id int(15) NOT NULL AUTO_INCREMENT;


-- Constraints for table `admin`
ALTER TABLE `admin`
  ADD CONSTRAINT `user.username-admin.username_fk` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

-- Constraints for table `cert_member`
ALTER TABLE `cert_member`
  ADD CONSTRAINT `user.username-cert_member.username_fk` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

-- Constraints for table `resource`
ALTER TABLE `resource`
  ADD CONSTRAINT `cost_unit.unit_id-resource.unit_id_fk` FOREIGN KEY (`unit_id`) REFERENCES `cost_unit` (`unit_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `function.function_id-resource.primary_function_id_fk` FOREIGN KEY (`primary_function_id`) REFERENCES `function` (`function_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user.username-resource.username_fk` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

-- Constraints for table `resource_provider`
ALTER TABLE `resource_provider`
  ADD CONSTRAINT `user.username-resource_provider.username_fk` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

-- Constraints for table `incident`
ALTER TABLE `incident`
  ADD CONSTRAINT `user.username-incident.username_fk` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `category.category_id-incident.category_id_fk` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

