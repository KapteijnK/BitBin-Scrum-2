DROP DATABASE IF EXISTS bitbin;
CREATE DATABASE bitbin;

USE bitbin;

CREATE TABLE `posts` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `titel` varchar(255) NOT NULL,
  `inhoud` text COMMENT 'Geplaatste content' NOT NULL,
  `categorie_id` integer,
  `link` varchar(255),
  `gepost_op` timestamp
);

CREATE TABLE `categorien` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `taal` varchar(255) NOT NULL
);

CREATE TABLE `admin` (
  `id` integer AUTO_INCREMENT PRIMARY KEY,
  `wachtwoord` varchar(255) NOT NULL
);

ALTER TABLE `posts` ADD CONSTRAINT `posts_categorien` FOREIGN KEY (`categorie_id`) REFERENCES `categorien` (`id`);

-- Disable foreign key checks for INSERT
SET FOREIGN_KEY_CHECKS = 0;

INSERT INTO `categorien` (`taal`)
VALUES
('PHP'),
('HTML'),
('CSS'),
('SQL'),
('C#'),
('Javscript');

-- Het gehasde wachtwoord is: "reygan_leito"
INSERT INTO `admin` (`wachtwoord`)
VALUES
('$2y$10$GRumJsHCkP7IqdT6s9B3N.WyyulsjdfJz68RkQTza0QncjKt4tjkC');

-- Re-enable foreign key checks
SET FOREIGN_KEY_CHECKS = 1;