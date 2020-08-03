-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2019 at 07:04 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

--SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
--SET AUTOCOMMIT = 0;
--START TRANSACTION;
--SET time_zone = "+00:00";


--/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
--/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
--/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
--/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chess society`
--
--CREATE DATABASE IF NOT EXISTS `chess_society` DEFAULT CHARACTER SET latin1 COLLATE latin1_general_cs;
--USE `chess_society`;

-- --------------------------------------------------------
GRANT ALL PRIVILEGES ON chess_society.*
TO 'username'@'localhost'
IDENTIFIED BY 'password';


--
-- Table structure for table `members`
--
CREATE TABLE Members (
	id INT NOT NULL AUTO_INCREMENT,
	email VARCHAR(255) NOT NULL UNIQUE,
	password VARCHAR(255)NOT NULL,
	fname VARCHAR(255) NOT NULL,
	lname VARCHAR(255) NOT NULL,
	address VARCHAR(255) NOT NULL,
	phone_no CHAR(15) NOT NULL UNIQUE,
	gender INT DEFAULT NULL,
	DoB DATE NOT NULL,
	elo INT NOT NULL DEFAULT 100,
	PRIMARY KEY (id)
);

-- --------------------------------------------------------

--
-- Table structure for table `banned list`
--
CREATE TABLE Banned (
	id INT NOT NULL AUTO_INCREMENT,
	email VARCHAR(255) NOT NULL UNIQUE,
	PRIMARY KEY (id)
);
-- --------------------------------------------------------

--
-- Table structure for table `tournaments`
--
CREATE TABLE Tournaments (
  id INT NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  deadline DATE NOT NULL,
  tournament_date DATE NOT NULL,
  finished BOOL NOT NULL DEFAULT false,
  PRIMARY KEY (id)
);

-- --------------------------------------------------------

--
-- Table structure for table `officers`
--
CREATE TABLE Officers (
  id INT NOT NULL AUTO_INCREMENT,
  member_id INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (member_id) REFERENCES Members(id) ON UPDATE CASCADE ON DELETE CASCADE
);

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--
CREATE TABLE Admins (
  id int NOT NULL AUTO_INCREMENT,
  officer_id int NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (officer_id) REFERENCES Officers(id) ON UPDATE CASCADE ON DELETE RESTRICT
);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--
CREATE TABLE Events (
  id INT NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  expiry_date DATE NOT NULL,
  officer_id INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (officer_id) REFERENCES Officers(id) ON UPDATE CASCADE ON DELETE CASCADE
);

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--
CREATE TABLE Matches (
  id INT NOT NULL AUTO_INCREMENT,
  tournament_id INT NOT NULL,
  member1_id INT,
  member2_id INT,
  outcome INT(1) DEFAULT 0,
  final BOOL NOT NULL DEFAULT false,
  PRIMARY KEY (id),
  FOREIGN KEY (tournament_id) REFERENCES Tournaments(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (member1_id) REFERENCES Members(id) ON UPDATE CASCADE ON DELETE SET NULL,
  FOREIGN KEY (member2_id) REFERENCES Members(id) ON UPDATE CASCADE ON DELETE SET NULL
);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--
CREATE TABLE News (
  id INT NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  description TEXT NOT NULL,
  expiry_date DATE NOT NULL,
  officer_id INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (officer_id) REFERENCES Officers(id) ON UPDATE CASCADE ON DELETE CASCADE
);

-- --------------------------------------------------------

--
-- Table structure for table `tournament members`
--
CREATE TABLE TournamentMembers (
  member_id INT,
  tournament_id INT NOT NULL,
  elo_before INT NOT NULL,
  elo_after INT NOT NULL,
  FOREIGN KEY (member_id) REFERENCES Members(id) ON UPDATE CASCADE ON DELETE SET NULL,
  FOREIGN KEY (tournament_id) REFERENCES Tournaments(id) ON UPDATE CASCADE ON DELETE RESTRICT
);

-- --------------------------------------------------------

--
-- Table structure for table `tournament organiser`
--
CREATE TABLE TournamentOrganisers (
  officer_id int NOT NULL,
  tournament_id int NOT NULL,
  FOREIGN KEY (officer_id) REFERENCES Officers(id) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (tournament_id) REFERENCES Tournaments(id) ON UPDATE CASCADE ON DELETE RESTRICT
);



--COMMIT;

--/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
--/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
--/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
