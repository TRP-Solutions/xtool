-- xTool is licensed under the Apache License 2.0 license
-- https://github.com/TRP-Solutions/xtool/blob/main/LICENSE

CREATE DATABASE IF NOT EXISTS `xtool`;
USE `xtool`;

CREATE TABLE `pattern` (
	`id` uuid NOT NULL DEFAULT uuid(),
	`title` varchar(30) NOT NULL,
	`pattern` text NOT NULL,
	`replace` text NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general1400_as_ci;

CREATE TABLE `test` (
	`id` uuid NOT NULL DEFAULT uuid(),
	`pattern_id` uuid NOT NULL,
	`subject` text NOT NULL,
	`passable` tinyint(1) NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`),
	KEY `pattern_id` (`pattern_id`),
	FOREIGN KEY (`pattern_id`) REFERENCES `pattern` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general1400_as_ci;

GRANT DELETE, INSERT, SELECT, UPDATE ON `xtool`.* TO `xtool`@`localhost`;
