-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2024 at 09:48 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hospital_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admissions`
--

CREATE TABLE `admissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admission_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admission_date` date NOT NULL,
  `admission_time` time DEFAULT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `reference_id` int(11) DEFAULT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `bed_id` bigint(20) UNSIGNED NOT NULL,
  `bed_rent` double(8,2) NOT NULL,
  `received_amount` double(8,2) NOT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Admited',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `advice`
--

CREATE TABLE `advice` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `advice` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `agents`
--

CREATE TABLE `agents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `agent_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commission_percent` double(8,2) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ambulances`
--

CREATE TABLE `ambulances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_code` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reg_no` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `driver_id` bigint(20) UNSIGNED NOT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ambulance_bills`
--

CREATE TABLE `ambulance_bills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `driver_id` bigint(20) UNSIGNED NOT NULL,
  `ambulance_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `bill_date` date NOT NULL,
  `bill_amount` double(8,2) NOT NULL,
  `paid` double(8,2) NOT NULL,
  `due` double(8,2) NOT NULL,
  `destination` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `token_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time DEFAULT NULL,
  `serial_number` int(11) NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `reference_id` int(11) DEFAULT NULL,
  `fees` double(8,2) NOT NULL,
  `reference_commission_percent` double(8,2) NOT NULL DEFAULT 0.00,
  `reference_commission_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Pending',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank_accounts`
--

CREATE TABLE `bank_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `account_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `account_type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `branch_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank_transactions`
--

CREATE TABLE `bank_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bank_account_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_date` date NOT NULL,
  `transaction_type` enum('Deposit','Withdraw') COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double(8,2) NOT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `beds`
--

CREATE TABLE `beds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bed_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bed_shifts`
--

CREATE TABLE `bed_shifts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `admission_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `shift_date` date NOT NULL,
  `shift_time` time DEFAULT NULL,
  `from_room_id` bigint(20) UNSIGNED NOT NULL,
  `from_bed_id` bigint(20) UNSIGNED NOT NULL,
  `to_room_id` bigint(20) UNSIGNED NOT NULL,
  `to_bed_id` bigint(20) UNSIGNED NOT NULL,
  `bed_rent` double(8,2) NOT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bill_date` date NOT NULL,
  `transaction_type` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bill_type_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `admission_id` int(11) DEFAULT NULL,
  `amount` double(8,2) NOT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bill_types`
--

CREATE TABLE `bill_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `code`, `name`, `address`, `branch_logo`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `ip_address`, `status`) VALUES
(1, 'B00001', 'Branch Name', 'Address Here', NULL, NULL, NULL, '2023-05-06 08:33:20', '2023-05-06 08:33:20', NULL, NULL, 'a');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `ip_address`, `branch_id`) VALUES
(1, 'Novo', 1, 1, '2023-05-06 10:52:15', '2023-05-08 04:21:02', NULL, '127.0.0.1', 1),
(2, 'Square Pharma', 1, NULL, '2023-05-08 04:20:02', '2023-05-08 04:20:02', NULL, '127.0.0.1', 1),
(3, 'Beximco Pharma', 1, NULL, '2023-05-08 04:20:12', '2023-05-08 04:20:12', NULL, '127.0.0.1', 1),
(4, 'ACMI', 1, 1, '2023-05-08 04:20:18', '2023-05-08 04:20:41', NULL, '127.0.0.1', 1),
(5, 'Aristo Pharma', 1, NULL, '2023-05-08 04:20:26', '2023-05-08 04:20:26', NULL, '127.0.0.1', 1),
(6, 'ACI', 1, NULL, '2023-05-08 04:20:32', '2023-05-08 04:20:32', NULL, '127.0.0.1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cash_transactions`
--

CREATE TABLE `cash_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `transaction_date` date NOT NULL,
  `account_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_type` enum('Received','Payment') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Payment',
  `amount` double(8,2) NOT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `use_for` enum('Medicine','Instrument') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Medicine',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `use_for`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `ip_address`, `branch_id`) VALUES
(1, 'Omiprazol', 'Medicine', 1, NULL, '2023-05-06 10:51:36', '2023-05-06 10:51:36', NULL, '127.0.0.1', 1),
(2, 'Paracetamol', 'Medicine', 1, NULL, '2023-05-08 04:18:09', '2023-05-08 04:18:09', NULL, '127.0.0.1', 1),
(3, 'Metal', 'Instrument', 1, NULL, '2023-05-09 10:55:23', '2023-05-09 10:55:23', NULL, '127.0.0.1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cheif_complains`
--

CREATE TABLE `cheif_complains` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `chief_complain` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `commission_payments`
--

CREATE TABLE `commission_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reference_id` int(11) NOT NULL,
  `reference_type` enum('Agent','Doctor') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Agent',
  `payment_date` date NOT NULL,
  `transaction_type` enum('Payment','Received') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Payment',
  `payment_type` enum('Cash','Bank') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Cash',
  `account_id` int(11) DEFAULT NULL,
  `amount` double(8,2) NOT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_profiles`
--

CREATE TABLE `company_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_profiles`
--

INSERT INTO `company_profiles` (`id`, `name`, `phone`, `email`, `address`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'Link-Up Technology Ltd.', '+8801981800200', 'mail@linktechbd.com', 'Road -3, Plot -16 (Bilal Uddin Mansion), 4th & 5th Floor, Mirpur 10 (Behind Shah Ali Plaza), Dhaka-1216.', NULL, '2023-05-06 08:33:21', '2023-05-06 08:33:21');

-- --------------------------------------------------------

--
-- Table structure for table `damages`
--

CREATE TABLE `damages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `damage_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_id` int(11) NOT NULL,
  `damage_date` date NOT NULL,
  `quantity` double(8,2) NOT NULL,
  `purchase_rate` double(8,2) NOT NULL,
  `total_amount` double(8,2) NOT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `use_for` enum('Medicine','Instrument') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Medicine',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `damages`
--

INSERT INTO `damages` (`id`, `damage_code`, `item_id`, `damage_date`, `quantity`, `purchase_rate`, `total_amount`, `remark`, `use_for`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `ip_address`, `branch_id`) VALUES
(1, 'DM00001', 1, '2023-05-07', 10.00, 60.00, 600.00, '', 'Medicine', 1, NULL, '2023-05-07 09:58:43', '2023-05-07 11:15:33', '2023-05-07 11:15:33', '127.0.0.1', 1),
(2, 'DM00002', 1, '2023-05-07', 10.00, 60.00, 600.00, '', 'Medicine', 1, NULL, '2023-05-07 10:15:50', '2023-05-07 11:09:25', NULL, '127.0.0.1', 1),
(3, 'DM00003', 1, '2023-05-07', 15.00, 60.00, 900.00, '', 'Medicine', 1, NULL, '2023-05-07 10:33:40', '2023-05-07 11:09:46', NULL, '127.0.0.1', 1),
(4, 'DM00004', 2, '2023-05-08', 64.00, 10.00, 640.00, '', 'Medicine', 1, NULL, '2023-05-08 10:02:56', '2023-05-09 06:15:57', NULL, '127.0.0.1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `designations`
--

CREATE TABLE `designations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `education_level` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fees` double(8,2) NOT NULL,
  `commission_percent` double(8,2) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doses`
--

CREATE TABLE `doses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `doses` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `driver_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `durations`
--

CREATE TABLE `durations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bio_id` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `department_id` bigint(20) UNSIGNED NOT NULL,
  `designation_id` bigint(20) UNSIGNED NOT NULL,
  `joining_date` date NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` enum('Male','Female','Other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `merital_status` enum('Single','Married','Divorce','Widowed') COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` date NOT NULL,
  `father_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mother_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `present_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permanent_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary_range` double(8,2) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `floors`
--

CREATE TABLE `floors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `floor_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `floor_name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `generics`
--

CREATE TABLE `generics` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `generics`
--

INSERT INTO `generics` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `ip_address`, `branch_id`) VALUES
(1, 'Sirup', 1, 1, '2023-05-06 10:52:08', '2023-05-08 04:18:53', NULL, '127.0.0.1', 1),
(2, 'Capsul', 1, 1, '2023-05-06 10:52:08', '2023-05-08 04:18:47', NULL, '127.0.0.1', 1),
(3, 'Tablet', 1, 1, '2023-05-06 10:52:55', '2023-05-08 04:18:39', NULL, '127.0.0.1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `instruments`
--

CREATE TABLE `instruments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `instrument_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_price` double(18,2) NOT NULL,
  `reorder_level` double(8,2) NOT NULL DEFAULT 0.00,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `instruments`
--

INSERT INTO `instruments` (`id`, `instrument_code`, `name`, `category_id`, `unit_id`, `purchase_price`, `reorder_level`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `ip_address`, `branch_id`) VALUES
(1, 'I00001', 'Sizer', 3, 4, 500.00, 20.00, 1, NULL, '2023-05-09 10:59:44', '2023-05-09 10:59:44', NULL, '127.0.0.1', 1),
(2, 'I00002', 'Knife', 3, 4, 450.00, 20.00, 1, NULL, '2023-05-09 11:00:03', '2023-05-09 11:00:03', NULL, '127.0.0.1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `instrument_stocks`
--

CREATE TABLE `instrument_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `instrument_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_quantity` double(8,2) NOT NULL DEFAULT 0.00,
  `purchase_return_quantity` double(8,2) NOT NULL DEFAULT 0.00,
  `issue_quantity` double(8,2) NOT NULL DEFAULT 0.00,
  `issue_return_quantity` double(8,2) NOT NULL DEFAULT 0.00,
  `damage_quantity` double(8,2) NOT NULL DEFAULT 0.00,
  `stock_quantity` double(8,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `instrument_stocks`
--

INSERT INTO `instrument_stocks` (`id`, `instrument_id`, `purchase_quantity`, `purchase_return_quantity`, `issue_quantity`, `issue_return_quantity`, `damage_quantity`, `stock_quantity`, `created_at`, `updated_at`, `branch_id`) VALUES
(1, 2, 2.00, 0.00, 0.00, 0.00, 0.00, 2.00, '2023-05-09 11:00:18', '2023-05-09 11:00:18', 1),
(2, 1, 33.00, 16.00, 0.00, 0.00, 0.00, 17.00, '2023-05-09 11:00:33', '2023-05-09 11:00:33', 1);

-- --------------------------------------------------------

--
-- Table structure for table `issues`
--

CREATE TABLE `issues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `issue_date` date NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `issue_details`
--

CREATE TABLE `issue_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `issue_id` bigint(20) UNSIGNED NOT NULL,
  `instrument_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` double(8,2) NOT NULL,
  `purchase_rate` double(8,2) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `medicine_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `generic_id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `is_convert` tinyint(1) NOT NULL DEFAULT 0,
  `converter_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `convert_quantity` double(8,2) DEFAULT NULL,
  `purchase_price` double(8,2) NOT NULL,
  `sale_price` double(8,2) NOT NULL,
  `reorder_level` double(8,2) NOT NULL DEFAULT 0.00,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`id`, `medicine_code`, `name`, `category_id`, `generic_id`, `brand_id`, `unit_id`, `is_convert`, `converter_name`, `convert_quantity`, `purchase_price`, `sale_price`, `reorder_level`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `ip_address`, `branch_id`) VALUES
(1, 'M00001', 'Losectil 50mg', 1, 2, 1, 1, 0, 'box', 10.00, 60.00, 65.00, 55.00, 1, NULL, '2023-05-06 10:53:40', '2023-05-06 10:53:40', NULL, '127.0.0.1', 1),
(2, 'M00002', 'Napa 500mg', 2, 3, 3, 3, 1, 'Pack', 10.00, 10.00, 12.00, 0.00, 1, NULL, '2023-05-08 05:18:02', '2023-05-08 05:18:02', NULL, '127.0.0.1', 1),
(3, 'M00003', 'Napa Sirup', 2, 1, 3, 1, 0, NULL, 0.00, 45.00, 55.00, 0.00, 1, NULL, '2023-05-08 05:19:46', '2023-05-08 05:19:46', NULL, '127.0.0.1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `medicine_stocks`
--

CREATE TABLE `medicine_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `medicine_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_quantity` double(8,2) NOT NULL DEFAULT 0.00,
  `purchase_return_quantity` double(8,2) NOT NULL DEFAULT 0.00,
  `sales_quantity` double(8,2) NOT NULL DEFAULT 0.00,
  `sales_return_quantity` double(8,2) NOT NULL DEFAULT 0.00,
  `damage_quantity` double(8,2) NOT NULL DEFAULT 0.00,
  `stock_quantity` double(8,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medicine_stocks`
--

INSERT INTO `medicine_stocks` (`id`, `medicine_id`, `purchase_quantity`, `purchase_return_quantity`, `sales_quantity`, `sales_return_quantity`, `damage_quantity`, `stock_quantity`, `created_at`, `updated_at`, `branch_id`) VALUES
(1, 1, 85.00, 4.00, 0.00, 0.00, 20.00, 61.00, '2023-05-07 06:34:44', '2023-05-07 06:34:44', 1),
(2, 2, 234.00, 3.00, 0.00, 0.00, 64.00, 167.00, '2023-05-08 10:02:05', '2023-05-08 10:02:05', 1);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_11_000000_create_branches_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2023_03_02_064020_create_company_profiles_table', 1),
(6, '2023_03_14_090011_create_user_activities_table', 1),
(7, '2023_03_19_125228_create_patients_table', 1),
(8, '2023_03_19_184011_create_agents_table', 1),
(9, '2023_03_19_190435_create_doctors_table', 1),
(10, '2023_03_22_160905_create_appointments_table', 1),
(11, '2023_03_22_160905_create_departments_table', 1),
(12, '2023_03_22_160905_create_designations_table', 1),
(13, '2023_03_22_160905_create_employees_table', 1),
(14, '2023_03_22_161140_create_rooms_table', 1),
(15, '2023_03_22_161143_create_beds_table', 1),
(16, '2023_03_22_161144_create_admissions_table', 1),
(17, '2023_03_22_161146_create_bed_shifts_table', 1),
(18, '2023_03_22_161208_create_bill_types_table', 1),
(19, '2023_03_22_161209_create_bills_table', 1),
(20, '2023_03_22_162333_create_cheif_complains_table', 1),
(21, '2023_03_22_162333_create_doses_table', 1),
(22, '2023_03_22_162333_create_durations_table', 1),
(23, '2023_03_22_162357_create_advice_table', 1),
(24, '2023_03_22_162428_create_tests_table', 1),
(25, '2023_03_22_162450_create_units_table', 1),
(26, '2023_03_22_162452_create_brands_table', 1),
(27, '2023_03_22_162452_create_categories_table', 1),
(28, '2023_03_22_162452_create_generics_table', 1),
(29, '2023_03_22_162452_create_medicines_table', 1),
(30, '2023_03_22_162470_create_prescriptions_table', 1),
(31, '2023_03_22_162549_create_prescription_chief_complains_table', 1),
(32, '2023_03_22_162609_create_prescription_tests_table', 1),
(33, '2023_03_22_162632_create_prescription_advice_table', 1),
(34, '2023_03_22_162702_create_prescription_medicines_table', 1),
(35, '2023_03_22_162814_create_test_receipts_table', 1),
(36, '2023_03_22_162833_create_test_receipt_details_table', 1),
(37, '2023_03_22_163027_create_instruments_table', 1),
(38, '2023_03_22_163047_create_suppliers_table', 1),
(39, '2023_03_22_163132_create_purchases_table', 1),
(41, '2023_03_22_163212_create_issues_table', 1),
(42, '2023_03_22_163227_create_issue_details_table', 1),
(43, '2023_03_22_163323_create_sales_table', 1),
(44, '2023_03_22_163402_create_sale_details_table', 1),
(45, '2023_03_22_163544_create_damages_table', 1),
(46, '2023_03_22_163544_create_instrument_stocks_table', 1),
(47, '2023_03_22_163606_create_medicine_stocks_table', 1),
(48, '2023_03_22_163629_create_supplier_payments_table', 1),
(49, '2023_03_22_163647_create_patient_payments_table', 1),
(50, '2023_03_22_163829_create_drivers_table', 1),
(51, '2023_03_22_163857_create_ambulances_table', 1),
(52, '2023_03_22_163916_create_ambulance_bills_table', 1),
(53, '2023_03_22_163949_create_operation_schedules_table', 1),
(54, '2023_03_22_164016_create_accounts_table', 1),
(55, '2023_03_22_164034_create_bank_accounts_table', 1),
(56, '2023_03_22_164057_create_cash_transactions_table', 1),
(57, '2023_03_22_164119_create_bank_transactions_table', 1),
(58, '2023_03_22_164211_create_commission_payments_table', 1),
(59, '2023_03_22_164252_create_months_table', 1),
(60, '2023_03_22_164409_create_salaries_table', 1),
(61, '2023_03_22_164445_create_salary_details_table', 1),
(62, '2023_05_08_110107_create_purchase_returns_table', 2),
(63, '2023_05_08_110133_create_purchase_return_details_table', 2),
(64, '2023_05_08_110154_create_sale_returns_table', 2),
(65, '2023_05_08_110211_create_sale_return_details_table', 2),
(66, '2023_03_22_163148_create_purchase_details_table', 3),
(67, '2023_03_22_161139_create_floors_table', 4),
(68, '2023_05_20_165103_create_release_slips_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `months`
--

CREATE TABLE `months` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `operation_schedules`
--

CREATE TABLE `operation_schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `schedule_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `bill_date` date NOT NULL,
  `time_from` time NOT NULL,
  `time_to` time NOT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_done` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `patient_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('Male','Female','Other') COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patient_payments`
--

CREATE TABLE `patient_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `payment_date` date NOT NULL,
  `transaction_type` enum('Received','Payment') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Received',
  `payment_type` enum('Cash','Bank') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Cash',
  `account_id` int(11) DEFAULT NULL,
  `amount` double(8,2) NOT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `prescription_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prescription_date` date NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `patient_age` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body_weight` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `body_height` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blood_pressure` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prescription_advice`
--

CREATE TABLE `prescription_advice` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `prescription_id` bigint(20) UNSIGNED NOT NULL,
  `advice` text COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prescription_chief_complains`
--

CREATE TABLE `prescription_chief_complains` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `prescription_id` bigint(20) UNSIGNED NOT NULL,
  `chief_complain` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prescription_medicines`
--

CREATE TABLE `prescription_medicines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `prescription_id` bigint(20) UNSIGNED NOT NULL,
  `medicine_id` bigint(20) UNSIGNED NOT NULL,
  `doses` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `advice` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prescription_tests`
--

CREATE TABLE `prescription_tests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `prescription_id` bigint(20) UNSIGNED NOT NULL,
  `test_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `order_date` date NOT NULL,
  `subtotal` double(8,2) NOT NULL,
  `discount_percent` double(8,2) NOT NULL,
  `discount_amount` double(8,2) NOT NULL,
  `vat_percent` double(8,2) NOT NULL,
  `vat_amount` double(8,2) NOT NULL,
  `transport_cost` double(8,2) NOT NULL,
  `total` double(8,2) NOT NULL,
  `paid` double(8,2) NOT NULL,
  `due` double(8,2) NOT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `use_for` enum('Medicine','Instrument') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Medicine',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `invoice_number`, `supplier_id`, `order_date`, `subtotal`, `discount_percent`, `discount_amount`, `vat_percent`, `vat_amount`, `transport_cost`, `total`, `paid`, `due`, `remark`, `use_for`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `ip_address`, `status`, `branch_id`) VALUES
(1, 'PM00001', 1, '2023-05-07', 4200.00, 0.00, 0.00, 0.00, 0.00, 0.00, 4200.00, 0.00, 4200.00, NULL, 'Medicine', 1, NULL, '2023-05-07 06:34:44', '2023-05-07 06:34:44', NULL, '127.0.0.1', 'a', 1),
(2, 'PM00002', 1, '2023-05-08', 1480.00, 0.00, 0.00, 0.00, 0.00, 0.00, 1480.00, 0.00, 1480.00, NULL, 'Medicine', 1, NULL, '2023-05-08 10:02:04', '2023-05-08 10:02:04', NULL, '127.0.0.1', 'a', 1),
(5, 'PM00003', 1, '2023-05-10', 600.00, 0.00, 0.00, 0.00, 0.00, 0.00, 600.00, 0.00, 600.00, NULL, 'Medicine', 1, NULL, '2023-05-10 07:19:33', '2023-05-10 07:19:33', NULL, '127.0.0.1', 'a', 1),
(6, 'PM00004', 1, '2023-05-10', 420.00, 0.00, 0.00, 0.00, 0.00, 0.00, 420.00, 0.00, 420.00, NULL, 'Medicine', 1, NULL, '2023-05-10 07:21:48', '2023-05-10 07:21:48', NULL, '127.0.0.1', 'a', 1),
(7, 'PM00005', 1, '2023-05-10', 300.00, 0.00, 0.00, 0.00, 0.00, 0.00, 300.00, 0.00, 300.00, NULL, 'Medicine', 1, NULL, '2023-05-10 07:22:03', '2023-05-10 07:22:03', NULL, '127.0.0.1', 'a', 1),
(8, 'PM00006', 1, '2023-05-10', 440.00, 0.00, 0.00, 0.00, 0.00, 0.00, 440.00, 0.00, 440.00, NULL, 'Medicine', 1, NULL, '2023-05-10 07:25:37', '2023-05-10 07:25:37', NULL, '127.0.0.1', 'a', 1),
(9, 'PI00001', 2, '2023-05-10', 5000.00, 0.00, 0.00, 0.00, 0.00, 0.00, 5000.00, 5000.00, 0.00, NULL, 'Instrument', 1, NULL, '2023-05-10 09:12:50', '2023-05-10 09:12:50', NULL, '127.0.0.1', 'a', 1),
(10, 'PI00002', 2, '2023-05-10', 10000.00, 0.00, 0.00, 0.00, 0.00, 0.00, 10000.00, 10000.00, 0.00, NULL, 'Instrument', 1, NULL, '2023-05-10 09:46:13', '2023-05-10 09:46:13', NULL, '127.0.0.1', 'a', 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_details`
--

CREATE TABLE `purchase_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` double(8,2) NOT NULL,
  `purchase_rate` double(8,2) NOT NULL,
  `discount_percent` double(8,2) NOT NULL DEFAULT 0.00,
  `discount_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `total_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `converter_name` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `convert_quantity` double(8,2) NOT NULL DEFAULT 0.00,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `use_for` enum('Medicine','Instrument') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Medicine',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_details`
--

INSERT INTO `purchase_details` (`id`, `purchase_id`, `item_id`, `quantity`, `purchase_rate`, `discount_percent`, `discount_amount`, `total_amount`, `converter_name`, `convert_quantity`, `remark`, `use_for`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `ip_address`, `branch_id`) VALUES
(1, 6, 2, 42.00, 10.00, 0.00, 0.00, 420.00, NULL, 0.00, NULL, 'Medicine', 1, NULL, '2023-05-10 07:21:48', '2023-05-10 07:21:48', NULL, '127.0.0.1', 1),
(2, 7, 1, 5.00, 60.00, 0.00, 0.00, 300.00, NULL, 0.00, NULL, 'Medicine', 1, NULL, '2023-05-10 07:22:03', '2023-05-10 07:22:03', NULL, '127.0.0.1', 1),
(3, 8, 2, 44.00, 10.00, 0.00, 0.00, 440.00, NULL, 0.00, NULL, 'Medicine', 1, NULL, '2023-05-10 07:25:37', '2023-05-10 07:25:37', NULL, '127.0.0.1', 1),
(4, 9, 1, 10.00, 500.00, 0.00, 0.00, 5000.00, NULL, 0.00, NULL, 'Instrument', 1, NULL, '2023-05-10 09:12:51', '2023-05-10 09:12:51', NULL, '127.0.0.1', 1),
(5, 10, 1, 20.00, 500.00, 0.00, 0.00, 10000.00, NULL, 0.00, NULL, 'Instrument', 1, NULL, '2023-05-10 09:46:13', '2023-05-10 09:46:13', NULL, '127.0.0.1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_returns`
--

CREATE TABLE `purchase_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `return_date` date NOT NULL,
  `total_amount` double(8,2) NOT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `use_for` enum('Medicine','Instrument') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Medicine',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_returns`
--

INSERT INTO `purchase_returns` (`id`, `purchase_id`, `supplier_id`, `return_date`, `total_amount`, `remark`, `use_for`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `ip_address`, `status`, `branch_id`) VALUES
(7, 7, 1, '2023-05-10', 240.00, NULL, 'Medicine', 1, NULL, '2023-05-10 07:23:49', '2023-05-10 07:23:49', NULL, '127.0.0.1', 'a', 1),
(8, 6, 1, '2023-05-10', 20.00, NULL, 'Medicine', 1, NULL, '2023-05-10 07:24:31', '2023-05-10 07:24:31', NULL, '127.0.0.1', 'a', 1),
(9, 8, 1, '2023-05-10', 10.00, NULL, 'Medicine', 1, NULL, '2023-05-10 09:18:36', '2023-05-10 09:18:36', NULL, '127.0.0.1', 'a', 1),
(10, 9, 2, '2023-05-10', 1000.00, NULL, 'Instrument', 1, NULL, '2023-05-10 09:28:15', '2023-05-10 09:28:15', NULL, '127.0.0.1', 'a', 1),
(11, 9, 2, '2023-05-10', 1000.00, NULL, 'Instrument', 1, NULL, '2023-05-10 09:38:31', '2023-05-10 09:38:31', NULL, '127.0.0.1', 'a', 1),
(12, 9, 2, '2023-05-10', 500.00, NULL, 'Instrument', 1, NULL, '2023-05-10 09:44:50', '2023-05-10 09:44:50', NULL, '127.0.0.1', 'a', 1),
(13, 9, 2, '2023-05-10', 500.00, NULL, 'Instrument', 1, NULL, '2023-05-10 09:44:53', '2023-05-10 09:44:53', NULL, '127.0.0.1', 'a', 1),
(14, 9, 2, '2023-05-10', 500.00, NULL, 'Instrument', 1, NULL, '2023-05-10 09:44:54', '2023-05-10 09:44:54', NULL, '127.0.0.1', 'a', 1),
(15, 9, 2, '2023-05-10', 500.00, NULL, 'Instrument', 1, NULL, '2023-05-10 09:44:54', '2023-05-10 09:44:54', NULL, '127.0.0.1', 'a', 1),
(16, 9, 2, '2023-05-10', 500.00, NULL, 'Instrument', 1, NULL, '2023-05-10 09:44:55', '2023-05-10 09:44:55', NULL, '127.0.0.1', 'a', 1),
(17, 9, 2, '2023-05-10', 500.00, NULL, 'Instrument', 1, NULL, '2023-05-10 09:44:55', '2023-05-10 09:44:55', NULL, '127.0.0.1', 'a', 1),
(18, 9, 2, '2023-05-10', 500.00, NULL, 'Instrument', 1, NULL, '2023-05-10 09:44:55', '2023-05-10 09:44:55', NULL, '127.0.0.1', 'a', 1),
(19, 9, 2, '2023-05-10', 500.00, NULL, 'Instrument', 1, NULL, '2023-05-10 09:44:56', '2023-05-10 09:44:56', NULL, '127.0.0.1', 'a', 1),
(20, 9, 2, '2023-05-10', 500.00, NULL, 'Instrument', 1, NULL, '2023-05-10 09:44:56', '2023-05-10 09:44:56', NULL, '127.0.0.1', 'a', 1),
(21, 10, 2, '2023-05-10', 500.00, NULL, 'Instrument', 1, NULL, '2023-05-10 09:49:21', '2023-05-10 09:49:21', NULL, '127.0.0.1', 'a', 1),
(22, 10, 2, '2023-05-10', 500.00, NULL, 'Instrument', 1, NULL, '2023-05-10 10:10:40', '2023-05-10 10:10:40', NULL, '127.0.0.1', 'a', 1),
(23, 10, 2, '2023-05-10', 500.00, NULL, 'Instrument', 1, NULL, '2023-05-10 10:12:09', '2023-05-10 10:12:09', NULL, '127.0.0.1', 'a', 1),
(24, 10, 2, '2023-05-10', 2000.00, NULL, 'Instrument', 1, NULL, '2023-05-10 10:35:34', '2023-05-11 06:11:31', '2023-05-11 06:11:31', '127.0.0.1', 'a', 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_return_details`
--

CREATE TABLE `purchase_return_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_return_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` double(8,2) NOT NULL,
  `return_rate` double(8,2) NOT NULL,
  `total_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `converter_name` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `convert_quantity` double(8,2) NOT NULL DEFAULT 0.00,
  `use_for` enum('Medicine','Instrument') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Medicine',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_return_details`
--

INSERT INTO `purchase_return_details` (`id`, `purchase_return_id`, `item_id`, `quantity`, `return_rate`, `total_amount`, `converter_name`, `convert_quantity`, `use_for`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `ip_address`, `branch_id`) VALUES
(1, 7, 1, 4.00, 60.00, 240.00, NULL, 0.00, 'Medicine', 1, NULL, '2023-05-10 07:23:49', '2023-05-10 07:23:49', NULL, '127.0.0.1', 1),
(2, 8, 2, 2.00, 10.00, 20.00, NULL, 0.00, 'Medicine', 1, NULL, '2023-05-10 07:24:31', '2023-05-10 07:24:31', NULL, '127.0.0.1', 1),
(3, 9, 2, 1.00, 10.00, 10.00, NULL, 0.00, 'Medicine', 1, NULL, '2023-05-10 09:18:36', '2023-05-10 09:18:36', NULL, '127.0.0.1', 1),
(4, 10, 1, 2.00, 500.00, 1000.00, NULL, 0.00, 'Instrument', 1, NULL, '2023-05-10 09:28:15', '2023-05-10 09:28:15', NULL, '127.0.0.1', 1),
(5, 11, 1, 2.00, 500.00, 1000.00, NULL, 0.00, 'Instrument', 1, NULL, '2023-05-10 09:38:31', '2023-05-10 09:38:31', NULL, '127.0.0.1', 1),
(6, 12, 1, 1.00, 500.00, 500.00, NULL, 0.00, 'Instrument', 1, NULL, '2023-05-10 09:44:50', '2023-05-10 09:44:50', NULL, '127.0.0.1', 1),
(7, 13, 1, 1.00, 500.00, 500.00, NULL, 0.00, 'Instrument', 1, NULL, '2023-05-10 09:44:53', '2023-05-10 09:44:53', NULL, '127.0.0.1', 1),
(8, 14, 1, 1.00, 500.00, 500.00, NULL, 0.00, 'Instrument', 1, NULL, '2023-05-10 09:44:54', '2023-05-10 09:44:54', NULL, '127.0.0.1', 1),
(9, 15, 1, 1.00, 500.00, 500.00, NULL, 0.00, 'Instrument', 1, NULL, '2023-05-10 09:44:54', '2023-05-10 09:44:54', NULL, '127.0.0.1', 1),
(10, 16, 1, 1.00, 500.00, 500.00, NULL, 0.00, 'Instrument', 1, NULL, '2023-05-10 09:44:55', '2023-05-10 09:44:55', NULL, '127.0.0.1', 1),
(11, 17, 1, 1.00, 500.00, 500.00, NULL, 0.00, 'Instrument', 1, NULL, '2023-05-10 09:44:55', '2023-05-10 09:44:55', NULL, '127.0.0.1', 1),
(12, 18, 1, 1.00, 500.00, 500.00, NULL, 0.00, 'Instrument', 1, NULL, '2023-05-10 09:44:55', '2023-05-10 09:44:55', NULL, '127.0.0.1', 1),
(13, 19, 1, 1.00, 500.00, 500.00, NULL, 0.00, 'Instrument', 1, NULL, '2023-05-10 09:44:56', '2023-05-10 09:44:56', NULL, '127.0.0.1', 1),
(14, 20, 1, 1.00, 500.00, 500.00, NULL, 0.00, 'Instrument', 1, NULL, '2023-05-10 09:44:56', '2023-05-10 09:44:56', NULL, '127.0.0.1', 1),
(15, 21, 1, 1.00, 500.00, 500.00, NULL, 0.00, 'Instrument', 1, NULL, '2023-05-10 09:49:21', '2023-05-10 09:49:21', NULL, '127.0.0.1', 1),
(16, 22, 1, 1.00, 500.00, 500.00, NULL, 0.00, 'Instrument', 1, NULL, '2023-05-10 10:10:40', '2023-05-10 10:10:40', NULL, '127.0.0.1', 1),
(17, 23, 1, 1.00, 500.00, 500.00, NULL, 0.00, 'Instrument', 1, NULL, '2023-05-10 10:12:09', '2023-05-10 10:12:09', NULL, '127.0.0.1', 1),
(19, 24, 1, 4.00, 500.00, 2000.00, NULL, 0.00, 'Instrument', 1, NULL, '2023-05-11 06:02:45', '2023-05-11 06:11:31', '2023-05-11 06:11:31', '127.0.0.1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `release_slips`
--

CREATE TABLE `release_slips` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `releaseslip_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slip_date` date NOT NULL,
  `slip_time` time DEFAULT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `doctor_id` bigint(20) UNSIGNED NOT NULL,
  `admission_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `bed_id` bigint(20) UNSIGNED NOT NULL,
  `admission_fees` double(8,2) NOT NULL DEFAULT 0.00,
  `bills_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `pathology_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `pharmacy_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `hospital_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `ot_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `due` double(8,2) NOT NULL,
  `previous_paid` double(8,2) NOT NULL,
  `discount` double(8,2) NOT NULL,
  `amount` double(8,2) NOT NULL DEFAULT 0.00,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Release',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `room_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `floor_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salaries`
--

CREATE TABLE `salaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_date` date NOT NULL,
  `month_id` bigint(20) UNSIGNED NOT NULL,
  `total_payment_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary_details`
--

CREATE TABLE `salary_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `salary_id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` bigint(20) UNSIGNED NOT NULL,
  `salary` double(8,2) NOT NULL,
  `benefit` double(8,2) NOT NULL,
  `deduction` double(8,2) NOT NULL,
  `net_payable` double(8,2) NOT NULL,
  `payment` double(8,2) NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `order_date` date NOT NULL,
  `subtotal` double(8,2) NOT NULL,
  `discount_percent` double(8,2) NOT NULL,
  `discount_amount` double(8,2) NOT NULL,
  `vat_percent` double(8,2) NOT NULL,
  `vat_amount` double(8,2) NOT NULL,
  `total` double(8,2) NOT NULL,
  `paid` double(8,2) NOT NULL,
  `due` double(8,2) NOT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_details`
--

CREATE TABLE `sale_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `medicine_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` double(8,2) NOT NULL,
  `purchase_rate` double(8,2) NOT NULL,
  `sale_rate` double(8,2) NOT NULL,
  `total_sale_rate` double(8,2) NOT NULL,
  `discount_percent` double(8,2) NOT NULL DEFAULT 0.00,
  `discount_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `total_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_returns`
--

CREATE TABLE `sale_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_id` bigint(20) UNSIGNED NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `return_date` date NOT NULL,
  `total_amount` double(8,2) NOT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sale_return_details`
--

CREATE TABLE `sale_return_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_return_id` bigint(20) UNSIGNED NOT NULL,
  `medicine_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` double(8,2) NOT NULL,
  `return_rate` double(8,2) NOT NULL,
  `total_amount` double(8,2) NOT NULL DEFAULT 0.00,
  `converter_name` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `convert_quantity` double(8,2) NOT NULL DEFAULT 0.00,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `use_for` enum('Medicine','Instrument') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Medicine',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `supplier_code`, `name`, `owner_name`, `mobile`, `address`, `remark`, `image`, `use_for`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `ip_address`, `status`, `branch_id`) VALUES
(1, 'SM00001', 'Mr. Supplier 1', 'Mr. Supplier\'s Father', '01452156322', 'Mirpur, Dhaka', 'Hello this is Mr. Supplier 1', NULL, 'Medicine', 1, 1, '2023-05-07 06:29:02', '2023-05-07 06:29:09', NULL, '127.0.0.1', 'a', 1),
(2, 'SI00001', 'Mehedi', 'Mehedi', '01418435435', 'Mirpur', '1000', NULL, 'Instrument', 1, NULL, '2023-05-09 10:54:42', '2023-05-09 10:54:42', NULL, '127.0.0.1', 'a', 1);

-- --------------------------------------------------------

--
-- Table structure for table `supplier_payments`
--

CREATE TABLE `supplier_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaction_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `payment_date` date NOT NULL,
  `transaction_type` enum('Payment','Received') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Payment',
  `payment_type` enum('Cash','Bank') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Cash',
  `account_id` int(11) DEFAULT NULL,
  `amount` double(8,2) NOT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `use_for` enum('Medicine','Instrument') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Medicine',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `test_code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `room_number` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(8,2) NOT NULL,
  `day` int(11) DEFAULT NULL,
  `hour` int(11) DEFAULT NULL,
  `minute` int(11) DEFAULT NULL,
  `template` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `test_receipts`
--

CREATE TABLE `test_receipts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_number` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bill_date` date NOT NULL,
  `patient_id` bigint(20) UNSIGNED NOT NULL,
  `admission_id` int(11) DEFAULT NULL,
  `reference_id` int(11) DEFAULT NULL,
  `subtotal` double(8,2) NOT NULL,
  `vat_percent` double(8,2) NOT NULL,
  `vat_amount` double(8,2) NOT NULL,
  `discount_percent` double(8,2) NOT NULL,
  `discount_amount` double(8,2) NOT NULL,
  `others` double(8,2) NOT NULL DEFAULT 0.00,
  `total` double(8,2) NOT NULL,
  `paid` double(8,2) NOT NULL,
  `due` double(8,2) NOT NULL,
  `is_completed` tinyint(1) NOT NULL DEFAULT 0,
  `is_delivered` tinyint(1) NOT NULL DEFAULT 0,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `test_receipt_details`
--

CREATE TABLE `test_receipt_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `test_receipt_id` bigint(20) UNSIGNED NOT NULL,
  `test_id` bigint(20) UNSIGNED NOT NULL,
  `delivery_date` date NOT NULL,
  `delivery_time` time DEFAULT NULL,
  `amount` double(8,2) NOT NULL,
  `is_completed` tinyint(1) NOT NULL DEFAULT 0,
  `is_delivered` tinyint(1) NOT NULL DEFAULT 0,
  `report` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `use_for` enum('Medicine','Instrument') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Medicine',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `use_for`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `ip_address`, `branch_id`) VALUES
(1, 'Piece', 'Medicine', 1, 1, '2023-05-06 10:52:28', '2023-05-08 04:21:27', NULL, '127.0.0.1', 1),
(2, 'Box', 'Medicine', 1, NULL, '2023-05-08 04:19:17', '2023-05-08 04:19:17', NULL, '127.0.0.1', 1),
(3, 'Pack', 'Medicine', 1, NULL, '2023-05-08 04:24:53', '2023-05-08 04:24:53', NULL, '127.0.0.1', 1),
(4, 'Piece', 'Instrument', 1, NULL, '2023-05-09 10:55:47', '2023-05-09 10:55:47', NULL, '127.0.0.1', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('Super Admin','Admin','Doctor','Entry User','User') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'User',
  `doctor_id` int(11) DEFAULT NULL,
  `permissions` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` char(2) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'a' COMMENT 'a=active, d=deactive',
  `branch_id` int(11) NOT NULL DEFAULT 1,
  `logout` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `image`, `role`, `doctor_id`, `permissions`, `remember_token`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`, `ip_address`, `status`, `branch_id`, `logout`) VALUES
(1, 'Super Admin', 'superadmin', '$2a$12$zLZ3NsNC3O2d4RNGye.wG.isaup/8kvs9bO8CBM2sXtVf7AqRjbPS', NULL, 'Super Admin', NULL, NULL, NULL, NULL, NULL, '2023-05-06 08:33:21', '2023-05-06 08:33:21', NULL, NULL, 'a', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_activities`
--

CREATE TABLE `user_activities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `login_time` datetime NOT NULL,
  `logout_time` datetime DEFAULT NULL,
  `ip_address` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_activities`
--

INSERT INTO `user_activities` (`id`, `user_id`, `login_time`, `logout_time`, `ip_address`, `branch_id`) VALUES
(1, 1, '2023-05-06 14:34:16', NULL, '127.0.0.1', 1),
(2, 1, '2023-05-06 16:26:06', '2023-05-06 17:41:01', '127.0.0.1', 1),
(3, 1, '2023-05-06 17:41:09', NULL, '127.0.0.1', 1),
(4, 1, '2023-05-07 09:49:01', '2023-05-07 10:02:49', '127.0.0.1', 1),
(5, 1, '2023-05-07 10:02:56', NULL, '127.0.0.1', 1),
(6, 1, '2023-05-08 09:52:42', NULL, '127.0.0.1', 1),
(7, 1, '2023-05-09 10:28:21', NULL, '127.0.0.1', 1),
(8, 1, '2023-05-09 14:52:53', NULL, '127.0.0.1', 1),
(9, 1, '2023-05-10 09:59:34', NULL, '127.0.0.1', 1),
(10, 1, '2023-05-11 10:26:39', NULL, '127.0.0.1', 1),
(11, 1, '2023-08-31 09:23:00', '2023-08-31 09:33:28', '127.0.0.1', 1),
(12, 1, '2023-08-31 09:33:50', '2023-08-31 09:35:17', '127.0.0.1', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `accounts_account_code_unique` (`account_code`),
  ADD KEY `accounts_status_index` (`status`),
  ADD KEY `accounts_branch_id_index` (`branch_id`);

--
-- Indexes for table `admissions`
--
ALTER TABLE `admissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admissions_admission_code_unique` (`admission_code`),
  ADD KEY `admissions_patient_id_foreign` (`patient_id`),
  ADD KEY `admissions_doctor_id_foreign` (`doctor_id`),
  ADD KEY `admissions_room_id_foreign` (`room_id`),
  ADD KEY `admissions_bed_id_foreign` (`bed_id`),
  ADD KEY `admissions_admission_date_index` (`admission_date`),
  ADD KEY `admissions_status_index` (`status`),
  ADD KEY `admissions_branch_id_index` (`branch_id`);

--
-- Indexes for table `advice`
--
ALTER TABLE `advice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `advice_doctor_id_foreign` (`doctor_id`),
  ADD KEY `advice_status_index` (`status`),
  ADD KEY `advice_branch_id_index` (`branch_id`);

--
-- Indexes for table `agents`
--
ALTER TABLE `agents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `agents_agent_code_unique` (`agent_code`),
  ADD KEY `agents_mobile_index` (`mobile`),
  ADD KEY `agents_status_index` (`status`),
  ADD KEY `agents_branch_id_index` (`branch_id`);

--
-- Indexes for table `ambulances`
--
ALTER TABLE `ambulances`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ambulances_vehicle_code_unique` (`vehicle_code`),
  ADD UNIQUE KEY `ambulances_reg_no_unique` (`reg_no`),
  ADD KEY `ambulances_driver_id_foreign` (`driver_id`),
  ADD KEY `ambulances_status_index` (`status`),
  ADD KEY `ambulances_branch_id_index` (`branch_id`);

--
-- Indexes for table `ambulance_bills`
--
ALTER TABLE `ambulance_bills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ambulance_bills_invoice_number_unique` (`invoice_number`),
  ADD KEY `ambulance_bills_driver_id_foreign` (`driver_id`),
  ADD KEY `ambulance_bills_ambulance_id_foreign` (`ambulance_id`),
  ADD KEY `ambulance_bills_patient_id_foreign` (`patient_id`),
  ADD KEY `ambulance_bills_bill_date_index` (`bill_date`),
  ADD KEY `ambulance_bills_status_index` (`status`),
  ADD KEY `ambulance_bills_branch_id_index` (`branch_id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `appointments_token_number_unique` (`token_number`),
  ADD KEY `appointments_doctor_id_foreign` (`doctor_id`),
  ADD KEY `appointments_patient_id_foreign` (`patient_id`),
  ADD KEY `appointments_appointment_date_index` (`appointment_date`),
  ADD KEY `appointments_status_index` (`status`),
  ADD KEY `appointments_branch_id_index` (`branch_id`);

--
-- Indexes for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bank_accounts_status_index` (`status`),
  ADD KEY `bank_accounts_branch_id_index` (`branch_id`);

--
-- Indexes for table `bank_transactions`
--
ALTER TABLE `bank_transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bank_transactions_transaction_number_unique` (`transaction_number`),
  ADD KEY `bank_transactions_bank_account_id_foreign` (`bank_account_id`),
  ADD KEY `bank_transactions_transaction_date_index` (`transaction_date`),
  ADD KEY `bank_transactions_transaction_type_index` (`transaction_type`),
  ADD KEY `bank_transactions_status_index` (`status`),
  ADD KEY `bank_transactions_branch_id_index` (`branch_id`);

--
-- Indexes for table `beds`
--
ALTER TABLE `beds`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `beds_bed_number_unique` (`bed_number`),
  ADD KEY `beds_room_id_foreign` (`room_id`),
  ADD KEY `beds_status_index` (`status`),
  ADD KEY `beds_branch_id_index` (`branch_id`);

--
-- Indexes for table `bed_shifts`
--
ALTER TABLE `bed_shifts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bed_shifts_admission_id_foreign` (`admission_id`),
  ADD KEY `bed_shifts_patient_id_foreign` (`patient_id`),
  ADD KEY `bed_shifts_from_room_id_foreign` (`from_room_id`),
  ADD KEY `bed_shifts_from_bed_id_foreign` (`from_bed_id`),
  ADD KEY `bed_shifts_to_room_id_foreign` (`to_room_id`),
  ADD KEY `bed_shifts_to_bed_id_foreign` (`to_bed_id`),
  ADD KEY `bed_shifts_shift_date_index` (`shift_date`),
  ADD KEY `bed_shifts_branch_id_index` (`branch_id`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bills_transaction_number_unique` (`transaction_number`),
  ADD KEY `bills_bill_type_id_foreign` (`bill_type_id`),
  ADD KEY `bills_patient_id_foreign` (`patient_id`),
  ADD KEY `bills_bill_date_index` (`bill_date`),
  ADD KEY `bills_transaction_type_index` (`transaction_type`),
  ADD KEY `bills_branch_id_index` (`branch_id`);

--
-- Indexes for table `bill_types`
--
ALTER TABLE `bill_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_types_status_index` (`status`),
  ADD KEY `bill_types_branch_id_index` (`branch_id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `branches_code_unique` (`code`),
  ADD KEY `branches_status_index` (`status`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brands_branch_id_index` (`branch_id`);

--
-- Indexes for table `cash_transactions`
--
ALTER TABLE `cash_transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cash_transactions_transaction_number_unique` (`transaction_number`),
  ADD KEY `cash_transactions_account_id_foreign` (`account_id`),
  ADD KEY `cash_transactions_transaction_date_index` (`transaction_date`),
  ADD KEY `cash_transactions_transaction_type_index` (`transaction_type`),
  ADD KEY `cash_transactions_status_index` (`status`),
  ADD KEY `cash_transactions_branch_id_index` (`branch_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_use_for_index` (`use_for`),
  ADD KEY `categories_branch_id_index` (`branch_id`);

--
-- Indexes for table `cheif_complains`
--
ALTER TABLE `cheif_complains`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cheif_complains_doctor_id_foreign` (`doctor_id`),
  ADD KEY `cheif_complains_status_index` (`status`),
  ADD KEY `cheif_complains_branch_id_index` (`branch_id`);

--
-- Indexes for table `commission_payments`
--
ALTER TABLE `commission_payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `commission_payments_transaction_number_unique` (`transaction_number`),
  ADD KEY `commission_payments_reference_id_index` (`reference_id`),
  ADD KEY `commission_payments_reference_type_index` (`reference_type`),
  ADD KEY `commission_payments_payment_date_index` (`payment_date`),
  ADD KEY `commission_payments_transaction_type_index` (`transaction_type`),
  ADD KEY `commission_payments_payment_type_index` (`payment_type`),
  ADD KEY `commission_payments_account_id_index` (`account_id`),
  ADD KEY `commission_payments_status_index` (`status`),
  ADD KEY `commission_payments_branch_id_index` (`branch_id`);

--
-- Indexes for table `company_profiles`
--
ALTER TABLE `company_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `damages`
--
ALTER TABLE `damages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `damages_damage_code_unique` (`damage_code`),
  ADD KEY `damages_item_id_index` (`item_id`),
  ADD KEY `damages_damage_date_index` (`damage_date`),
  ADD KEY `damages_use_for_index` (`use_for`),
  ADD KEY `damages_branch_id_index` (`branch_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departments_branch_id_index` (`branch_id`);

--
-- Indexes for table `designations`
--
ALTER TABLE `designations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `designations_branch_id_index` (`branch_id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `doctors_doctor_code_unique` (`doctor_code`),
  ADD KEY `doctors_mobile_index` (`mobile`),
  ADD KEY `doctors_status_index` (`status`),
  ADD KEY `doctors_branch_id_index` (`branch_id`);

--
-- Indexes for table `doses`
--
ALTER TABLE `doses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doses_doctor_id_foreign` (`doctor_id`),
  ADD KEY `doses_status_index` (`status`),
  ADD KEY `doses_branch_id_index` (`branch_id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `drivers_driver_code_unique` (`driver_code`),
  ADD KEY `drivers_mobile_index` (`mobile`),
  ADD KEY `drivers_status_index` (`status`),
  ADD KEY `drivers_branch_id_index` (`branch_id`);

--
-- Indexes for table `durations`
--
ALTER TABLE `durations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `durations_doctor_id_foreign` (`doctor_id`),
  ADD KEY `durations_status_index` (`status`),
  ADD KEY `durations_branch_id_index` (`branch_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_employee_code_unique` (`employee_code`),
  ADD UNIQUE KEY `employees_bio_id_unique` (`bio_id`),
  ADD KEY `employees_department_id_foreign` (`department_id`),
  ADD KEY `employees_designation_id_foreign` (`designation_id`),
  ADD KEY `employees_joining_date_index` (`joining_date`),
  ADD KEY `employees_gender_index` (`gender`),
  ADD KEY `employees_merital_status_index` (`merital_status`),
  ADD KEY `employees_status_index` (`status`),
  ADD KEY `employees_branch_id_index` (`branch_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `floors`
--
ALTER TABLE `floors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `floors_floor_number_unique` (`floor_number`),
  ADD KEY `floors_branch_id_index` (`branch_id`);

--
-- Indexes for table `generics`
--
ALTER TABLE `generics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `generics_branch_id_index` (`branch_id`);

--
-- Indexes for table `instruments`
--
ALTER TABLE `instruments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `instruments_instrument_code_unique` (`instrument_code`),
  ADD KEY `instruments_category_id_foreign` (`category_id`),
  ADD KEY `instruments_unit_id_foreign` (`unit_id`),
  ADD KEY `instruments_branch_id_index` (`branch_id`);

--
-- Indexes for table `instrument_stocks`
--
ALTER TABLE `instrument_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `instrument_stocks_instrument_id_foreign` (`instrument_id`),
  ADD KEY `instrument_stocks_branch_id_index` (`branch_id`);

--
-- Indexes for table `issues`
--
ALTER TABLE `issues`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `issues_invoice_number_unique` (`invoice_number`),
  ADD KEY `issues_employee_id_foreign` (`employee_id`),
  ADD KEY `issues_issue_date_index` (`issue_date`),
  ADD KEY `issues_status_index` (`status`),
  ADD KEY `issues_branch_id_index` (`branch_id`);

--
-- Indexes for table `issue_details`
--
ALTER TABLE `issue_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `issue_details_issue_id_foreign` (`issue_id`),
  ADD KEY `issue_details_instrument_id_foreign` (`instrument_id`),
  ADD KEY `issue_details_branch_id_index` (`branch_id`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `medicines_medicine_code_unique` (`medicine_code`),
  ADD KEY `medicines_category_id_foreign` (`category_id`),
  ADD KEY `medicines_generic_id_foreign` (`generic_id`),
  ADD KEY `medicines_brand_id_foreign` (`brand_id`),
  ADD KEY `medicines_unit_id_foreign` (`unit_id`),
  ADD KEY `medicines_branch_id_index` (`branch_id`);

--
-- Indexes for table `medicine_stocks`
--
ALTER TABLE `medicine_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medicine_stocks_medicine_id_foreign` (`medicine_id`),
  ADD KEY `medicine_stocks_branch_id_index` (`branch_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `months`
--
ALTER TABLE `months`
  ADD PRIMARY KEY (`id`),
  ADD KEY `months_branch_id_index` (`branch_id`);

--
-- Indexes for table `operation_schedules`
--
ALTER TABLE `operation_schedules`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `operation_schedules_schedule_code_unique` (`schedule_code`),
  ADD KEY `operation_schedules_doctor_id_foreign` (`doctor_id`),
  ADD KEY `operation_schedules_room_id_foreign` (`room_id`),
  ADD KEY `operation_schedules_patient_id_foreign` (`patient_id`),
  ADD KEY `operation_schedules_bill_date_index` (`bill_date`),
  ADD KEY `operation_schedules_time_from_index` (`time_from`),
  ADD KEY `operation_schedules_time_to_index` (`time_to`),
  ADD KEY `operation_schedules_status_index` (`status`),
  ADD KEY `operation_schedules_branch_id_index` (`branch_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patients_patient_code_unique` (`patient_code`),
  ADD KEY `patients_mobile_index` (`mobile`),
  ADD KEY `patients_gender_index` (`gender`),
  ADD KEY `patients_status_index` (`status`),
  ADD KEY `patients_branch_id_index` (`branch_id`);

--
-- Indexes for table `patient_payments`
--
ALTER TABLE `patient_payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `patient_payments_transaction_number_unique` (`transaction_number`),
  ADD KEY `patient_payments_patient_id_foreign` (`patient_id`),
  ADD KEY `patient_payments_payment_date_index` (`payment_date`),
  ADD KEY `patient_payments_transaction_type_index` (`transaction_type`),
  ADD KEY `patient_payments_payment_type_index` (`payment_type`),
  ADD KEY `patient_payments_account_id_index` (`account_id`),
  ADD KEY `patient_payments_status_index` (`status`),
  ADD KEY `patient_payments_branch_id_index` (`branch_id`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `prescriptions_prescription_code_unique` (`prescription_code`),
  ADD KEY `prescriptions_patient_id_foreign` (`patient_id`),
  ADD KEY `prescriptions_doctor_id_foreign` (`doctor_id`),
  ADD KEY `prescriptions_prescription_date_index` (`prescription_date`),
  ADD KEY `prescriptions_branch_id_index` (`branch_id`);

--
-- Indexes for table `prescription_advice`
--
ALTER TABLE `prescription_advice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prescription_advice_prescription_id_foreign` (`prescription_id`);

--
-- Indexes for table `prescription_chief_complains`
--
ALTER TABLE `prescription_chief_complains`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prescription_chief_complains_prescription_id_foreign` (`prescription_id`);

--
-- Indexes for table `prescription_medicines`
--
ALTER TABLE `prescription_medicines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prescription_medicines_prescription_id_foreign` (`prescription_id`),
  ADD KEY `prescription_medicines_medicine_id_foreign` (`medicine_id`);

--
-- Indexes for table `prescription_tests`
--
ALTER TABLE `prescription_tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prescription_tests_prescription_id_foreign` (`prescription_id`),
  ADD KEY `prescription_tests_test_id_foreign` (`test_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purchases_invoice_number_unique` (`invoice_number`),
  ADD KEY `purchases_supplier_id_foreign` (`supplier_id`),
  ADD KEY `purchases_order_date_index` (`order_date`),
  ADD KEY `purchases_use_for_index` (`use_for`),
  ADD KEY `purchases_status_index` (`status`),
  ADD KEY `purchases_branch_id_index` (`branch_id`);

--
-- Indexes for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_details_purchase_id_foreign` (`purchase_id`),
  ADD KEY `purchase_details_item_id_index` (`item_id`),
  ADD KEY `purchase_details_use_for_index` (`use_for`),
  ADD KEY `purchase_details_branch_id_index` (`branch_id`);

--
-- Indexes for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_returns_purchase_id_foreign` (`purchase_id`),
  ADD KEY `purchase_returns_supplier_id_foreign` (`supplier_id`),
  ADD KEY `purchase_returns_return_date_index` (`return_date`),
  ADD KEY `purchase_returns_use_for_index` (`use_for`),
  ADD KEY `purchase_returns_status_index` (`status`),
  ADD KEY `purchase_returns_branch_id_index` (`branch_id`);

--
-- Indexes for table `purchase_return_details`
--
ALTER TABLE `purchase_return_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_return_details_purchase_return_id_foreign` (`purchase_return_id`),
  ADD KEY `purchase_return_details_item_id_index` (`item_id`),
  ADD KEY `purchase_return_details_use_for_index` (`use_for`),
  ADD KEY `purchase_return_details_branch_id_index` (`branch_id`);

--
-- Indexes for table `release_slips`
--
ALTER TABLE `release_slips`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `release_slips_releaseslip_code_unique` (`releaseslip_code`),
  ADD KEY `release_slips_patient_id_foreign` (`patient_id`),
  ADD KEY `release_slips_doctor_id_foreign` (`doctor_id`),
  ADD KEY `release_slips_admission_id_foreign` (`admission_id`),
  ADD KEY `release_slips_room_id_foreign` (`room_id`),
  ADD KEY `release_slips_bed_id_foreign` (`bed_id`),
  ADD KEY `release_slips_slip_date_index` (`slip_date`),
  ADD KEY `release_slips_slip_time_index` (`slip_time`),
  ADD KEY `release_slips_status_index` (`status`),
  ADD KEY `release_slips_branch_id_index` (`branch_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `rooms_room_number_unique` (`room_number`),
  ADD KEY `rooms_status_index` (`status`),
  ADD KEY `rooms_branch_id_index` (`branch_id`);

--
-- Indexes for table `salaries`
--
ALTER TABLE `salaries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `salaries_transaction_number_unique` (`transaction_number`),
  ADD KEY `salaries_month_id_foreign` (`month_id`),
  ADD KEY `salaries_payment_date_index` (`payment_date`),
  ADD KEY `salaries_status_index` (`status`),
  ADD KEY `salaries_branch_id_index` (`branch_id`);

--
-- Indexes for table `salary_details`
--
ALTER TABLE `salary_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salary_details_salary_id_foreign` (`salary_id`),
  ADD KEY `salary_details_employee_id_foreign` (`employee_id`),
  ADD KEY `salary_details_status_index` (`status`),
  ADD KEY `salary_details_branch_id_index` (`branch_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sales_invoice_number_unique` (`invoice_number`),
  ADD KEY `sales_patient_id_foreign` (`patient_id`),
  ADD KEY `sales_order_date_index` (`order_date`),
  ADD KEY `sales_status_index` (`status`),
  ADD KEY `sales_branch_id_index` (`branch_id`);

--
-- Indexes for table `sale_details`
--
ALTER TABLE `sale_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_details_sale_id_foreign` (`sale_id`),
  ADD KEY `sale_details_medicine_id_foreign` (`medicine_id`),
  ADD KEY `sale_details_branch_id_index` (`branch_id`);

--
-- Indexes for table `sale_returns`
--
ALTER TABLE `sale_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_returns_sale_id_foreign` (`sale_id`),
  ADD KEY `sale_returns_patient_id_foreign` (`patient_id`),
  ADD KEY `sale_returns_return_date_index` (`return_date`),
  ADD KEY `sale_returns_status_index` (`status`),
  ADD KEY `sale_returns_branch_id_index` (`branch_id`);

--
-- Indexes for table `sale_return_details`
--
ALTER TABLE `sale_return_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_return_details_sale_return_id_foreign` (`sale_return_id`),
  ADD KEY `sale_return_details_medicine_id_foreign` (`medicine_id`),
  ADD KEY `sale_return_details_branch_id_index` (`branch_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `suppliers_supplier_code_unique` (`supplier_code`),
  ADD KEY `suppliers_mobile_index` (`mobile`),
  ADD KEY `suppliers_use_for_index` (`use_for`),
  ADD KEY `suppliers_status_index` (`status`),
  ADD KEY `suppliers_branch_id_index` (`branch_id`);

--
-- Indexes for table `supplier_payments`
--
ALTER TABLE `supplier_payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `supplier_payments_transaction_number_unique` (`transaction_number`),
  ADD KEY `supplier_payments_supplier_id_foreign` (`supplier_id`),
  ADD KEY `supplier_payments_payment_date_index` (`payment_date`),
  ADD KEY `supplier_payments_transaction_type_index` (`transaction_type`),
  ADD KEY `supplier_payments_payment_type_index` (`payment_type`),
  ADD KEY `supplier_payments_account_id_index` (`account_id`),
  ADD KEY `supplier_payments_use_for_index` (`use_for`),
  ADD KEY `supplier_payments_status_index` (`status`),
  ADD KEY `supplier_payments_branch_id_index` (`branch_id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tests_test_code_unique` (`test_code`),
  ADD KEY `tests_branch_id_index` (`branch_id`);

--
-- Indexes for table `test_receipts`
--
ALTER TABLE `test_receipts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `test_receipts_invoice_number_unique` (`invoice_number`),
  ADD KEY `test_receipts_patient_id_foreign` (`patient_id`),
  ADD KEY `test_receipts_bill_date_index` (`bill_date`),
  ADD KEY `test_receipts_branch_id_index` (`branch_id`);

--
-- Indexes for table `test_receipt_details`
--
ALTER TABLE `test_receipt_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test_receipt_details_test_receipt_id_foreign` (`test_receipt_id`),
  ADD KEY `test_receipt_details_test_id_foreign` (`test_id`),
  ADD KEY `test_receipt_details_delivery_date_index` (`delivery_date`),
  ADD KEY `test_receipt_details_branch_id_index` (`branch_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `units_use_for_index` (`use_for`),
  ADD KEY `units_branch_id_index` (`branch_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_role_index` (`role`),
  ADD KEY `users_status_index` (`status`),
  ADD KEY `users_branch_id_index` (`branch_id`);

--
-- Indexes for table `user_activities`
--
ALTER TABLE `user_activities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_activities_user_id_foreign` (`user_id`),
  ADD KEY `user_activities_branch_id_index` (`branch_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admissions`
--
ALTER TABLE `admissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `advice`
--
ALTER TABLE `advice`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `agents`
--
ALTER TABLE `agents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ambulances`
--
ALTER TABLE `ambulances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ambulance_bills`
--
ALTER TABLE `ambulance_bills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_accounts`
--
ALTER TABLE `bank_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bank_transactions`
--
ALTER TABLE `bank_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `beds`
--
ALTER TABLE `beds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bed_shifts`
--
ALTER TABLE `bed_shifts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bill_types`
--
ALTER TABLE `bill_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `cash_transactions`
--
ALTER TABLE `cash_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cheif_complains`
--
ALTER TABLE `cheif_complains`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `commission_payments`
--
ALTER TABLE `commission_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_profiles`
--
ALTER TABLE `company_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `damages`
--
ALTER TABLE `damages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `designations`
--
ALTER TABLE `designations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doses`
--
ALTER TABLE `doses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `durations`
--
ALTER TABLE `durations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `floors`
--
ALTER TABLE `floors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `generics`
--
ALTER TABLE `generics`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `instruments`
--
ALTER TABLE `instruments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `instrument_stocks`
--
ALTER TABLE `instrument_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `issues`
--
ALTER TABLE `issues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `issue_details`
--
ALTER TABLE `issue_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `medicine_stocks`
--
ALTER TABLE `medicine_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `months`
--
ALTER TABLE `months`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `operation_schedules`
--
ALTER TABLE `operation_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patient_payments`
--
ALTER TABLE `patient_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prescription_advice`
--
ALTER TABLE `prescription_advice`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prescription_chief_complains`
--
ALTER TABLE `prescription_chief_complains`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prescription_medicines`
--
ALTER TABLE `prescription_medicines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prescription_tests`
--
ALTER TABLE `prescription_tests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `purchase_details`
--
ALTER TABLE `purchase_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `purchase_return_details`
--
ALTER TABLE `purchase_return_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `release_slips`
--
ALTER TABLE `release_slips`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salaries`
--
ALTER TABLE `salaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salary_details`
--
ALTER TABLE `salary_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_details`
--
ALTER TABLE `sale_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_returns`
--
ALTER TABLE `sale_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sale_return_details`
--
ALTER TABLE `sale_return_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `supplier_payments`
--
ALTER TABLE `supplier_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_receipts`
--
ALTER TABLE `test_receipts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `test_receipt_details`
--
ALTER TABLE `test_receipt_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_activities`
--
ALTER TABLE `user_activities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admissions`
--
ALTER TABLE `admissions`
  ADD CONSTRAINT `admissions_bed_id_foreign` FOREIGN KEY (`bed_id`) REFERENCES `beds` (`id`),
  ADD CONSTRAINT `admissions_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`),
  ADD CONSTRAINT `admissions_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`),
  ADD CONSTRAINT `admissions_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

--
-- Constraints for table `advice`
--
ALTER TABLE `advice`
  ADD CONSTRAINT `advice_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`);

--
-- Constraints for table `ambulances`
--
ALTER TABLE `ambulances`
  ADD CONSTRAINT `ambulances_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`);

--
-- Constraints for table `ambulance_bills`
--
ALTER TABLE `ambulance_bills`
  ADD CONSTRAINT `ambulance_bills_ambulance_id_foreign` FOREIGN KEY (`ambulance_id`) REFERENCES `ambulances` (`id`),
  ADD CONSTRAINT `ambulance_bills_driver_id_foreign` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`),
  ADD CONSTRAINT `ambulance_bills_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`);

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`),
  ADD CONSTRAINT `appointments_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`);

--
-- Constraints for table `bank_transactions`
--
ALTER TABLE `bank_transactions`
  ADD CONSTRAINT `bank_transactions_bank_account_id_foreign` FOREIGN KEY (`bank_account_id`) REFERENCES `bank_accounts` (`id`);

--
-- Constraints for table `beds`
--
ALTER TABLE `beds`
  ADD CONSTRAINT `beds_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

--
-- Constraints for table `bed_shifts`
--
ALTER TABLE `bed_shifts`
  ADD CONSTRAINT `bed_shifts_admission_id_foreign` FOREIGN KEY (`admission_id`) REFERENCES `admissions` (`id`),
  ADD CONSTRAINT `bed_shifts_from_bed_id_foreign` FOREIGN KEY (`from_bed_id`) REFERENCES `beds` (`id`),
  ADD CONSTRAINT `bed_shifts_from_room_id_foreign` FOREIGN KEY (`from_room_id`) REFERENCES `rooms` (`id`),
  ADD CONSTRAINT `bed_shifts_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`),
  ADD CONSTRAINT `bed_shifts_to_bed_id_foreign` FOREIGN KEY (`to_bed_id`) REFERENCES `beds` (`id`),
  ADD CONSTRAINT `bed_shifts_to_room_id_foreign` FOREIGN KEY (`to_room_id`) REFERENCES `rooms` (`id`);

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_bill_type_id_foreign` FOREIGN KEY (`bill_type_id`) REFERENCES `bill_types` (`id`),
  ADD CONSTRAINT `bills_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`);

--
-- Constraints for table `cash_transactions`
--
ALTER TABLE `cash_transactions`
  ADD CONSTRAINT `cash_transactions_account_id_foreign` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`);

--
-- Constraints for table `cheif_complains`
--
ALTER TABLE `cheif_complains`
  ADD CONSTRAINT `cheif_complains_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`);

--
-- Constraints for table `doses`
--
ALTER TABLE `doses`
  ADD CONSTRAINT `doses_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`);

--
-- Constraints for table `durations`
--
ALTER TABLE `durations`
  ADD CONSTRAINT `durations_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`);

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `employees_designation_id_foreign` FOREIGN KEY (`designation_id`) REFERENCES `designations` (`id`);

--
-- Constraints for table `instruments`
--
ALTER TABLE `instruments`
  ADD CONSTRAINT `instruments_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `instruments_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `instrument_stocks`
--
ALTER TABLE `instrument_stocks`
  ADD CONSTRAINT `instrument_stocks_instrument_id_foreign` FOREIGN KEY (`instrument_id`) REFERENCES `instruments` (`id`);

--
-- Constraints for table `issues`
--
ALTER TABLE `issues`
  ADD CONSTRAINT `issues_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `issue_details`
--
ALTER TABLE `issue_details`
  ADD CONSTRAINT `issue_details_instrument_id_foreign` FOREIGN KEY (`instrument_id`) REFERENCES `instruments` (`id`),
  ADD CONSTRAINT `issue_details_issue_id_foreign` FOREIGN KEY (`issue_id`) REFERENCES `issues` (`id`);

--
-- Constraints for table `medicines`
--
ALTER TABLE `medicines`
  ADD CONSTRAINT `medicines_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`),
  ADD CONSTRAINT `medicines_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `medicines_generic_id_foreign` FOREIGN KEY (`generic_id`) REFERENCES `generics` (`id`),
  ADD CONSTRAINT `medicines_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`);

--
-- Constraints for table `medicine_stocks`
--
ALTER TABLE `medicine_stocks`
  ADD CONSTRAINT `medicine_stocks_medicine_id_foreign` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`);

--
-- Constraints for table `operation_schedules`
--
ALTER TABLE `operation_schedules`
  ADD CONSTRAINT `operation_schedules_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`),
  ADD CONSTRAINT `operation_schedules_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`),
  ADD CONSTRAINT `operation_schedules_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

--
-- Constraints for table `patient_payments`
--
ALTER TABLE `patient_payments`
  ADD CONSTRAINT `patient_payments_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`);

--
-- Constraints for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD CONSTRAINT `prescriptions_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`),
  ADD CONSTRAINT `prescriptions_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`);

--
-- Constraints for table `prescription_advice`
--
ALTER TABLE `prescription_advice`
  ADD CONSTRAINT `prescription_advice_prescription_id_foreign` FOREIGN KEY (`prescription_id`) REFERENCES `prescriptions` (`id`);

--
-- Constraints for table `prescription_chief_complains`
--
ALTER TABLE `prescription_chief_complains`
  ADD CONSTRAINT `prescription_chief_complains_prescription_id_foreign` FOREIGN KEY (`prescription_id`) REFERENCES `prescriptions` (`id`);

--
-- Constraints for table `prescription_medicines`
--
ALTER TABLE `prescription_medicines`
  ADD CONSTRAINT `prescription_medicines_medicine_id_foreign` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`),
  ADD CONSTRAINT `prescription_medicines_prescription_id_foreign` FOREIGN KEY (`prescription_id`) REFERENCES `prescriptions` (`id`);

--
-- Constraints for table `prescription_tests`
--
ALTER TABLE `prescription_tests`
  ADD CONSTRAINT `prescription_tests_prescription_id_foreign` FOREIGN KEY (`prescription_id`) REFERENCES `prescriptions` (`id`),
  ADD CONSTRAINT `prescription_tests_test_id_foreign` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`);

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Constraints for table `purchase_details`
--
ALTER TABLE `purchase_details`
  ADD CONSTRAINT `purchase_details_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`);

--
-- Constraints for table `purchase_returns`
--
ALTER TABLE `purchase_returns`
  ADD CONSTRAINT `purchase_returns_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`),
  ADD CONSTRAINT `purchase_returns_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Constraints for table `purchase_return_details`
--
ALTER TABLE `purchase_return_details`
  ADD CONSTRAINT `purchase_return_details_purchase_return_id_foreign` FOREIGN KEY (`purchase_return_id`) REFERENCES `purchase_returns` (`id`);

--
-- Constraints for table `release_slips`
--
ALTER TABLE `release_slips`
  ADD CONSTRAINT `release_slips_admission_id_foreign` FOREIGN KEY (`admission_id`) REFERENCES `admissions` (`id`),
  ADD CONSTRAINT `release_slips_bed_id_foreign` FOREIGN KEY (`bed_id`) REFERENCES `beds` (`id`),
  ADD CONSTRAINT `release_slips_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`),
  ADD CONSTRAINT `release_slips_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`),
  ADD CONSTRAINT `release_slips_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`);

--
-- Constraints for table `salaries`
--
ALTER TABLE `salaries`
  ADD CONSTRAINT `salaries_month_id_foreign` FOREIGN KEY (`month_id`) REFERENCES `months` (`id`);

--
-- Constraints for table `salary_details`
--
ALTER TABLE `salary_details`
  ADD CONSTRAINT `salary_details_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `salary_details_salary_id_foreign` FOREIGN KEY (`salary_id`) REFERENCES `salaries` (`id`);

--
-- Constraints for table `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `sales_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`);

--
-- Constraints for table `sale_details`
--
ALTER TABLE `sale_details`
  ADD CONSTRAINT `sale_details_medicine_id_foreign` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`),
  ADD CONSTRAINT `sale_details_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`);

--
-- Constraints for table `sale_returns`
--
ALTER TABLE `sale_returns`
  ADD CONSTRAINT `sale_returns_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`),
  ADD CONSTRAINT `sale_returns_sale_id_foreign` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`);

--
-- Constraints for table `sale_return_details`
--
ALTER TABLE `sale_return_details`
  ADD CONSTRAINT `sale_return_details_medicine_id_foreign` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`),
  ADD CONSTRAINT `sale_return_details_sale_return_id_foreign` FOREIGN KEY (`sale_return_id`) REFERENCES `sale_returns` (`id`);

--
-- Constraints for table `supplier_payments`
--
ALTER TABLE `supplier_payments`
  ADD CONSTRAINT `supplier_payments_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Constraints for table `test_receipts`
--
ALTER TABLE `test_receipts`
  ADD CONSTRAINT `test_receipts_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`);

--
-- Constraints for table `test_receipt_details`
--
ALTER TABLE `test_receipt_details`
  ADD CONSTRAINT `test_receipt_details_test_id_foreign` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`),
  ADD CONSTRAINT `test_receipt_details_test_receipt_id_foreign` FOREIGN KEY (`test_receipt_id`) REFERENCES `test_receipts` (`id`);

--
-- Constraints for table `user_activities`
--
ALTER TABLE `user_activities`
  ADD CONSTRAINT `user_activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
