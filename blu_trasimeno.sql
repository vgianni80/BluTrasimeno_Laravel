-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Creato il: Mar 05, 2026 alle 14:56
-- Versione del server: 8.0.44
-- Versione PHP: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blu_trasimeno`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `alloggiatiweb_logs`
--

CREATE TABLE `alloggiatiweb_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `booking_id` bigint UNSIGNED NOT NULL,
  `sent_at` timestamp NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `http_status_code` int DEFAULT NULL,
  `request_payload` longtext COLLATE utf8mb4_unicode_ci,
  `response_payload` longtext COLLATE utf8mb4_unicode_ci,
  `error_message` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint UNSIGNED NOT NULL,
  `ical_source_id` bigint UNSIGNED DEFAULT NULL,
  `ical_uid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `holidu_booking_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `holidu_channel` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `booked_at` timestamp NULL DEFAULT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `number_of_guests` int DEFAULT NULL,
  `paid_by_guest` decimal(10,2) DEFAULT NULL,
  `home_owner_payout` decimal(10,2) DEFAULT NULL,
  `channel_commission` decimal(10,2) DEFAULT NULL,
  `bookiply_commission` decimal(10,2) DEFAULT NULL,
  `bookiply_processing_markup` decimal(10,2) DEFAULT NULL,
  `cedolare_secca` decimal(10,2) DEFAULT NULL,
  `vat` decimal(10,2) DEFAULT NULL,
  `guest_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guest_surname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guest_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guest_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checkin_token` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checkin_completed_at` timestamp NULL DEFAULT NULL,
  `checkin_link_expires_at` timestamp NULL DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'incomplete',
  `sent_to_alloggiatiweb_at` timestamp NULL DEFAULT NULL,
  `send_attempts` int NOT NULL DEFAULT '0',
  `last_error` text COLLATE utf8mb4_unicode_ci,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `ical_raw_data` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `bookings`
--

INSERT INTO `bookings` (`id`, `ical_source_id`, `ical_uid`, `holidu_booking_id`, `holidu_channel`, `booked_at`, `check_in`, `check_out`, `number_of_guests`, `paid_by_guest`, `home_owner_payout`, `channel_commission`, `bookiply_commission`, `bookiply_processing_markup`, `cedolare_secca`, `vat`, `guest_name`, `guest_surname`, `guest_email`, `guest_phone`, `checkin_token`, `checkin_completed_at`, `checkin_link_expires_at`, `status`, `sent_to_alloggiatiweb_at`, `send_attempts`, `last_error`, `notes`, `ical_raw_data`, `created_at`, `updated_at`, `deleted_at`) VALUES
(18, 1, 'b0f69ece563001f4e21524ce1bb771dc3d2dccce@bookiply.com', '6942158', 'BOOKINGCOM', '2026-03-02 15:47:43', '2026-04-03', '2026-04-06', 3, 404.68, 210.57, 60.70, 16.85, 14.16, 84.98, 17.42, 'lucia', 'cresci', NULL, NULL, NULL, NULL, NULL, 'incomplete', NULL, 0, NULL, NULL, '{\"summary\": \"lucia cresci\", \"description\": \"\"}', '2026-03-02 16:47:44', '2026-03-03 08:18:40', NULL),
(19, 1, 'd1aaaf780037cc59a6875bbce6fc208180cb9cb5@bookiply.com', '6567161', 'BOOKINGCOM', '2026-03-02 15:47:43', '2026-05-17', '2026-05-24', 3, 647.01, 334.54, 97.05, 28.70, 22.65, 135.87, 28.20, 'M', 'Oostveen', NULL, NULL, NULL, NULL, NULL, 'incomplete', NULL, 0, NULL, NULL, '{\"summary\": \"M Oostveen\", \"description\": \"\"}', '2026-03-02 16:47:44', '2026-03-03 08:18:40', NULL),
(20, 1, 'a19e6aca1f9e970a75a362ecb03b24e33236d0df@bookiply.com', '6554277', 'BOOKINGCOM', '2026-03-02 15:47:43', '2026-05-31', '2026-06-07', 2, 585.19, 302.63, 87.78, 25.92, 20.48, 122.89, 25.49, 'Simona', 'Conti', NULL, NULL, NULL, NULL, NULL, 'incomplete', NULL, 0, NULL, NULL, '{\"summary\": \"Simona Conti\", \"description\": \"\"}', '2026-03-02 16:47:44', '2026-03-03 08:18:40', NULL),
(21, 1, '1ce70c3795d4954f1da9aa33a42ce0d16a89dc70@bookiply.com', '7001088', 'BOOKINGCOM', '2026-03-02 15:47:43', '2026-06-14', '2026-06-22', 2, 680.30, 351.59, 102.04, 30.33, 23.81, 142.86, 29.67, 'Markus', 'Santin', NULL, NULL, NULL, NULL, NULL, 'incomplete', NULL, 0, NULL, NULL, '{\"summary\": \"Markus Santin\", \"description\": \"\"}', '2026-03-02 16:47:44', '2026-03-03 08:18:40', NULL),
(22, 1, '33e6da0b0a1afb9068cdaa17b6f507cf91ed51c0@bookiply.com', '6854836', 'BOOKINGCOM', '2026-03-02 15:47:43', '2026-07-11', '2026-07-16', 2, 492.47, 255.47, 73.87, 21.14, 17.24, 103.42, 21.33, 'Phillip', 'Rooney', NULL, NULL, NULL, NULL, NULL, 'incomplete', NULL, 0, NULL, NULL, '{\"summary\": \"Phillip Rooney\", \"description\": \"\"}', '2026-03-02 16:47:44', '2026-03-03 08:18:40', NULL),
(23, 1, '80e9a9f4e150cc747bac0f213b694f9eaaa0baa6@bookiply.com', '6462576', 'BOOKINGCOM', '2026-03-02 15:47:43', '2026-07-25', '2026-08-01', 2, 514.31, 266.36, 77.15, 22.45, 18.00, 108.01, 22.34, 'Harm', 'Krul', NULL, NULL, NULL, NULL, NULL, 'incomplete', NULL, 0, NULL, NULL, '{\"summary\": \"Harm Krul\", \"description\": \"\"}', '2026-03-02 16:47:44', '2026-03-03 08:18:40', NULL),
(24, 1, 'e96db44ac764fec5a80cf5eda1181a494137645c@bookiply.com', '6378243', 'BOOKINGCOM', '2026-03-02 15:47:43', '2026-08-12', '2026-08-15', 2, 309.41, 161.52, 46.41, 12.43, 10.83, 64.98, 13.24, 'Aidan', 'Gray', NULL, NULL, NULL, NULL, NULL, 'incomplete', NULL, 0, NULL, NULL, '{\"summary\": \"Aidan Gray\", \"description\": \"\"}', '2026-03-02 16:47:44', '2026-03-03 08:18:40', NULL),
(25, 1, 'a83830e20d02a8db78172c79b21aa315cf5c2ac5@bookiply.com', '6556222', 'BOOKINGCOM', '2026-03-02 15:47:43', '2026-09-06', '2026-09-17', 3, 1117.28, 574.89, 167.59, 51.93, 39.10, 234.63, 49.14, 'Nikolai', 'Barg', NULL, NULL, NULL, NULL, NULL, 'incomplete', NULL, 0, NULL, NULL, '{\"summary\": \"Nikolai Barg\", \"description\": \"\"}', '2026-03-02 16:47:44', '2026-03-03 08:18:40', NULL),
(26, 1, '78236f58a81e24f749142c37cfe32f23c2097b40@bookiply.com', '6833015', 'BOOKINGCOM', '2026-03-02 15:47:43', '2026-10-03', '2026-10-15', 2, 819.55, 422.83, 122.93, 37.14, 28.68, 172.11, 35.86, 'Heike', 'Hilbig', NULL, NULL, NULL, NULL, NULL, 'incomplete', NULL, 0, NULL, NULL, '{\"summary\": \"Heike Hilbig\", \"description\": \"\"}', '2026-03-02 16:47:44', '2026-03-03 08:18:40', NULL),
(27, NULL, NULL, '5780760', 'BOOKINGCOM', '2025-04-04 00:00:00', '2025-04-20', '2025-04-22', 4, 238.78, 123.61, 35.82, 10.47, 8.36, 50.14, 10.38, 'Federico', 'Drago', NULL, NULL, NULL, NULL, NULL, 'incomplete', NULL, 0, NULL, NULL, NULL, '2026-03-03 08:18:40', '2026-03-03 08:18:40', NULL),
(28, NULL, NULL, '5794488', 'BOOKINGCOM', '2025-04-07 00:00:00', '2025-04-24', '2025-04-27', 2, 254.24, 131.37, 38.14, 11.35, 8.90, 53.39, 11.09, 'Pasquale', 'Malgieri', NULL, NULL, NULL, NULL, NULL, 'incomplete', NULL, 0, NULL, NULL, NULL, '2026-03-03 08:18:40', '2026-03-03 08:18:40', NULL),
(29, NULL, NULL, '5850902', 'BOOKINGCOM', '2025-04-20 00:00:00', '2025-05-01', '2025-05-04', 2, 260.62, 136.57, 39.09, 10.04, 9.12, 54.73, 11.07, 'Alessio', 'Bisceglia', NULL, NULL, NULL, NULL, NULL, 'incomplete', NULL, 0, NULL, NULL, NULL, '2026-03-03 08:18:40', '2026-03-03 08:18:40', NULL),
(30, NULL, NULL, '6004335', 'BOOKINGCOM', '2025-05-25 00:00:00', '2025-05-27', '2025-05-31', 2, 339.03, 176.68, 50.85, 13.88, 11.87, 71.20, 14.55, 'Stefano', 'Barone', NULL, NULL, NULL, NULL, NULL, 'incomplete', NULL, 0, NULL, NULL, NULL, '2026-03-03 08:18:40', '2026-03-03 08:18:40', NULL),
(31, NULL, NULL, '5907524', 'AIRBNB', '2025-05-03 00:00:00', '2025-05-31', '2025-06-02', 3, 229.00, 120.43, 36.64, 8.46, 5.72, 48.09, 9.66, 'Mara', 'Falsini', NULL, NULL, NULL, NULL, NULL, 'incomplete', NULL, 0, NULL, NULL, NULL, '2026-03-03 08:18:40', '2026-03-03 08:18:40', NULL),
(32, NULL, NULL, '5997687', 'HOLIDU', '2025-05-23 00:00:00', '2025-06-04', '2025-06-09', 2, 408.87, 228.43, 49.06, 18.15, 12.27, 85.86, 15.10, 'Anne-Kathrin', 'Bubas', NULL, NULL, NULL, NULL, NULL, 'incomplete', NULL, 0, NULL, NULL, NULL, '2026-03-03 08:18:40', '2026-03-03 08:18:40', NULL),
(33, NULL, NULL, '5892584', 'BOOKINGCOM', '2025-04-29 00:00:00', '2025-06-09', '2025-06-15', 1, 533.51, 276.18, 80.03, 23.39, 18.67, 112.04, 23.20, 'Daniela', 'Pontecorvo', NULL, NULL, NULL, NULL, NULL, 'incomplete', NULL, 0, NULL, NULL, NULL, '2026-03-03 08:18:40', '2026-03-03 08:18:40', NULL),
(34, NULL, NULL, '6047556', 'BOOKINGCOM', '2025-06-02 00:00:00', '2025-07-01', '2025-07-04', 2, 302.70, 158.10, 45.40, 12.10, 10.59, 63.57, 12.94, 'Giulia', 'Pennacchia', NULL, NULL, NULL, NULL, NULL, 'incomplete', NULL, 0, NULL, NULL, NULL, '2026-03-03 08:18:40', '2026-03-03 08:18:40', NULL),
(35, NULL, NULL, '6233108', 'BOOKINGCOM', '2025-07-15 00:00:00', '2025-07-16', '2025-07-18', 2, 217.16, 112.76, 32.57, 9.24, 7.60, 45.60, 9.39, 'roberto', 'bonfanti', NULL, NULL, NULL, NULL, NULL, 'incomplete', NULL, 0, NULL, NULL, NULL, '2026-03-03 08:18:40', '2026-03-03 08:18:40', NULL),
(36, NULL, NULL, '6173833', 'HOLIDU', '2025-07-02 00:00:00', '2025-07-21', '2025-07-24', 4, 412.91, 230.64, 49.55, 18.36, 12.39, 86.71, 15.26, 'Dario', 'Pino', NULL, NULL, NULL, NULL, NULL, 'incomplete', NULL, 0, NULL, NULL, NULL, '2026-03-03 08:18:40', '2026-03-03 08:18:40', NULL),
(37, NULL, NULL, '5892000', 'AIRBNB', '2025-04-29 00:00:00', '2025-07-24', '2025-08-05', 3, 1052.00, 541.52, 168.32, 48.70, 26.30, 220.92, 46.24, 'Arnaud', 'Hespel', NULL, NULL, NULL, NULL, NULL, 'incomplete', NULL, 0, NULL, NULL, NULL, '2026-03-03 08:18:40', '2026-03-03 08:18:40', NULL),
(38, NULL, NULL, '5948134', 'AIRBNB', '2025-05-12 00:00:00', '2025-08-05', '2025-08-12', 2, 715.00, 369.09, 114.40, 32.22, 17.88, 150.15, 31.26, 'Piero', 'Grossi', NULL, NULL, NULL, NULL, NULL, 'incomplete', NULL, 0, NULL, NULL, NULL, '2026-03-03 08:18:40', '2026-03-03 08:18:40', NULL),
(39, NULL, NULL, '6253432', 'BOOKINGCOM', '2025-07-20 00:00:00', '2025-08-12', '2025-08-14', 3, 305.35, 157.03, 45.80, 14.27, 10.69, 64.12, 13.44, 'Igor', 'Fantinati', NULL, NULL, NULL, NULL, NULL, 'incomplete', NULL, 0, NULL, NULL, NULL, '2026-03-03 08:18:40', '2026-03-03 08:18:40', NULL),
(40, NULL, NULL, '6298965', 'BOOKINGCOM', '2025-08-01 00:00:00', '2025-08-21', '2025-08-24', 3, 378.60, 196.93, 56.79, 15.81, 13.25, 79.51, 16.31, 'Daniele', 'Carbone', NULL, NULL, NULL, NULL, NULL, 'incomplete', NULL, 0, NULL, NULL, NULL, '2026-03-03 08:18:40', '2026-03-03 08:18:40', NULL),
(41, NULL, NULL, '6391359', 'BOOKINGCOM', '2025-08-28 00:00:00', '2025-09-08', '2025-09-15', 2, 522.08, 265.82, 78.31, 26.63, 18.27, 109.64, 23.41, 'Veronica', 'Lorenzi', NULL, NULL, NULL, NULL, NULL, 'incomplete', NULL, 0, NULL, NULL, NULL, '2026-03-03 08:18:40', '2026-03-03 08:18:40', NULL),
(42, NULL, NULL, '6039269', 'HOMEAWAY', '2025-06-01 00:00:00', '2025-09-17', '2025-09-21', 2, 385.37, 202.54, 57.81, 16.26, 11.56, 80.93, 16.27, 'Jennifer', 'Dickey', NULL, NULL, NULL, NULL, NULL, 'incomplete', NULL, 0, NULL, NULL, NULL, '2026-03-03 08:18:40', '2026-03-03 08:18:40', NULL),
(43, NULL, NULL, '6441099', 'HOLIDU', '2025-09-13 00:00:00', '2025-10-11', '2025-10-18', 3, 614.71, 341.80, 73.77, 28.65, 18.44, 129.09, 22.96, 'Patrizia', 'Beretta', NULL, NULL, NULL, NULL, NULL, 'incomplete', NULL, 0, NULL, NULL, NULL, '2026-03-03 08:18:40', '2026-03-03 08:18:40', NULL),
(44, NULL, NULL, '6570781', 'BOOKINGCOM', '2025-10-22 00:00:00', '2025-10-31', '2025-11-02', 2, 198.78, 105.20, 29.82, 6.78, 6.96, 41.74, 8.28, 'Linda', 'Marini', NULL, NULL, NULL, NULL, NULL, 'incomplete', NULL, 0, NULL, NULL, NULL, '2026-03-03 08:18:40', '2026-03-03 08:18:40', NULL),
(45, NULL, NULL, '6438137', 'BOOKINGCOM', '2025-09-12 00:00:00', '2025-11-03', '2025-11-09', 2, 474.04, 245.76, 71.11, 20.48, 16.59, 99.55, 20.55, 'Giovanni', 'Maria Dell\'Oro', NULL, NULL, NULL, NULL, NULL, 'incomplete', NULL, 0, NULL, NULL, NULL, '2026-03-03 08:18:40', '2026-03-03 08:18:40', NULL),
(46, NULL, NULL, '6630342', 'BOOKINGCOM', '2025-11-11 00:00:00', '2025-11-13', '2025-11-16', 2, 230.08, 121.22, 34.51, 8.31, 8.05, 48.32, 9.67, 'Desiree', 'Camponeschi', NULL, NULL, NULL, NULL, NULL, 'incomplete', NULL, 0, NULL, NULL, NULL, '2026-03-03 08:18:40', '2026-03-03 08:18:40', NULL),
(47, NULL, NULL, '6679230', 'BOOKINGCOM', '2025-11-29 00:00:00', '2025-12-06', '2025-12-07', 2, 149.58, 80.03, 22.44, 4.37, 5.24, 31.41, 6.09, 'Giuseppe', 'Fedele', NULL, NULL, NULL, NULL, NULL, 'incomplete', NULL, 0, NULL, NULL, NULL, '2026-03-03 08:18:40', '2026-03-03 08:18:40', NULL),
(48, NULL, NULL, '6571097', 'BOOKINGCOM', '2025-10-23 00:00:00', '2025-12-23', '2026-01-06', 3, 1266.07, 651.30, 189.91, 58.97, 44.31, 265.87, 55.71, 'Vivaldi', 'Daniele', NULL, NULL, NULL, NULL, NULL, 'incomplete', NULL, 0, NULL, NULL, NULL, '2026-03-03 08:18:40', '2026-03-03 08:18:40', NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_setting_admin_email', 'O:18:\"App\\Models\\Setting\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"settings\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:7;s:3:\"key\";s:11:\"admin_email\";s:5:\"value\";s:19:\"vgianni80@gmail.com\";s:4:\"type\";s:6:\"string\";s:5:\"group\";s:5:\"email\";s:5:\"label\";s:11:\"Email Admin\";s:11:\"description\";N;s:10:\"created_at\";s:19:\"2026-02-06 15:17:12\";s:10:\"updated_at\";s:19:\"2026-02-06 15:31:16\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:7;s:3:\"key\";s:11:\"admin_email\";s:5:\"value\";s:19:\"vgianni80@gmail.com\";s:4:\"type\";s:6:\"string\";s:5:\"group\";s:5:\"email\";s:5:\"label\";s:11:\"Email Admin\";s:11:\"description\";N;s:10:\"created_at\";s:19:\"2026-02-06 15:17:12\";s:10:\"updated_at\";s:19:\"2026-02-06 15:31:16\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:3:\"key\";i:1;s:5:\"value\";i:2;s:4:\"type\";i:3;s:5:\"group\";i:4;s:5:\"label\";i:5;s:11:\"description\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1772526586),
('laravel_cache_setting_alloggiatiweb_enabled', 'O:18:\"App\\Models\\Setting\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"settings\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:1;s:3:\"key\";s:21:\"alloggiatiweb_enabled\";s:5:\"value\";s:1:\"1\";s:4:\"type\";s:7:\"boolean\";s:5:\"group\";s:13:\"alloggiatiweb\";s:5:\"label\";s:27:\"Abilita invio AlloggiatiWeb\";s:11:\"description\";N;s:10:\"created_at\";s:19:\"2026-02-06 15:17:12\";s:10:\"updated_at\";s:19:\"2026-02-06 15:31:16\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:1;s:3:\"key\";s:21:\"alloggiatiweb_enabled\";s:5:\"value\";s:1:\"1\";s:4:\"type\";s:7:\"boolean\";s:5:\"group\";s:13:\"alloggiatiweb\";s:5:\"label\";s:27:\"Abilita invio AlloggiatiWeb\";s:11:\"description\";N;s:10:\"created_at\";s:19:\"2026-02-06 15:17:12\";s:10:\"updated_at\";s:19:\"2026-02-06 15:31:16\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:3:\"key\";i:1;s:5:\"value\";i:2;s:4:\"type\";i:3;s:5:\"group\";i:4;s:5:\"label\";i:5;s:11:\"description\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1772526586),
('laravel_cache_setting_alloggiatiweb_password', 'O:18:\"App\\Models\\Setting\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"settings\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:4;s:3:\"key\";s:22:\"alloggiatiweb_password\";s:5:\"value\";s:8:\"password\";s:4:\"type\";s:6:\"string\";s:5:\"group\";s:13:\"alloggiatiweb\";s:5:\"label\";s:8:\"Password\";s:11:\"description\";N;s:10:\"created_at\";s:19:\"2026-02-06 15:17:12\";s:10:\"updated_at\";s:19:\"2026-02-06 15:31:16\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:4;s:3:\"key\";s:22:\"alloggiatiweb_password\";s:5:\"value\";s:8:\"password\";s:4:\"type\";s:6:\"string\";s:5:\"group\";s:13:\"alloggiatiweb\";s:5:\"label\";s:8:\"Password\";s:11:\"description\";N;s:10:\"created_at\";s:19:\"2026-02-06 15:17:12\";s:10:\"updated_at\";s:19:\"2026-02-06 15:31:16\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:3:\"key\";i:1;s:5:\"value\";i:2;s:4:\"type\";i:3;s:5:\"group\";i:4;s:5:\"label\";i:5;s:11:\"description\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1772526586),
('laravel_cache_setting_alloggiatiweb_property_id', 'O:18:\"App\\Models\\Setting\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"settings\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:6;s:3:\"key\";s:25:\"alloggiatiweb_property_id\";s:5:\"value\";s:0:\"\";s:4:\"type\";s:6:\"string\";s:5:\"group\";s:13:\"alloggiatiweb\";s:5:\"label\";s:16:\"Codice Struttura\";s:11:\"description\";N;s:10:\"created_at\";s:19:\"2026-02-06 15:17:12\";s:10:\"updated_at\";s:19:\"2026-02-06 15:17:12\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:6;s:3:\"key\";s:25:\"alloggiatiweb_property_id\";s:5:\"value\";s:0:\"\";s:4:\"type\";s:6:\"string\";s:5:\"group\";s:13:\"alloggiatiweb\";s:5:\"label\";s:16:\"Codice Struttura\";s:11:\"description\";N;s:10:\"created_at\";s:19:\"2026-02-06 15:17:12\";s:10:\"updated_at\";s:19:\"2026-02-06 15:17:12\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:3:\"key\";i:1;s:5:\"value\";i:2;s:4:\"type\";i:3;s:5:\"group\";i:4;s:5:\"label\";i:5;s:11:\"description\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1772526586),
('laravel_cache_setting_alloggiatiweb_username', 'O:18:\"App\\Models\\Setting\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"settings\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:3;s:3:\"key\";s:22:\"alloggiatiweb_username\";s:5:\"value\";s:17:\"admin@example.com\";s:4:\"type\";s:6:\"string\";s:5:\"group\";s:13:\"alloggiatiweb\";s:5:\"label\";s:8:\"Username\";s:11:\"description\";N;s:10:\"created_at\";s:19:\"2026-02-06 15:17:12\";s:10:\"updated_at\";s:19:\"2026-02-06 15:31:16\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:3;s:3:\"key\";s:22:\"alloggiatiweb_username\";s:5:\"value\";s:17:\"admin@example.com\";s:4:\"type\";s:6:\"string\";s:5:\"group\";s:13:\"alloggiatiweb\";s:5:\"label\";s:8:\"Username\";s:11:\"description\";N;s:10:\"created_at\";s:19:\"2026-02-06 15:17:12\";s:10:\"updated_at\";s:19:\"2026-02-06 15:31:16\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:3:\"key\";i:1;s:5:\"value\";i:2;s:4:\"type\";i:3;s:5:\"group\";i:4;s:5:\"label\";i:5;s:11:\"description\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1772526586),
('laravel_cache_setting_alloggiatiweb_ws_key', 'O:18:\"App\\Models\\Setting\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"settings\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:5;s:3:\"key\";s:20:\"alloggiatiweb_ws_key\";s:5:\"value\";s:0:\"\";s:4:\"type\";s:6:\"string\";s:5:\"group\";s:13:\"alloggiatiweb\";s:5:\"label\";s:9:\"Chiave WS\";s:11:\"description\";N;s:10:\"created_at\";s:19:\"2026-02-06 15:17:12\";s:10:\"updated_at\";s:19:\"2026-02-06 15:17:12\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:5;s:3:\"key\";s:20:\"alloggiatiweb_ws_key\";s:5:\"value\";s:0:\"\";s:4:\"type\";s:6:\"string\";s:5:\"group\";s:13:\"alloggiatiweb\";s:5:\"label\";s:9:\"Chiave WS\";s:11:\"description\";N;s:10:\"created_at\";s:19:\"2026-02-06 15:17:12\";s:10:\"updated_at\";s:19:\"2026-02-06 15:17:12\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:3:\"key\";i:1;s:5:\"value\";i:2;s:4:\"type\";i:3;s:5:\"group\";i:4;s:5:\"label\";i:5;s:11:\"description\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1772526586),
('laravel_cache_setting_alloggiatiweb_wsdl_url', 'O:18:\"App\\Models\\Setting\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"settings\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:2;s:3:\"key\";s:22:\"alloggiatiweb_wsdl_url\";s:5:\"value\";s:65:\"https://alloggiatiweb.poliziadistato.it/service/service.asmx?wsdl\";s:4:\"type\";s:6:\"string\";s:5:\"group\";s:13:\"alloggiatiweb\";s:5:\"label\";s:8:\"URL WSDL\";s:11:\"description\";N;s:10:\"created_at\";s:19:\"2026-02-06 15:17:12\";s:10:\"updated_at\";s:19:\"2026-02-06 15:17:12\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:2;s:3:\"key\";s:22:\"alloggiatiweb_wsdl_url\";s:5:\"value\";s:65:\"https://alloggiatiweb.poliziadistato.it/service/service.asmx?wsdl\";s:4:\"type\";s:6:\"string\";s:5:\"group\";s:13:\"alloggiatiweb\";s:5:\"label\";s:8:\"URL WSDL\";s:11:\"description\";N;s:10:\"created_at\";s:19:\"2026-02-06 15:17:12\";s:10:\"updated_at\";s:19:\"2026-02-06 15:17:12\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:3:\"key\";i:1;s:5:\"value\";i:2;s:4:\"type\";i:3;s:5:\"group\";i:4;s:5:\"label\";i:5;s:11:\"description\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1772526586),
('laravel_cache_setting_checkin_instructions', 'O:18:\"App\\Models\\Setting\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"settings\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:13;s:3:\"key\";s:20:\"checkin_instructions\";s:5:\"value\";s:0:\"\";s:4:\"type\";s:6:\"string\";s:5:\"group\";s:8:\"property\";s:5:\"label\";s:19:\"Istruzioni Check-in\";s:11:\"description\";N;s:10:\"created_at\";s:19:\"2026-02-06 15:17:12\";s:10:\"updated_at\";s:19:\"2026-02-06 15:17:12\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:13;s:3:\"key\";s:20:\"checkin_instructions\";s:5:\"value\";s:0:\"\";s:4:\"type\";s:6:\"string\";s:5:\"group\";s:8:\"property\";s:5:\"label\";s:19:\"Istruzioni Check-in\";s:11:\"description\";N;s:10:\"created_at\";s:19:\"2026-02-06 15:17:12\";s:10:\"updated_at\";s:19:\"2026-02-06 15:17:12\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:3:\"key\";i:1;s:5:\"value\";i:2;s:4:\"type\";i:3;s:5:\"group\";i:4;s:5:\"label\";i:5;s:11:\"description\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1772526586),
('laravel_cache_setting_checkin_link_expiry_days', 'O:18:\"App\\Models\\Setting\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"settings\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:14;s:3:\"key\";s:24:\"checkin_link_expiry_days\";s:5:\"value\";s:2:\"30\";s:4:\"type\";s:7:\"integer\";s:5:\"group\";s:7:\"general\";s:5:\"label\";s:31:\"Scadenza Link Check-in (giorni)\";s:11:\"description\";N;s:10:\"created_at\";s:19:\"2026-02-06 15:17:12\";s:10:\"updated_at\";s:19:\"2026-02-06 15:17:12\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:14;s:3:\"key\";s:24:\"checkin_link_expiry_days\";s:5:\"value\";s:2:\"30\";s:4:\"type\";s:7:\"integer\";s:5:\"group\";s:7:\"general\";s:5:\"label\";s:31:\"Scadenza Link Check-in (giorni)\";s:11:\"description\";N;s:10:\"created_at\";s:19:\"2026-02-06 15:17:12\";s:10:\"updated_at\";s:19:\"2026-02-06 15:17:12\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:3:\"key\";i:1;s:5:\"value\";i:2;s:4:\"type\";i:3;s:5:\"group\";i:4;s:5:\"label\";i:5;s:11:\"description\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1772526586),
('laravel_cache_setting_default_price_per_night', 'N;', 1770891402),
('laravel_cache_setting_email_from_address', 'O:18:\"App\\Models\\Setting\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"settings\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:9;s:3:\"key\";s:18:\"email_from_address\";s:5:\"value\";s:20:\"info@blutrasimeno.it\";s:4:\"type\";s:6:\"string\";s:5:\"group\";s:5:\"email\";s:5:\"label\";s:14:\"Email Mittente\";s:11:\"description\";N;s:10:\"created_at\";s:19:\"2026-02-06 15:17:12\";s:10:\"updated_at\";s:19:\"2026-02-06 15:54:28\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:9;s:3:\"key\";s:18:\"email_from_address\";s:5:\"value\";s:20:\"info@blutrasimeno.it\";s:4:\"type\";s:6:\"string\";s:5:\"group\";s:5:\"email\";s:5:\"label\";s:14:\"Email Mittente\";s:11:\"description\";N;s:10:\"created_at\";s:19:\"2026-02-06 15:17:12\";s:10:\"updated_at\";s:19:\"2026-02-06 15:54:28\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:3:\"key\";i:1;s:5:\"value\";i:2;s:4:\"type\";i:3;s:5:\"group\";i:4;s:5:\"label\";i:5;s:11:\"description\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1772526586),
('laravel_cache_setting_email_from_name', 'O:18:\"App\\Models\\Setting\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"settings\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:8;s:3:\"key\";s:15:\"email_from_name\";s:5:\"value\";s:21:\"Gestione Prenotazioni\";s:4:\"type\";s:6:\"string\";s:5:\"group\";s:5:\"email\";s:5:\"label\";s:13:\"Nome Mittente\";s:11:\"description\";N;s:10:\"created_at\";s:19:\"2026-02-06 15:17:12\";s:10:\"updated_at\";s:19:\"2026-02-06 15:17:12\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:8;s:3:\"key\";s:15:\"email_from_name\";s:5:\"value\";s:21:\"Gestione Prenotazioni\";s:4:\"type\";s:6:\"string\";s:5:\"group\";s:5:\"email\";s:5:\"label\";s:13:\"Nome Mittente\";s:11:\"description\";N;s:10:\"created_at\";s:19:\"2026-02-06 15:17:12\";s:10:\"updated_at\";s:19:\"2026-02-06 15:17:12\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:3:\"key\";i:1;s:5:\"value\";i:2;s:4:\"type\";i:3;s:5:\"group\";i:4;s:5:\"label\";i:5;s:11:\"description\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1772526586),
('laravel_cache_setting_max_guests', 'N;', 1770891402),
('laravel_cache_setting_property_address', 'O:18:\"App\\Models\\Setting\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"settings\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:11;s:3:\"key\";s:16:\"property_address\";s:5:\"value\";s:22:\"via Paolo Borsellino 5\";s:4:\"type\";s:6:\"string\";s:5:\"group\";s:8:\"property\";s:5:\"label\";s:9:\"Indirizzo\";s:11:\"description\";N;s:10:\"created_at\";s:19:\"2026-02-06 15:17:12\";s:10:\"updated_at\";s:19:\"2026-02-06 15:31:16\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:11;s:3:\"key\";s:16:\"property_address\";s:5:\"value\";s:22:\"via Paolo Borsellino 5\";s:4:\"type\";s:6:\"string\";s:5:\"group\";s:8:\"property\";s:5:\"label\";s:9:\"Indirizzo\";s:11:\"description\";N;s:10:\"created_at\";s:19:\"2026-02-06 15:17:12\";s:10:\"updated_at\";s:19:\"2026-02-06 15:31:16\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:3:\"key\";i:1;s:5:\"value\";i:2;s:4:\"type\";i:3;s:5:\"group\";i:4;s:5:\"label\";i:5;s:11:\"description\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1772526586),
('laravel_cache_setting_property_name', 'O:18:\"App\\Models\\Setting\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"settings\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:10;s:3:\"key\";s:13:\"property_name\";s:5:\"value\";s:13:\"Blu Trasimeno\";s:4:\"type\";s:6:\"string\";s:5:\"group\";s:8:\"property\";s:5:\"label\";s:14:\"Nome Struttura\";s:11:\"description\";N;s:10:\"created_at\";s:19:\"2026-02-06 15:17:12\";s:10:\"updated_at\";s:19:\"2026-02-06 15:31:16\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:10;s:3:\"key\";s:13:\"property_name\";s:5:\"value\";s:13:\"Blu Trasimeno\";s:4:\"type\";s:6:\"string\";s:5:\"group\";s:8:\"property\";s:5:\"label\";s:14:\"Nome Struttura\";s:11:\"description\";N;s:10:\"created_at\";s:19:\"2026-02-06 15:17:12\";s:10:\"updated_at\";s:19:\"2026-02-06 15:31:16\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:3:\"key\";i:1;s:5:\"value\";i:2;s:4:\"type\";i:3;s:5:\"group\";i:4;s:5:\"label\";i:5;s:11:\"description\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1772526586),
('laravel_cache_setting_property_phone', 'O:18:\"App\\Models\\Setting\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"settings\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:12;s:3:\"key\";s:14:\"property_phone\";s:5:\"value\";s:10:\"3389578659\";s:4:\"type\";s:6:\"string\";s:5:\"group\";s:8:\"property\";s:5:\"label\";s:8:\"Telefono\";s:11:\"description\";N;s:10:\"created_at\";s:19:\"2026-02-06 15:17:12\";s:10:\"updated_at\";s:19:\"2026-02-06 15:31:16\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:12;s:3:\"key\";s:14:\"property_phone\";s:5:\"value\";s:10:\"3389578659\";s:4:\"type\";s:6:\"string\";s:5:\"group\";s:8:\"property\";s:5:\"label\";s:8:\"Telefono\";s:11:\"description\";N;s:10:\"created_at\";s:19:\"2026-02-06 15:17:12\";s:10:\"updated_at\";s:19:\"2026-02-06 15:31:16\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:3:\"key\";i:1;s:5:\"value\";i:2;s:4:\"type\";i:3;s:5:\"group\";i:4;s:5:\"label\";i:5;s:11:\"description\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1772526586),
('laravel_cache_setting_send_time', 'O:18:\"App\\Models\\Setting\":30:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"settings\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:15;s:3:\"key\";s:9:\"send_time\";s:5:\"value\";s:5:\"23:00\";s:4:\"type\";s:6:\"string\";s:5:\"group\";s:7:\"general\";s:5:\"label\";s:26:\"Orario Invio AlloggiatiWeb\";s:11:\"description\";N;s:10:\"created_at\";s:19:\"2026-02-06 15:17:12\";s:10:\"updated_at\";s:19:\"2026-02-06 15:31:37\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:15;s:3:\"key\";s:9:\"send_time\";s:5:\"value\";s:5:\"23:00\";s:4:\"type\";s:6:\"string\";s:5:\"group\";s:7:\"general\";s:5:\"label\";s:26:\"Orario Invio AlloggiatiWeb\";s:11:\"description\";N;s:10:\"created_at\";s:19:\"2026-02-06 15:17:12\";s:10:\"updated_at\";s:19:\"2026-02-06 15:31:37\";}s:10:\"\0*\0changes\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:3:\"key\";i:1;s:5:\"value\";i:2;s:4:\"type\";i:3;s:5:\"group\";i:4;s:5:\"label\";i:5;s:11:\"description\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}', 1772725872);

-- --------------------------------------------------------

--
-- Struttura della tabella `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `guests`
--

CREATE TABLE `guests` (
  `id` bigint UNSIGNED NOT NULL,
  `booking_id` bigint UNSIGNED NOT NULL,
  `nome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cognome` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sesso` enum('M','F') COLLATE utf8mb4_unicode_ci NOT NULL,
  `data_nascita` date NOT NULL,
  `comune_nascita` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `provincia_nascita` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stato_nascita` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'ITALIA',
  `cittadinanza` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_documento` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_documento` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rilasciato_da` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_rilascio` date DEFAULT NULL,
  `data_scadenza` date DEFAULT NULL,
  `is_capogruppo` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `ical_sources`
--

CREATE TABLE `ical_sources` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `polling_frequency_minutes` int NOT NULL DEFAULT '60',
  `last_synced_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `ical_sources`
--

INSERT INTO `ical_sources` (`id`, `name`, `url`, `polling_frequency_minutes`, `last_synced_at`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Holidu', 'https://api.host.holidu.com/pmc/rest/apartments/62075062/ical.ics?key=0c202e7ad9cecaab61a1724b9b41076a', 15, '2026-03-02 16:47:44', 1, '2026-02-06 15:19:39', '2026-03-02 16:47:44');

-- --------------------------------------------------------

--
-- Struttura della tabella `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `length_discounts`
--

CREATE TABLE `length_discounts` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `min_nights` int NOT NULL,
  `discount_percent` decimal(5,2) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_jobs_table', 1),
(3, '0001_01_01_000002_create_settings_table', 1),
(4, '0001_01_01_000003_create_ical_sources_table', 1),
(5, '0001_01_01_000004_create_bookings_table', 1),
(6, '0001_01_01_000005_create_guests_table', 1),
(7, '0001_01_01_000006_create_sync_logs_table', 1),
(8, '0001_01_01_000007_create_alloggiatiweb_logs_table', 1),
(9, '0001_01_01_000008_create_pricing_rules_table', 2),
(10, '0001_01_01_000009_create_length_discounts_table', 2),
(11, '0001_01_01_000010_create_public_bookings_table', 2),
(12, '0001_01_01_000011_add_booked_at_to_bookings_table', 3),
(13, '0001_01_01_000012_add_financial_fields_to_bookings_table', 4);

-- --------------------------------------------------------

--
-- Struttura della tabella `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `pricing_rules`
--

CREATE TABLE `pricing_rules` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('base','seasonal','weekend','special') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'base',
  `price_per_night` decimal(10,2) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `days_of_week` json DEFAULT NULL,
  `priority` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `public_bookings`
--

CREATE TABLE `public_bookings` (
  `id` bigint UNSIGNED NOT NULL,
  `guest_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guest_surname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guest_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guest_phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `guests` int NOT NULL DEFAULT '1',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `total` decimal(10,2) NOT NULL,
  `price_breakdown` json DEFAULT NULL,
  `status` enum('pending','confirmed','rejected','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `admin_notes` text COLLATE utf8mb4_unicode_ci,
  `booking_id` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struttura della tabella `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Binb6BsvkF6nFjHn5htZK3DO8S9mSehnn4KSAFjd', 1, '169.150.247.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVlU3T3BSbUtycFNPTjRwQVV3SlN1UnMxSXlDc1VzbDFNYjJBSmxrVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1770389782),
('R3jVfDzZhNgrhZ8cYIsaKYvvC1BBXYeKgP8NYCPj', 1, '192.168.65.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoia1BYclV2WHdaeHcwM0xaRTVCaU9QeGJteDBURW9CbDB5elJHSmQ4TCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9zZXR0aW5ncyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1770824606),
('s8w5VCE69h9zgfLCxrjmC670C9sJNV7phyPSTcPJ', 1, '192.168.65.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiM241Y28xM0ZWSkV4eWJQQVNUNWtTUU12cTlMM2tqWkFJUkxmTkdyQSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1770824642),
('Z1Zp8hFAmUcOeO8bMuQPC60B3XI413V1OhgntxHo', 1, '169.150.247.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVVlabzNhSXM5VENoT0taaU9CdzRJdjAwYkp2ZHZkejA4bTdvRVZCMiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9ib29raW5ncyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1770389778),
('zIzG8LazlNTpi5FRERrPerUeMqstasuQ750jHvq6', 1, '192.168.65.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNXZqbXcxWVRuZUFXaWx1Rm5xUGVCb1BlV0ZXam1STGV3NDcxQ1BNViI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1770824667);

-- --------------------------------------------------------

--
-- Struttura della tabella `settings`
--

CREATE TABLE `settings` (
  `id` bigint UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'string',
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'general',
  `label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `type`, `group`, `label`, `description`, `created_at`, `updated_at`) VALUES
(1, 'alloggiatiweb_enabled', '1', 'boolean', 'alloggiatiweb', 'Abilita invio AlloggiatiWeb', NULL, '2026-02-06 15:17:12', '2026-02-06 15:31:16'),
(2, 'alloggiatiweb_wsdl_url', 'https://alloggiatiweb.poliziadistato.it/service/service.asmx?wsdl', 'string', 'alloggiatiweb', 'URL WSDL', NULL, '2026-02-06 15:17:12', '2026-02-06 15:17:12'),
(3, 'alloggiatiweb_username', 'admin@example.com', 'string', 'alloggiatiweb', 'Username', NULL, '2026-02-06 15:17:12', '2026-02-06 15:31:16'),
(4, 'alloggiatiweb_password', 'password', 'string', 'alloggiatiweb', 'Password', NULL, '2026-02-06 15:17:12', '2026-02-06 15:31:16'),
(5, 'alloggiatiweb_ws_key', '', 'string', 'alloggiatiweb', 'Chiave WS', NULL, '2026-02-06 15:17:12', '2026-02-06 15:17:12'),
(6, 'alloggiatiweb_property_id', '', 'string', 'alloggiatiweb', 'Codice Struttura', NULL, '2026-02-06 15:17:12', '2026-02-06 15:17:12'),
(7, 'admin_email', 'vgianni80@gmail.com', 'string', 'email', 'Email Admin', NULL, '2026-02-06 15:17:12', '2026-02-06 15:31:16'),
(8, 'email_from_name', 'Gestione Prenotazioni', 'string', 'email', 'Nome Mittente', NULL, '2026-02-06 15:17:12', '2026-02-06 15:17:12'),
(9, 'email_from_address', 'info@blutrasimeno.it', 'string', 'email', 'Email Mittente', NULL, '2026-02-06 15:17:12', '2026-02-06 15:54:28'),
(10, 'property_name', 'Blu Trasimeno', 'string', 'property', 'Nome Struttura', NULL, '2026-02-06 15:17:12', '2026-02-06 15:31:16'),
(11, 'property_address', 'via Paolo Borsellino 5', 'string', 'property', 'Indirizzo', NULL, '2026-02-06 15:17:12', '2026-02-06 15:31:16'),
(12, 'property_phone', '3389578659', 'string', 'property', 'Telefono', NULL, '2026-02-06 15:17:12', '2026-02-06 15:31:16'),
(13, 'checkin_instructions', '', 'string', 'property', 'Istruzioni Check-in', NULL, '2026-02-06 15:17:12', '2026-02-06 15:17:12'),
(14, 'checkin_link_expiry_days', '30', 'integer', 'general', 'Scadenza Link Check-in (giorni)', NULL, '2026-02-06 15:17:12', '2026-02-06 15:17:12'),
(15, 'send_time', '23:00', 'string', 'general', 'Orario Invio AlloggiatiWeb', NULL, '2026-02-06 15:17:12', '2026-02-06 15:31:37');

-- --------------------------------------------------------

--
-- Struttura della tabella `sync_logs`
--

CREATE TABLE `sync_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `ical_source_id` bigint UNSIGNED NOT NULL,
  `synced_at` timestamp NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `bookings_found` int NOT NULL DEFAULT '0',
  `bookings_created` int NOT NULL DEFAULT '0',
  `bookings_updated` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `sync_logs`
--

INSERT INTO `sync_logs` (`id`, `ical_source_id`, `synced_at`, `status`, `message`, `bookings_found`, `bookings_created`, `bookings_updated`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-02-06 15:19:41', 'success', 'Sync completata', 8, 7, 0, '2026-02-06 15:19:46', '2026-02-06 15:19:46'),
(2, 1, '2026-02-06 15:29:05', 'success', 'Sync completata', 8, 7, 0, '2026-02-06 15:29:10', '2026-02-06 15:29:10'),
(3, 1, '2026-02-11 16:36:23', 'success', 'Sync completata', 7, 0, 7, '2026-02-11 16:36:23', '2026-02-11 16:36:23'),
(4, 1, '2026-03-02 16:35:54', 'success', 'Sync completata', 9, 2, 7, '2026-03-02 16:35:55', '2026-03-02 16:35:55'),
(5, 1, '2026-03-02 16:47:43', 'success', 'Sync completata', 9, 9, 0, '2026-03-02 16:47:44', '2026-03-02 16:47:44');

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Amministratore', 'admin@example.com', NULL, '$2y$12$Kgvr3bkDJjYzeA82L4L.9OEqHU9tXCdiGwPUB8ImI5hnZ5nfw5JSK', NULL, '2026-02-06 15:17:12', '2026-02-06 15:17:12');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `alloggiatiweb_logs`
--
ALTER TABLE `alloggiatiweb_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alloggiatiweb_logs_booking_id_foreign` (`booking_id`);

--
-- Indici per le tabelle `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bookings_checkin_token_unique` (`checkin_token`),
  ADD KEY `bookings_ical_source_id_foreign` (`ical_source_id`),
  ADD KEY `bookings_status_check_in_index` (`status`,`check_in`),
  ADD KEY `bookings_ical_uid_index` (`ical_uid`),
  ADD KEY `bookings_holidu_booking_id_index` (`holidu_booking_id`);

--
-- Indici per le tabelle `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indici per le tabelle `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indici per le tabelle `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indici per le tabelle `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `guests_booking_id_index` (`booking_id`);

--
-- Indici per le tabelle `ical_sources`
--
ALTER TABLE `ical_sources`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indici per le tabelle `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `length_discounts`
--
ALTER TABLE `length_discounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `length_discounts_min_nights_index` (`min_nights`),
  ADD KEY `length_discounts_is_active_index` (`is_active`);

--
-- Indici per le tabelle `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indici per le tabelle `pricing_rules`
--
ALTER TABLE `pricing_rules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pricing_rules_type_index` (`type`),
  ADD KEY `pricing_rules_is_active_index` (`is_active`),
  ADD KEY `pricing_rules_priority_index` (`priority`),
  ADD KEY `pricing_rules_start_date_end_date_index` (`start_date`,`end_date`);

--
-- Indici per le tabelle `public_bookings`
--
ALTER TABLE `public_bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `public_bookings_booking_id_foreign` (`booking_id`),
  ADD KEY `public_bookings_status_index` (`status`),
  ADD KEY `public_bookings_check_in_check_out_index` (`check_in`,`check_out`),
  ADD KEY `public_bookings_guest_email_index` (`guest_email`),
  ADD KEY `public_bookings_created_at_index` (`created_at`);

--
-- Indici per le tabelle `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indici per le tabelle `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indici per le tabelle `sync_logs`
--
ALTER TABLE `sync_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sync_logs_ical_source_id_foreign` (`ical_source_id`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `alloggiatiweb_logs`
--
ALTER TABLE `alloggiatiweb_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT per la tabella `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `guests`
--
ALTER TABLE `guests`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `ical_sources`
--
ALTER TABLE `ical_sources`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `length_discounts`
--
ALTER TABLE `length_discounts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT per la tabella `pricing_rules`
--
ALTER TABLE `pricing_rules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `public_bookings`
--
ALTER TABLE `public_bookings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT per la tabella `sync_logs`
--
ALTER TABLE `sync_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `alloggiatiweb_logs`
--
ALTER TABLE `alloggiatiweb_logs`
  ADD CONSTRAINT `alloggiatiweb_logs_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ical_source_id_foreign` FOREIGN KEY (`ical_source_id`) REFERENCES `ical_sources` (`id`) ON DELETE SET NULL;

--
-- Limiti per la tabella `guests`
--
ALTER TABLE `guests`
  ADD CONSTRAINT `guests_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Limiti per la tabella `public_bookings`
--
ALTER TABLE `public_bookings`
  ADD CONSTRAINT `public_bookings_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE SET NULL;

--
-- Limiti per la tabella `sync_logs`
--
ALTER TABLE `sync_logs`
  ADD CONSTRAINT `sync_logs_ical_source_id_foreign` FOREIGN KEY (`ical_source_id`) REFERENCES `ical_sources` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
