-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2017 at 05:08 PM
-- Server version: 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gamesbrand_portal`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(400) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_status` tinyint(1) NOT NULL DEFAULT '4',
  `id_game` int(11) NOT NULL,
  `id_original_asset` int(11) DEFAULT NULL,
  `id_new_asset` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`,`id_game`),
  KEY `FK_Asset_id_Game` (`id_game`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `note`, `author`, `location`, `id_status`, `id_game`, `id_original_asset`, `id_new_asset`) VALUES
(32, 'Banc', 'blabla', 'Alisson', '', 4, 121, NULL, NULL),
(33, 'Table', 'efefz', 'Stern', '', 4, 121, NULL, NULL),
(34, 'Boutique', 'hello world', 'mr robot', '', 4, 121, NULL, NULL),
(35, 'Parapluie', 'check it boy', 'Alisson', '', 4, 121, NULL, NULL),
(36, 'Champagne', '', 'Stern', '', 4, 121, NULL, NULL),
(55, 'no one', 'sisi la famille', 'Bernard', 'assets/3d/test.fbx', 4, 121, NULL, NULL),
(56, 'this one', 'sisi la famille', 'Hneir', 'assets/3d/test.fbx', 4, 121, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `new_assets`
--

DROP TABLE IF EXISTS `new_assets`;
CREATE TABLE IF NOT EXISTS `new_assets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_item` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `original_assets`
--

DROP TABLE IF EXISTS `original_assets`;
CREATE TABLE IF NOT EXISTS `original_assets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_item` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plugins`
--

DROP TABLE IF EXISTS `plugins`;
CREATE TABLE IF NOT EXISTS `plugins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `major_version` smallint(1) UNSIGNED ZEROFILL NOT NULL,
  `minor_version` smallint(2) UNSIGNED ZEROFILL NOT NULL,
  `unity_version_minimum` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_game` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plugins`
--

INSERT INTO `plugins` (`id`, `name`, `note`, `author`, `major_version`, `minor_version`, `unity_version_minimum`, `id_game`) VALUES
(1, 'IRQ', 'Increase Render Quality', 'Jeremy', 5, 02, '5.2p1', 121),
(4, 'IRQ 2', 'Increase Render Quality 2', 'Jeremy', 5, 02, '5.1p1', NULL),
(5, 'IRQ 2', NULL, 'Jeremy', 5, 02, '5.1p1', 121);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_status` tinyint(1) NOT NULL,
  `deadline` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=122 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `client`, `id_status`, `deadline`) VALUES
(121, 'Burger Slasher', 'ITECA', 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rights`
--

DROP TABLE IF EXISTS `rights`;
CREATE TABLE IF NOT EXISTS `rights` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rights_roles`
--

DROP TABLE IF EXISTS `rights_roles`;
CREATE TABLE IF NOT EXISTS `rights_roles` (
  `id` int(11) NOT NULL,
  `right_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `id_role` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_right_role_id_role` (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

DROP TABLE IF EXISTS `state`;
CREATE TABLE IF NOT EXISTS `state` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `first_name`, `last_name`, `email`, `password`, `company`) VALUES
(39, 'Jejedge', 'Jeremy', 'Valero', 'jeremyv@gmail.com', '$2y$10$M7mh536u9nmOmM0KCquOReMUOzY5NNvnEkFxTvg6hLAalcTCjnx7K', 'Equilibre Games'),
(40, 'BigSays', 'Corentin', 'Martin', 'corentinm@equilibregames.com', '$2y$10$PPryiOIqdViionAOhHbfxeaXhe8EEmw286RK4uP5rPrPBaa/5s0ui', 'Equilibre Games');

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

DROP TABLE IF EXISTS `users_roles`;
CREATE TABLE IF NOT EXISTS `users_roles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_user_role_id_role` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_roles`
--

INSERT INTO `users_roles` (`id`, `user_id`, `role_id`) VALUES
(1, 40, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users_tokens`
--

DROP TABLE IF EXISTS `users_tokens`;
CREATE TABLE IF NOT EXISTS `users_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `privatekey` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_tokens`
--

INSERT INTO `users_tokens` (`id`, `user_id`, `token`, `privatekey`) VALUES
(1, 40, 'eyJ0eXBlIjoiSldUIiwiYWxnIjoiSFNIQTI1NiJ9.eyJleHAiOjE0ODkxNjYwMjksImlhdCI6MTQ4OTE2NTQyOSwibmFtZSI6IkNvcmVudGluIE1hcnRpbiIsInJvbGUiOm51bGwsImlkIjoiNDAifQ==.OTU0Nzk4MDRhMTBlNzkxZjc2NjNiMjA1ODA1ODc3YTAxN2FkOTkwMmQ2MDQ3MzI3NjZmODg0ZTA2YWViM2FjMA==', '-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQCsWAR8B2HKX5uq\nCANyQKCkkwqZh5dZShkCB5x4JeJYVuEJafIaiU/DSRsS6ARef7apv/10ZdT/Fvb+\nWjEn7Hmb5mvVwTlqww6BDNcF4X0PyirZt8XR+Kd8MeuhYlLSzhkIEtXeCpR/YURt\npr9AJpg4KWNSzP0/IYtsxDOpMuUismRmv5hmgcHWrKUezNO/m1fruK3CMrVd3LTv\nkvYeQAt7oIzoBREC4LLhVFVJcMXor3e7XuV0LeQEec+T3qNkpGb0yhDzJjWp7gwc\n5T+50PR4QXIpabWLd4ymUDhubl6VJh1SGKp704SP7jpuK0PLNGrhunE332hKKmNj\nOSFWhTULAgMBAAECggEAFsqxFSH4ycWpFWxn4EUxuXIEtdcbqeBFvGH7TFxeOaaL\nri4HqYC9Pqs9XFu4sDKdmodcYndRGscTtQGCfLAmSPrJCgS6ribLlT94dDukyWDI\nF/DYxXLn22HSso4JO/2ri8jJ5cpqZwoa/ZFOu5IfEVZP31RirWWnRaQQ3PBxIwxS\n4NTOW/MR4uN0TztStU7pA9RtDv9Y8fPCEAq4AaKOxpV3Vq4URz/YRXY4YmECFQT5\n33TY0b9SMydebsn/D2Vlezwb05WVlvkTg63DXMDLEIFRbDOG4efFdmGOVlW3tfhk\n3ASi2aNXpTimlrzU0RPLYszBNuFNX6BPunpugk3DyQKBgQDctzCgfoKWLxVy+95n\n1R2uuA+8HS7RcitUUQbiIPLY3guIRc3w9r9IVnIIaYN3988fMzBeZ3FTvXkOjx5t\nT843Lo69umY5EHAS3yWwa6nEk60Biw8x3xWT7bbowQRFbNWquwpn7PYPCPlxnVBf\nbGNTuK47gA3OEPVgCJmSIsI4XwKBgQDH5TUjxsEtMRs4yqe2AajOMLF0N3MC7Q90\nD5A9zcnzhQeJXr1foayjxtwaHKTlFSV+8n6vBpayw08KRDa/vkdglLWySCgDFNH+\nLmFz4SBPbhCWYafmULWFlIDzhi/wHBy7mBq6h9RabL9yFTEne1x+MtIFWMCcaU2b\ncql0a25y1QKBgDHhaKjszmBYlbVdvJ6kqEejK1MtGTaWYbp1cWPLZHakf+C1PdyW\nNxaHCtBh4CdNps57SBQdtpvhNymWKJ81qPoJmJLCPHXrBBkPuznKqxxU74Vowu9X\nZk3/LBYgAPIbrZIfITPpdpZhRdZqYg6etTfnheDGiNgoNvwUFXjUSCZrAoGALoU1\nPMJAqtfG0gy3wy/XrUS/x6Av7/pjoksM8pU17qqC+oFF6T+jAeqBxsHrzjSBqW2d\n9fW+lJPHjUgaxbzut5dkQb1xMmZiCJmarHE0J8ghrB3GCV+3HwNUj1gnR+YC+dWI\nQujhjrnIRDCSY/HdsLD7F6t0B/Kp0Qd6UFHAPpECgYBXwUmZKjJA5cMnjnr5CvZL\n8I609Zaf+h10b77/4Lo0HKW6sD+w4S3TMnpo64DNbn8fehZQXtPJuq0WvW+Gl5a6\nfawRFinFDYf+5kx9QWiDOFTxEj3/AX6oqsqXjc/r3a99RTaTjW1WJ6DesYaY8g8h\nkDfmLPQVy/FoyLuke4O9Hg==\n-----END PRIVATE KEY-----\n'),
(2, 40, 'GGY7FwvnwcXYbXurfleQZJC0plMmiFnU30+qGCH+jMdwSymKn+fjW3EfYknJF/rnVW6kzJJy8GVfhQ9q7WvA7CoRLcu4XxRyH3THZpw5ETfig+GdLKpFSCNZkyWa0ISrjalHJaXggVn8f5ZH5d1RK9TPQy9Ng4FHlj+wmSG06pkRKWp8cS46srKW9ZrfkP//ndzDrZwwUXdEnmzbuj+SiU1IIA8+PyeOwKv0rwNEyvBuWrVVVj0pScbt0+P9ra6TncAatx7Ix+YN5XTj8qXviPvayXCjEyXkL5vVYdxMhi4S9nhON8jGAaAdB60mxHwSROs9dbBIu2If2AoMpuH0ow==', '-----BEGIN PRIVATE KEY-----\nMIIEvwIBADANBgkqhkiG9w0BAQEFAASCBKkwggSlAgEAAoIBAQDF4QOyj97121s9\ni20Z+royb8fpJJz9ZrERTnIa/uGQS0zI4/G3ZS4lYtbxHx+kHUEYqVuwgLG/isIF\naSIJmd5wqtVJKFw65hvDDHQ0Uj9UX2Ph6fWbsrlvZCwwB9VgqvF3BnsHJyGDJayK\nPzsdVAGH8muo32wDymWOCTUxNyS3MM2MNNTNGpPyxgbznmDL9Ne9fT/yNg/eaXq0\nMQMYRmcSrvHi978fHAf3q9a/CU3HWWmdzxiHK9eSNw+1yeUz3UdV7p0CPvN1LaxY\nc9i5jekK8LDDDqKJ8I1FuNpASPBMXkt2P3t6GXhc4dnDT/GXmqAttC7unvWIu3Xt\nvuf+FAFlAgMBAAECggEAF/xWfmaCGDsmrCciamvB9ismiFQv02eHPxnLKwqKPPtj\nq1Y2DoztMwrwEvo606HYKi0dOB/ha95d9lnwDkngdLfAcsW5qEoMQ3BXBaCSnJ+T\nc+bwJpdbcu0pjgjlDHqsGklm0E8l+MewSnGvsLZmGRyBgE7UwQDfnn/vOq/8e1fw\nZUGjfSOvMSBzPfcJKTQai60/7R07vLhXCPQLtgPV+piv+fkL633FRDk+3jB/zSk6\nOHPEdGZAPg/+Ci2EQ+rKH4UAwRtkq91OVZK3eP0U+Dh+5qTslNVtlsuHGzt+9W/z\nV2pArtEcV87gyNzE6NEQg2Nvn4NfalwgLRZ2FX47AQKBgQDv+f+Ma6Ycbnug1mq2\nsMzRGXn+I/9RnNe0hh7/HM1OqOT7v0l1nrj/Vn0DYKfEuJn7NH1CC06uuWujPF2P\n+hcjqhETZ8Cxy5hTxcjzYWRNC1lN6hRngE/2cF4/YlUNxJT0FGiauw+Qoqw7oNfz\nICBvfaOY892P21Vh06MuRq6OnQKBgQDTF211yy52VJu5b6A6eA3d6iRl0m4kzKcN\nCNjj8rjm9xvcRe+UYF1WbB+D+6mHEhDq4H2BqSZ7+o85Geu9EyI9Hp3Z13WQDxg9\naSCMzEkgmM8ZqKUNF3vnIeLLHc3qwAXme/SFtO0v4hC7iGFhBp/JbCKI/oam+ZhE\nybeYVQifaQKBgQDi0BD+sUghGzNyAvZ9kYEkKMYqs+8/PdSKZTGqwZgyvmMepd9S\nciA8BYzGwnYO8sNmsGerInDNp6bac9WinSd9p+HXy3pPETT6CLgzgFuCjjVr9NAw\nOxBYxj/t/IyTJLf8McXkaOT/OSE8gntY6YZ+meskR2mj7BQ5EATtWhTl6QKBgQCN\nG08He9++KAbE6bKBAzm5y0ezbPxFyywsEWryzZD+i9bq4zEozVX3bGWQ04zahqAa\nciBTqV/ZZn+RGxuzk3PCyZGZSmcC+qQogPrKQ9DqYlumek6Ctt0Tf1pcjrrUnrIT\nBW9KZcxbwtGOmrcFpejwO0HGs+YM/jHkYbdBtC4EaQKBgQCNO107PUAfK2CSBkNu\npXVRCI2/C1RowTXQQmGzWmS0OLnIPnfQ85HEqX77ScBwUIpfk0cRfG7LQ2V8lfg+\nFvCZ4ri98lEE+juaUt/jdYZn5i/tezM5PtzYOhBcVFOAIk+LFd2IxJKjy9dacGXL\n3kvFAqNQweoFhAz6HW/SqNf4AA==\n-----END PRIVATE KEY-----\n'),
(3, 40, 'wzS7cj2i5KGNZhtDr2rqpj0POH/AQpCrT30MeIpyW1mvOf7bgJTAWBYC0V7DwN6We1nRwVVE4s03CSTRS5oK3+x2TfcZZ+YTnG8zJi8YNUxU4LwwdIj+rovfYKibu9vEYMl9kANAzZRQAUmp1VmF+sw997hpntsRjBAGqNElUE/RTS6NRNqOY+IvokwTAtQ1wJLyGRNaT/JLlQhNEmLxMkYFjfVPxsZ6hugVeOe0bMWjHhU1jDdksan0lbdFYd0K+0i1uGFe6mJC6gsXKzZGUsUPiN6sVia7X+sk4nVPiUbGL9LNHiTpPHQobUO7CBM7YjJhCyE7ze71E0lt2+PHzQ==', '-----BEGIN PRIVATE KEY-----\nMIIEvwIBADANBgkqhkiG9w0BAQEFAASCBKkwggSlAgEAAoIBAQDujMnlO2gcfEYB\n8EOsbUdonWzU1HiP5ukurkuJqJAmRRsDLNhqfOpC+cFGiqOg+Q1On4VtWUH36V9m\npl9fGa93TblMWJKd9PoNxMs7JOgtPHtzrm/6hTHNidNSAOF21KjKUTv6sEcoqMcC\nvYsWEiwcO0oqpK2j50uczbtcahr56mKsySnDTCiCFs+4KtPCwPPnSyh+tpWfOUq2\n5tN/prcr2EyVJ0lg/oyBEHmX4AwbqG7tpMFHOOFBfqNREBzAom7ICr1qFyekvyzc\ni1VNSKzKgpwm9OuCrMoSzKL6vhZtE8WXXsNt8cunvFdi5bC6LjrwhAgQerMjul+j\n8SBtjY6pAgMBAAECggEBAM1ak37rag+Dh7ypeYhYtm0/f+2jTnoKfNf7oPlLC3R2\nbu+HznG1QPEREanJNV0gqKzzNChS+zAQTVkPhfBXKy7X0NkBMo4Z0pzBuXYbqmcu\nttN56dnOiXX33Nut+GmUXg10at6+mzNMP62DP9VrJV/URl95TiVXukas8Ep46OoT\nit8umZdckyvHclG5lzZ49O930PHyh5RaXs0NbJe4YHznoDvWCtINqEjRTWZOG8Og\nGPzdZr10ydcOmEtW1ePsxfsGTocOYXdt3rF7xXXLiprUh9tt7OcUrWduFiHYx/QI\nqbwRFABFpBC+n/16IKTMb3Ge295fs7+i4TGu9+Y0VdUCgYEA/p4TwGjeqS5z7ybL\n3qvYCiMzkYzUMcitqATQIhArtucm1g8BKylqS8+uR+TMKe9eLAXaPDk0tjbXGVOV\nwi70vHT21+84yayQei44uUhcr5tZrjHHP3H7XfG3qcKNZMP/12G2p1h7jkV4BWJa\n+V1Sx7CnTnERvWWhy9ZiMcFATh8CgYEA79hgmXvxJT5u/3kSgMMk6+yJiXXHGk+J\njCoTkFGyD1BZkqREvCwBhs+WhW4JAabdr7yBOZzTtsBvUhPhMsZpdJhrrdehyrAI\nTMcPTrRQsOZ4h7vlb5nj9wagEVivRI7stUy8aABhskRkeH+9jQbh2N/KORDW3ZP+\nMRaugKg+ejcCgYEAoCTEv4w2H6q7+HsqVw82fonNcYpmHDngH4GHdyU8mXmhj5k4\nXvFZjf093LInR2jqjj3QGXjRkpnDiIZt9wiZnb7jUsV/rjj/VhmkS8UbpsfLDCj6\n7Qi/1UKnBfr7+5jbXZhzzaV1cPJ4nspR9e2gl0CgulGbmshFj3Nzp1+pFnkCgYEA\nvkVixQBNWuV/uw46fonRRZR9u94CmL3Weap7oLce0gVFOg81NC6Y+3C9kZascHIH\nVj3uKl1em5Fn/q4krlo3GLc+XUg+YwRpYTddzms/xEbiAZQvPOzRq4vG+lvnlzTn\nViDNKph66KhXKDz2i+WUz68hx0mzm06njhvXTduqzNsCgYAz7mtmic9tcQFWJQcV\nd8FI7MUsUGXjf18lopu/vD2iCBlXzDwrfg7sLEkbFOT0ATc0ECPkjd8cFvFa3xLp\np2I35wCu0AkUz8mNvb8vg67rnpMjIIMe4bKAObx63FTISHrSozTjeF/ErES3b378\nJTG8+6RXSPT7w8qo4Dw773TNhQ==\n-----END PRIVATE KEY-----\n'),
(4, 40, 'UzzhFzx+fIbR6I8oMH3FdfpJWn6PSbyyc2ycwOHhOzNqhdB1FcJDQdotbWcZq7O+SvMQIvR0sBcbTag5q2bDsDM00frzcrR6OsDYRIraH8X2k+fq2Me4c8d0GgEIF9m3CZKqWZ5TK5hjrB7NDnTDGOuLKQ7uhb/ExLHG4iFfJ8Wmpx4KAvPXXtoUpvGlOwHsqWFjSHABYvtnn5P23v96UFKs61KH2u8JSvL1xA63Uf+kIfn8+bAqDhFsC7vTK+PVNg7f/x60wSaT7z0w1PaPM9h+QOAFGHKizkcTYYjL1zuuLow2YNR9/q2P9qNYxU7+GDFzkpu4lT3uR96Oz1Sb1g==', '-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCqhFtSMb92CE/1\nDwXTz7RI05tHJ4yvQb5aZjJo10GRRRoaFK6Mj97kT+QRiqqh5qsG06JRW5cvTeRF\nsckyBs79WIJH5Ra+5Azno5X3LORBkXs3UzjNMtpOREwjFoTptKJjWjY1+0PW4EoZ\n7H684Cyubzi+vrgDsUDw30d9vkzPVh22yvACCA3Y2TH/Imv9jPmlfTeY1HlKrFdG\nesaGb8kRDIm99I8lWIOA+sSxXLOiZEaa9fffP8Gknur97K8Z3Y+rwqJ19/1yWfpD\nD2QEDkpvnvYkr3KqPlAKvObbiz5r/et6jIiUpOVhuwLTNGcz3hEJ9VT8Yi0820fM\nbHVgerfHAgMBAAECggEAeYQ5UCoDt6nU0V8TWA78+6lRTzPwHjVL4kBSTESahVwp\nbcyvV5xvy2Tjs1yOnTI1T3gihLgw1ZU8yC4ao3wWppUcwv+PZho+2BTMGonzYIa8\nuICmShWjXYNuftLdhW8lCoiPeYjGn6rXJAJVj2Rycxzv438mw/rdvMphuEqVkmsy\ni0sPS6VbhWhL48afAjpR/piO51J+ACESFqLTzLLdeQ16wWPsViXimVXRwHrcxqVp\nJWEpS8e9+1lVdTEfoZ8QO/LqD3zJVpnsxqpFjrQxsmtmHjU4NcKWgpmSQCZGjDDH\nwRkG29KPkbYk4HJis4M6EAXx7ILQx7BOknPjm4rYgQKBgQDUw5z99Mt2QQE0wsbH\n8FRU0XdGtWjhFg8CtPjrSF7EYeapxwfRdoHQhufZ0RKi51jSdsXfgOsHED4w1zcp\n1KS/LyueiBsfrUwwCRio0t4QJFRSeVnaiFp06TBEon9mO4kAoHJHodQUgrhlbRbW\ntbBTjF3MSMHnEr09et4IFy91PQKBgQDNKvh6NwtwrrZ67udr39QddM86pVH05DKV\n84fDTXcib/Fom/xdPnstw01afD2gdvoAlGOVRZfxM1cTWfptZo45qvd0LHGln1MO\nMRE82mX8hCNNaAFdqcSRK6Jx2J2nrU2bCJR3NYE1WnZYKp09fsKVIVSFATc5Chm1\naJu5agPZUwKBgQC9EW9rBaPgW/e0aPm4Jsrp7JHv1blze+Su5R7mBhOgs9cEPAeo\njYTiR1+04eOLu8XkkQNZj/hK+JYrVLSCiaI0+rfqUsy3o4o2jX7KV0haU85S09+T\nIOQxTB9GfphzwqgGVI35Ncd+yoMOLpjDCAW+2Ndpd6ZHrxFXlt3DlsbniQKBgGXN\nh6PlAkk0eBmBx9UQKElBd75K3+LbBHrBb0EqhA3Ta/8TP2LpKOfpO83FTjL8Nkrp\nVoxwDtfBONjCUe/M7o+Q1N6RWwbqiqTFFh+S4v4sdvPmwp6+KWo7M4y4Bmp4JMTj\nuf94zhcyPvy6kHE+H8Et26lvk/46k80fDf4vq58/AoGAEw9Pknhm2xSiynzSe5nm\nPEyerD4nDlESkKA/SCTu3/Ufra/0OXqgHPqHqPkMB7V0N84Dk1WbZzCzIPBYASc1\nmlkZz3mXzIFOa5ux0X7ydOr+e4Qd9bdkSjLQVphILvhdGiPAwmtVbiN3xddYy4jm\nBmJ+kPqlDxPCTfmcGXu6I5s=\n-----END PRIVATE KEY-----\n'),
(5, 40, 'MQrCZ0W1+kX5nHlzfVPIoxvlHb2FHha1ZaK0HRVFCLLG7bKMkRat2rOA5mUCNd1wn2OUNNQ4SYa66IdgLviBWj6Z2ahoqd3IHUODSue5t69gWgAUF2PfSCr2SdB5IhIy6dexD8lJljVJtsWp+WPvGBZCFbeplWSjB4+n6M2FFqigH2O7jndeeSIE8p/Pe+QwTNLbVF0TaGuey0IZyKNo5jpKvttx9f6IXSP/q8uqalnhiGj140hKTYliDbQWTX0iWVdLaAHkVDnSKW2qb6QmEFnrM4WwRL2ZU2Dzm0EW0epw54r3mqkOunmi8dzS+g06aSlMkh/p00UTAby6AkSa1g==', '-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQC5zA2KkkVz2c9o\nf0+ia6txymEsunMjVNl7o/RCppePZMQeoL8yp9MWvzCTv0BYmEvzODOxyrsCh1kS\n0t17ORLX/HLRI4d1OKIt/d9ySIuu1Kn17aQ94rbyetdRTuZSURGaX9O+qKNkaERK\nlzZ8nYI+nNkxONF9e6Qq7AiHzzU/ZmjT+6+NjB+ZWgrYwTtrXnB2RUx3e2I2TVqX\nCnPSS43sbm1Njjhsqig+Ewxt5FVpLCndT9LtOzSOI3PIXhIwqpqa/hX8jYbhybru\nc9iJRxaGTBav9dTxUPTtFiV515S/lzkc6PWS2lmDCDiyf+JJoY/T+ITZnp/PzJTC\noMHCOuD1AgMBAAECggEAOVcybqvJ54E3M6bm6teT5+BvsSAx3JuZK0FkZxWG/Og6\nZsFxgK6uxPxof5CsySrndb7IpXxNzu/6m4aceCUbHbF5tfXjHlhGJS+OwHSHN4PG\nmHGpGLhZgehLf3p8NrdyWVRtww/ErX5IZUTZugfaZHx/w2MntDRubBjAYTmf01q+\nNVYN/P1xd9fe6HiAHuZE6vnjgm15ljLONApjRS6jutFvGPsZMcPUOpcLmXCkyzeD\nDIF6J8EPVmBCFqbbPMKmacKMV8jEiUDImX7u3PYVdACsSnPgaGKwq270xcYpx+pZ\nQeBQs4Dq0Dly+g1dHezf4K4RQBzCxi51FyXpYHEVgQKBgQD14wXZ2eIscTxp8IAg\n9XpH+JVYwqffU5vMcC/XHFHdxHlqc3eaeX4wdk1CCXzGVAm/clUAcyufzuJITMJ4\nGze31Eyc4R2rn8N4CyuyNLG4W+h1jFveYIc20Am52EQ8zoaJ3jmGAaEM0v62QT/O\nC6oH+d7sEdtmXUmbl6+We2EthQKBgQDBcFY2qpVWpknxmpLCOUJngccookI1gUFV\nXKN8sbLMKQFqgd3i3m06MukTarRiQNkG9YqsSaunLsr/mizUVgat3WNAbM6nNlAN\npieQ7cWCfXFSEcDCMAyvRyZ9vyfduZNKKdT+kW5hABOYN/xf8JUP2BnTVEe7Uj79\nP49s3FlIsQKBgHAEHIZCXGcirwMULUrWif5/oInvI8r5q+BWu3Sj0ifVefqk37ff\n4Tzyp/+NkupHHqm4zECINzd2aF/HmFBfFeMJNF3DsGCfR81ISX/FwbDbLetfJfsI\nvpCZ9dRUUcHh1Ci6tDn4RAYzmRYuY4LajXtUudmRyQG5Pe9ECxni20KBAoGAPMI1\nQjx4Zdwbc7jyifEES5C25qt4kmfEBrTvYRZLq9bha/vYnw7wTgx5qzCj8gyeXpI3\neYA2W2/WMUzS8esHdAsKxsymaF0l7fOXj+0vUZpnQrjyy8vd4BxAGdU2B23ntq7H\nCSLTAcLNZM2JBvWBTJW7HublFRBzWoZhXXck0DECgYAhWo2T5pxrMHvjpf/tJoAX\nvNyeL00lpYHM9N6rTfA1BDKNr+Y0PpozC5ZlZxT5UIGDbAi/mScFlo+kty0PUDzP\nhUoV52YBTzGzpj4qxXeC9Lgb4dpqjF8ju9HtkdmqXzCh5INu+jkTN1v6S7Ph5b0e\n1tq//CSiaPO14TZO89vpmQ==\n-----END PRIVATE KEY-----\n');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `FK_Asset_id_Game` FOREIGN KEY (`id_game`) REFERENCES `projects` (`id`);

--
-- Constraints for table `rights_roles`
--
ALTER TABLE `rights_roles`
  ADD CONSTRAINT `FK_right_role_id_role` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id`);

--
-- Constraints for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD CONSTRAINT `FK_user_role_id_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
