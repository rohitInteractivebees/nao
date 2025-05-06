-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 06, 2025 at 07:29 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nao`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `correct` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `test_id` bigint(20) UNSIGNED DEFAULT NULL,
  `question_id` bigint(20) UNSIGNED DEFAULT NULL,
  `option_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `classess`
--

CREATE TABLE `classess` (
  `id` int(11) NOT NULL,
  `name` varchar(222) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classess`
--

INSERT INTO `classess` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Class VI', '2025-04-30 07:21:43', '2025-04-30 07:21:43'),
(2, 'Class VII', '2025-04-30 07:21:43', '2025-04-30 07:21:43'),
(3, 'Class VIII', '2025-04-30 07:21:43', '2025-04-30 07:21:43'),
(4, 'Class IX', '2025-04-30 07:21:43', '2025-04-30 07:21:43'),
(5, 'Class X', '2025-04-30 07:21:43', '2025-04-30 07:21:43'),
(6, 'Class XI', '2025-04-30 07:21:43', '2025-04-30 07:21:43'),
(7, 'Class XII', '2025-04-30 07:21:43', '2025-04-30 07:21:43');

-- --------------------------------------------------------

--
-- Table structure for table `colleges`
--

CREATE TABLE `colleges` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `instute` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `instutes`
--

CREATE TABLE `instutes` (
  `id` int(11) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(222) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instutes`
--

INSERT INTO `instutes` (`id`, `code`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'JNV1', 'Jawahar Navodaya Vidyalaya', 1, '2025-04-30 07:14:53', '2025-04-30 07:14:53'),
(2, 'CIRS2', 'Chinmaya International Residential School', 1, '2025-04-30 07:14:53', '2025-04-30 07:14:53'),
(3, 'JPSB3', 'Jain Public school Barnagar', 1, '2025-04-30 07:14:53', '2025-04-30 07:14:53'),
(4, 'KGNHS4', 'KAKATPUR GIRLS NODAL HIGH SCHOOL', 1, '2025-04-30 07:14:53', '2025-04-30 07:14:53'),
(5, 'JNVEM5', 'Jawahar Navodaya vidyalaya East Medinipur', 1, '2025-04-30 07:14:53', '2025-04-30 07:14:53'),
(6, 'JNVEMD6', 'Jawahar Navodaya vidyalaya East Medini Dehlipur', 1, '2025-05-02 02:19:06', '2025-05-02 02:19:06'),
(7, 'JND7', 'Jawahar Navodaya Dehli1', 1, '2025-05-02 02:22:13', '2025-05-02 04:40:24');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_05_03_130837_create_questions_table', 1),
(6, '2023_05_03_152932_create_options_table', 1),
(7, '2023_05_03_160329_create_quizzes_table', 1),
(8, '2023_05_04_103903_create_question_quiz_table', 1),
(9, '2023_05_04_155528_create_tests_table', 1),
(10, '2023_05_04_155848_create_answers_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `text` varchar(255) NOT NULL,
  `correct` tinyint(1) NOT NULL DEFAULT 0,
  `question_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `text`, `correct`, `question_id`, `created_at`, `updated_at`) VALUES
(1, 'ab', 0, 1, '2025-05-02 05:53:25', '2025-05-02 05:55:59'),
(2, 'b', 1, 1, '2025-05-02 05:53:25', '2025-05-02 05:54:20'),
(6, 'sdfghl', 0, 1, '2025-05-02 05:56:54', '2025-05-02 05:56:54'),
(7, 'aaa', 1, 2, '2025-05-02 06:47:28', '2025-05-02 07:01:16'),
(8, 'bbb', 0, 2, '2025-05-02 06:47:28', '2025-05-02 07:01:16'),
(9, 'ccc', 0, 2, '2025-05-02 06:47:28', '2025-05-02 07:01:23'),
(10, 'ddd', 0, 2, '2025-05-02 06:47:28', '2025-05-02 07:01:16');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `physicalys`
--

CREATE TABLE `physicalys` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `college_id` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `edited` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projectsubmissionsphase2`
--

CREATE TABLE `projectsubmissionsphase2` (
  `SubmissionID` int(11) NOT NULL,
  `TeamID` int(11) DEFAULT NULL,
  `FileName` varchar(255) DEFAULT NULL,
  `FilePath` varchar(255) DEFAULT NULL,
  `FileType` enum('PDF','PPT','MOV','DOC','DOCX') NOT NULL,
  `FileSize` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prototypes`
--

CREATE TABLE `prototypes` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `college_id` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(555) DEFAULT NULL,
  `edited` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `text` text NOT NULL,
  `image_path` text DEFAULT NULL,
  `code_snippet` text DEFAULT NULL,
  `answer_explanation` text DEFAULT NULL,
  `more_info_link` varchar(255) DEFAULT NULL,
  `class_ids` varchar(255) DEFAULT NULL,
  `marks` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `text`, `image_path`, `code_snippet`, `answer_explanation`, `more_info_link`, `class_ids`, `marks`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'test1', NULL, NULL, NULL, NULL, '[\"1\",\"3\"]', 1, '2025-05-02 05:53:25', '2025-05-02 05:53:25', NULL),
(2, 'test2', NULL, NULL, NULL, NULL, '[\"2\",\"4\"]', 1, '2025-05-02 06:47:28', '2025-05-02 06:47:28', NULL),
(3, 'test3', NULL, NULL, NULL, NULL, '[\"1\",\"3\"]', 1, '2025-05-02 05:53:25', '2025-05-02 05:53:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `question_quiz`
--

CREATE TABLE `question_quiz` (
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `quiz_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `question_quiz`
--

INSERT INTO `question_quiz` (`question_id`, `quiz_id`) VALUES
(2, 1),
(1, 2),
(3, 2),
(2, 4),
(2, 5),
(2, 6);

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `result_show` tinyint(4) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 0,
  `public` tinyint(1) NOT NULL DEFAULT 0,
  `not_open` tinyint(1) DEFAULT NULL,
  `class_ids` int(11) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `result_date` timestamp NULL DEFAULT NULL,
  `total_question` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `title`, `slug`, `result_show`, `description`, `published`, `public`, `not_open`, `class_ids`, `duration`, `start_date`, `end_date`, `result_date`, `total_question`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Quiz 1', 'quiz-1', NULL, 'testing', 0, 0, NULL, 2, 30, '2025-05-05 08:23:00', '2025-05-07 08:23:00', '2025-05-15 08:23:00', 1, 1, '2025-05-05 02:53:39', '2025-05-05 05:43:35', NULL),
(2, 'fty', 'fty', NULL, 'dty', 0, 0, NULL, 1, 55, '2025-05-05 06:52:00', '2025-05-12 06:52:00', '2025-05-13 06:52:00', 2, 1, '2025-05-05 03:56:39', '2025-05-05 06:52:01', NULL),
(4, 'Quiz 1 (Copy)', 'quiz-1-copy', NULL, 'testing', 0, 0, NULL, 2, 30, '2025-05-05 06:56:17', '2025-05-12 06:56:17', '2025-05-13 06:56:17', 1, 0, '2025-05-05 06:56:17', '2025-05-05 06:56:17', NULL),
(5, 'fty (Copy)', 'fty-copy', NULL, 'dty', 0, 0, NULL, 4, 55, '2025-05-05 06:52:00', '2025-05-12 06:52:00', '2025-05-13 06:52:00', 1, 1, '2025-05-05 06:58:23', '2025-05-05 07:03:56', NULL),
(6, 'fty (Copy) (Copy)', 'fty-copy-copy', NULL, 'dty', 0, 0, NULL, 4, 55, '2025-05-05 06:52:00', '2025-05-12 06:52:00', '2025-05-13 06:52:00', 1, 0, '2025-05-05 07:06:06', '2025-05-05 07:06:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `teamlead_id` varchar(255) DEFAULT NULL,
  `college_id` varchar(255) DEFAULT NULL,
  `approved_level2` varchar(255) DEFAULT NULL,
  `approved_level3` varchar(255) DEFAULT NULL,
  `mentorname` varchar(255) DEFAULT NULL,
  `mentordetails` varchar(255) DEFAULT NULL,
  `teamMembers` varchar(255) DEFAULT NULL,
  `mentortype` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teams1`
--

CREATE TABLE `teams1` (
  `teamId` int(11) NOT NULL,
  `college_id` int(11) DEFAULT NULL,
  `teamname` varchar(255) DEFAULT NULL,
  `teamlead_id` int(11) DEFAULT NULL,
  `mentorname` varchar(255) DEFAULT NULL,
  `mentordetails` text DEFAULT NULL,
  `teamMembers` text DEFAULT NULL,
  `mentortype` enum('External','Internal') DEFAULT 'Internal',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `result` int(11) DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `time_spent` int(11) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quiz_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reg_no` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `parent_name` varchar(255) DEFAULT NULL,
  `idcard` varchar(255) DEFAULT NULL,
  `institute` varchar(255) DEFAULT NULL,
  `college` varchar(255) DEFAULT NULL,
  `streams` varchar(255) DEFAULT NULL,
  `other_stream` varchar(255) DEFAULT NULL,
  `session_year` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `is_verified` varchar(255) DEFAULT NULL,
  `level2result` tinyint(1) DEFAULT NULL,
  `level3result` tinyint(1) DEFAULT NULL,
  `level2show` tinyint(1) DEFAULT NULL,
  `level3show` tinyint(1) DEFAULT NULL,
  `level2enddate` date DEFAULT NULL,
  `level3enddate` date DEFAULT NULL,
  `is_college` tinyint(1) DEFAULT NULL,
  `is_selected` tinyint(1) DEFAULT NULL,
  `facebook_id` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `github_id` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `class` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `spoc_mobile` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `reg_no`, `name`, `parent_name`, `idcard`, `institute`, `college`, `streams`, `other_stream`, `session_year`, `email`, `remark`, `phone`, `email_verified_at`, `password`, `is_admin`, `is_verified`, `level2result`, `level3result`, `level2show`, `level3show`, `level2enddate`, `level3enddate`, `is_college`, `is_selected`, `facebook_id`, `google_id`, `github_id`, `remember_token`, `created_at`, `updated_at`, `class`, `city`, `state`, `country`, `spoc_mobile`) VALUES
(1, NULL, 'Admin', 'Admin', NULL, '1', '3', 'biomedical', NULL, '2024', 'admin@gmail.com', NULL, '7667013312', '2024-06-08 17:40:31', '$2y$10$OvynOQzHLiOxq084xsi/veIj18V/b9k4s5inNzSDJIRjx.OQn3Tjy', 1, '1', 0, 0, 1, 1, '2024-07-24', '2024-07-24', 0, 1, NULL, NULL, NULL, '6JxhjvVUh0U44mXZBXosZ3jmBzgVCrO6ZTaOIsJ8n7azNurK2gsvArZng65h', '2024-06-08 17:40:31', '2025-05-02 04:28:00', '0', NULL, NULL, NULL, NULL),
(572, NULL, 'Sunny', NULL, 'idcards/1745999811_1720098393_Logo-01-02 1.jpg', '1', NULL, NULL, NULL, '2025-2026', 'sunny@gmail.com', NULL, '9910177633', NULL, '$2y$10$NMP2cS1or8XsZ5oUwtJkVewPQ809JHio575DIwaVRrQTRg895DSIG', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-30 02:26:51', '2025-04-30 02:26:51', '[\"4\"]', NULL, NULL, NULL, NULL),
(573, NULL, 'Sunny', 'Parent', 'idcards/1746000089_1720098393_Logo-01-02 1.jpg', '2', NULL, NULL, NULL, '2025-2026', 'sunny1@gmail.com', NULL, '9910177631', NULL, '$2y$10$cCE3R2BVNgs7uvPC6.TbpuQlw/05YkDuPiPfxyqqgUpwb0Gesjqp.', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-30 02:31:29', '2025-04-30 02:31:29', '[\"3\"]', 'dehli', 'Sunny', NULL, NULL),
(574, NULL, 'sunny', 'Parent', 'idcards/1746000616_1720098393_Logo-01-02 1.jpg', '2', NULL, NULL, NULL, '2025-2026', 'sunny12@gmail.com', NULL, '9910177634', NULL, '$2y$10$9hGGQwAM17VwyzXi4kuV/OxWQ7R9VVIkiuXT1UjJd7zAZWPi7I6I.', 0, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-30 02:40:16', '2025-05-01 03:50:42', '[\"3\"]', 'dehli', 'dehli', NULL, NULL),
(575, NULL, 'sunny', 'Parent', 'idcards/1746000858_1720098393_Logo-01-02 1.jpg', '2', NULL, NULL, NULL, '2025-2026', 'sunny13@gmail.com', NULL, '9910177637', NULL, '$2y$10$7tHNoP1xdWHSsvF/EoiKmuUbImxyrvXwwmb4t5NEOClu9FEZWbwcm', 0, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-30 02:44:18', '2025-05-01 03:49:23', '[\"3\"]', 'dehli', 'dehli', NULL, NULL),
(576, NULL, 'sunny', 'sunnyb', NULL, '4', NULL, NULL, NULL, NULL, 'sunny11@gmail.com', NULL, '9876543211', NULL, '$2y$10$ljqOk/boakK/fUu04jJpie4JRXbzUcfarUZXhOrR4jCYP0Gkx7w46', 0, '1', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2025-04-30 04:42:47', '2025-04-30 23:47:18', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\"]', 'dehli', 'dehli', 'india', '8989898989'),
(577, NULL, 'frh', 'dfg', 'idcards/1746013769_1720435077_dummy id.jpg', '1', NULL, NULL, NULL, '2025-2026', 's@gmail.com', NULL, '9910177622', NULL, '$2y$10$UnzzjbVmobyC2t4pm4Uyf.QI0ym7Jqaw6IPRiISXbZOkyC92l5bdu', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-04-30 10:49:29', '2025-04-30 10:49:29', '[\"1\"]', 'dehli', 'dehli', NULL, NULL),
(578, NULL, 'sdf', 'fdg', NULL, '2', NULL, NULL, NULL, NULL, 'a@gmail.com', NULL, '8976543212', NULL, '$2y$10$vqPdUzlAiyzTcgXNKHFqLeODHtTX/wvwwI5NaP4DqNyqrMZLM9wbG', 0, '1', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2025-04-30 10:50:38', '2025-04-30 10:50:38', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\"]', 'dfgdf', 'fdhdf', 'india', '6785685875'),
(579, NULL, 'bhupendra', 'parent', '1746091698_1720435077_dummy id.jpg', '2', NULL, NULL, NULL, '212', 'bh@gmail.com', NULL, '9876543556', NULL, '$2y$10$EljrsQOSJLyvHVoOnsN8rOdFVL3UwGYO340XP0NVYReAFXY8ebhLi', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-01 03:58:18', '2025-05-01 03:58:18', '[\"2\"]', 'dehli', 'bhupendra', NULL, NULL),
(580, NULL, 'sdfghjj', 'sdfghj', 'idcardPath/1746091981_1721179576_Karthik.JPG', '2', NULL, NULL, NULL, '212', 'asd@gmail.com', NULL, '9876545567', NULL, '$2y$10$BZff5rBpK0FtbZv8hkvR4.krv5J0Fqb7vfYu1j3Exa68JxD0iTsuG', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-01 04:03:01', '2025-05-01 04:03:01', '[\"1\"]', 'fdgh', 'sdfghjj', NULL, NULL),
(581, NULL, 'sdfghj', 'dfgjh', 'idcards/1746092056_1721190383_IMG_20240717_094823.jpg', '2', NULL, NULL, NULL, '212', 'DFD@gmail.com', NULL, '9876556467', NULL, '$2y$10$2XzZ8osfewYeEcYSOcjKpuOTg49cPy8Vgd5UrL4qFGnSZoTVLTrXO', 0, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-01 04:04:16', '2025-05-01 04:04:41', '[\"1\"]', 'fghfh', 'fgjgh', NULL, NULL),
(582, NULL, 'test', 'abcd', NULL, '6', NULL, NULL, NULL, NULL, 'test@gmail.com', NULL, '3456789097', NULL, '$2y$10$Q5HazL7MdnfH/1BtpXkr7e1K83TekRd0yKtUsRDufA09y3/pamPH.', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2025-05-02 02:19:06', '2025-05-02 02:19:06', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\"]', 'delhi', 'delhi', 'india', '5345346546'),
(583, 'SCHOOL_1', 'test', 'abcd', NULL, '7', NULL, NULL, NULL, NULL, 'test1@gmail.com', NULL, '7896543212', NULL, '$2y$10$IA68Pi7Ey6VI8InrIKAy6.NCQA9T9JCg0uNmgu22HE9nXxz68Cir2', 0, '1', NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, '2025-05-02 02:22:13', '2025-05-02 04:40:24', '[\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\"]', 'delhi', 'delhi', 'india', '6678578765'),
(584, 'USER_1', 'test', 'aaaa', 'idcards/1746178567_1720501131_dummy id.jpg', '7', NULL, NULL, NULL, '2025-2026', 'adggs@gmail.com', NULL, '7667016546', NULL, '$2y$10$GKE3Yt3uZM8OlC7sVUoDl..Af9e5Qo/Ml91TKcM0QyQxGZfRtnpOi', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-02 04:06:08', '2025-05-02 04:06:08', '[\"1\"]', 'fdhh', 'fgdf', NULL, NULL),
(585, 'USER_2', 'test', 'aaaa', 'idcards/1746178647_1720501131_dummy id.jpg', '7', NULL, NULL, NULL, '2025-2026', 'ggs@gmail.com', NULL, '7667016565', NULL, '$2y$10$ILe4mkbnoafktfgOnoc0v.ExJGl.kr9/7bG4t1tgPU.gonRp.6j82', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-02 04:07:27', '2025-05-02 04:07:27', '[\"1\"]', 'fdhh', 'fgdf', NULL, NULL),
(586, 'USER_3', 'rrr', 'rrrr', 'idcards/1746180733_1720435077_dummy id.jpg', '7', NULL, NULL, NULL, '2025-2026', 'rrr@eee.vv', NULL, '2342342342', NULL, '$2y$10$jpUUnIbf1D0mKP/6A/GeKOILtT.t0zm/G.FevlrpPY0KYsrHQmxL.', 0, '1', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-05-02 04:42:13', '2025-05-02 04:43:45', '[\"5\"]', 'dfvdfv', 'fdf', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answers_user_id_foreign` (`user_id`),
  ADD KEY `answers_test_id_foreign` (`test_id`),
  ADD KEY `answers_question_id_foreign` (`question_id`),
  ADD KEY `answers_option_id_foreign` (`option_id`);

--
-- Indexes for table `classess`
--
ALTER TABLE `classess`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `colleges`
--
ALTER TABLE `colleges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `instutes`
--
ALTER TABLE `instutes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `options_question_id_foreign` (`question_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `physicalys`
--
ALTER TABLE `physicalys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projectsubmissionsphase2`
--
ALTER TABLE `projectsubmissionsphase2`
  ADD PRIMARY KEY (`SubmissionID`),
  ADD KEY `TeamID` (`TeamID`);

--
-- Indexes for table `prototypes`
--
ALTER TABLE `prototypes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question_quiz`
--
ALTER TABLE `question_quiz`
  ADD KEY `question_quiz_question_id_foreign` (`question_id`),
  ADD KEY `question_quiz_quiz_id_foreign` (`quiz_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teams1`
--
ALTER TABLE `teams1`
  ADD PRIMARY KEY (`teamId`),
  ADD KEY `college_id` (`college_id`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tests_user_id_foreign` (`user_id`),
  ADD KEY `tests_quiz_id_foreign` (`quiz_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `classess`
--
ALTER TABLE `classess`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `colleges`
--
ALTER TABLE `colleges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `instutes`
--
ALTER TABLE `instutes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `physicalys`
--
ALTER TABLE `physicalys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projectsubmissionsphase2`
--
ALTER TABLE `projectsubmissionsphase2`
  MODIFY `SubmissionID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prototypes`
--
ALTER TABLE `prototypes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `teams1`
--
ALTER TABLE `teams1`
  MODIFY `teamId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=587;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_option_id_foreign` FOREIGN KEY (`option_id`) REFERENCES `options` (`id`),
  ADD CONSTRAINT `answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `answers_test_id_foreign` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`),
  ADD CONSTRAINT `answers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `options`
--
ALTER TABLE `options`
  ADD CONSTRAINT `options_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`);

--
-- Constraints for table `projectsubmissionsphase2`
--
ALTER TABLE `projectsubmissionsphase2`
  ADD CONSTRAINT `ProjectSubmissionsPhase2_ibfk_1` FOREIGN KEY (`TeamID`) REFERENCES `teams1` (`teamId`) ON DELETE CASCADE;

--
-- Constraints for table `question_quiz`
--
ALTER TABLE `question_quiz`
  ADD CONSTRAINT `question_quiz_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `question_quiz_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `teams1`
--
ALTER TABLE `teams1`
  ADD CONSTRAINT `teams1_ibfk_1` FOREIGN KEY (`college_id`) REFERENCES `colleges` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tests`
--
ALTER TABLE `tests`
  ADD CONSTRAINT `tests_quiz_id_foreign` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`id`),
  ADD CONSTRAINT `tests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
