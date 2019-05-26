DROP DATABASE IF EXISTS `cis197_group1_cert_db`;
SET default_storage_engine=InnoDB;
SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE DATABASE IF NOT EXISTS cis197_group1_cert_db
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_unicode_ci;
USE cis197_group1_cert_db;

CREATE USER IF NOT EXISTS 'admin1'@'localhost';
SET PASSWORD FOR 'admin1'@'localhost' = '';
GRANT ALL PRIVILEGES ON `admin1`.* TO 'admin1'@'localhost' WITH GRANT OPTION;

CREATE USER IF NOT EXISTS 'admin1'@'%';
SET PASSWORD FOR 'admin1'@'%' = '';
GRANT ALL PRIVILEGES ON `admin1`.* TO 'admin1'@'%' WITH GRANT OPTION;

GRANT ALL PRIVILEGES ON `cis197_group1_cert_db`.* TO 'admin1'@'localhost';

FLUSH PRIVILEGES;


-- Tables
CREATE TABLE user (
  user_id int(15) unsigned NOT NULL AUTO_INCREMENT,
  username varchar(100) NOT NULL,
  disp_name varchar(100) NOT NULL,
  password varchar(500) NOT NULL,
  PRIMARY KEY (user_id),
  UNIQUE KEY (username)
);

CREATE TABLE `admin` (
  admin_id int(15) unsigned NOT NULL AUTO_INCREMENT,
  username varchar(100) NOT NULL,
  email varchar(100) NOT NULL,
  PRIMARY KEY (admin_id),
  UNIQUE KEY (username),
  UNIQUE KEY email (email)
);



CREATE TABLE cert_member (
  member_id int(15) unsigned NOT NULL AUTO_INCREMENT,
  username varchar(100) NOT NULL,
  phone_number varchar(10) NOT NULL,
  PRIMARY KEY (member_id),
  UNIQUE KEY (username),
  UNIQUE KEY phone_number (phone_number)
);

CREATE TABLE resource_provider (
  provider_id int(15) unsigned NOT NULL AUTO_INCREMENT,
  username varchar(100) NOT NULL,
  street_number int(4) NOT NULL,
  street varchar(30) NOT NULL,
  apt_number varchar(4) DEFAULT NULL,
  city varchar(30) NOT NULL,
  state varchar(2) NOT NULL,
  zip int(5) NOT NULL,
  PRIMARY KEY (provider_id),
  UNIQUE KEY (username),
  KEY street (street_number, street, apt_number, city, state, zip) -- input the composit key into 'street'
);



CREATE TABLE cost_unit (
  unit_id int(15) unsigned NOT NULL AUTO_INCREMENT,
  unit varchar(250) NOT NULL,
  PRIMARY KEY (unit_id)
);



CREATE TABLE `function` (
  function_id int(15) unsigned NOT NULL AUTO_INCREMENT,
  description varchar(500) NOT NULL,
  PRIMARY KEY (function_id)
);


CREATE TABLE secondary_function (
  resource_id int(15) unsigned NULL,
  function_id int(15) unsigned NULL,
  KEY (resource_id, function_id)
);


CREATE TABLE resource (
  resource_id int(15) unsigned NOT NULL AUTO_INCREMENT,
  username varchar(100) NOT NULL,
  primary_function_id int(15) unsigned NOT NULL,
  resource_name varchar(500) NOT NULL,
  description varchar(500) DEFAULT NULL,
  capabilities varchar(1000) DEFAULT NULL,
  distance decimal(4,1) DEFAULT NULL,
  cost decimal(5,2) NOT NULL,
  unit_id int(15) unsigned NOT NULL,
  PRIMARY KEY (resource_id),
  KEY primary_function_id (primary_function_id),
  KEY username (username),
  KEY unit_id (unit_id)
);



CREATE TABLE category (
  category_id int(15) unsigned NOT NULL AUTO_INCREMENT,
  type varchar(500) NOT NULL,
  PRIMARY KEY (category_id)
);



CREATE TABLE incident (
  username varchar(100) NOT NULL,
  category_id int(15) unsigned NOT NULL,
  incident_id int(15) unsigned NOT NULL,
  date datetime NOT NULL,
  description varchar(500) NOT NULL,
  PRIMARY KEY(incident_id),
  KEY username (username),
  KEY category_id (category_id)
);


-- Constraints
ALTER TABLE `admin`
  ADD CONSTRAINT user_username_admin_username_fk FOREIGN KEY (username) REFERENCES user (username) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE cert_member
  ADD CONSTRAINT user_username_cert_member_username_fk FOREIGN KEY (username) REFERENCES user (username) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `resource`
  ADD CONSTRAINT cost_unit_unit_id_resource_unit_id_fk FOREIGN KEY (unit_id) REFERENCES cost_unit (unit_id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT function_function_id_resource_primary_function_id_fk FOREIGN KEY (primary_function_id) REFERENCES `function` (function_id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT user_username_resource_username_fk FOREIGN KEY (username) REFERENCES user (username) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE resource_provider
  ADD CONSTRAINT user_username_resource_provider_username_fk FOREIGN KEY (username) REFERENCES user (username) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE incident
  ADD CONSTRAINT user_username_incident_username_fk FOREIGN KEY (username) REFERENCES user (username) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT category_category_id_incident_category_id_fk FOREIGN KEY (category_id) REFERENCES category (category_id) ON DELETE CASCADE ON UPDATE CASCADE;
