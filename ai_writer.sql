-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2025 at 05:33 PM
-- Server version: 11.2.2-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ai_writer`
--

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `count` int(11) NOT NULL DEFAULT 0,
  `data` text DEFAULT NULL,
  `is_favourite` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `getways`
--

CREATE TABLE `getways` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `logo` varchar(191) NOT NULL,
  `rate` int(11) NOT NULL,
  `charge` int(11) NOT NULL,
  `namespace` varchar(191) DEFAULT 'custom',
  `currency_name` varchar(191) NOT NULL,
  `image_accept` tinyint(1) NOT NULL DEFAULT 0,
  `is_auto` tinyint(1) NOT NULL DEFAULT 0,
  `test_mode` tinyint(1) NOT NULL DEFAULT 0,
  `status` varchar(191) NOT NULL,
  `phone_required` tinyint(1) NOT NULL DEFAULT 0,
  `instruction` varchar(191) DEFAULT NULL,
  `data` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `getways`
--
CREATE TABLE `chat_messages` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `session_id` VARCHAR(255) NOT NULL,
  `conversation_id` VARCHAR(255) NOT NULL,
  `user_id` VARCHAR(255) NOT NULL,
  `role` ENUM('user', 'assistant') NOT NULL,
  `content` TEXT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `langs`
--

CREATE TABLE `langs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `code` varchar(191) NOT NULL,
  `status` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menuitems`
--

CREATE TABLE `menuitems` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order` int(11) NOT NULL,
  `name` varchar(191) NOT NULL,
  `data` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `position` varchar(191) NOT NULL,
  `lang` text NOT NULL,
  `status` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2013_12_22_143825_create_plans_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2021_08_28_141310_create_terms_table', 1),
(7, '2021_08_28_141337_create_termmetas_table', 1),
(8, '2021_08_28_141906_create_options_table', 1),
(9, '2021_08_28_144023_create_usermetas_table', 1),
(10, '2021_11_07_010440_create_transcations_table', 1),
(11, '2021_11_07_010542_create_menus_table', 1),
(12, '2022_02_09_042508_create_getways_table', 1),
(13, '2022_04_21_141900_create_menuitems_table', 1),
(14, '2022_04_24_133916_create_langs_table', 1),
(15, '2022_12_21_073109_create_documents_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(191) NOT NULL,
  `value` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'hero_data', '{\r\n    \"title\": \"Welcome to Our Platform\",\r\n    \"subtitle\": \"The Ultimate Solution\",\r\n    \"description\": \"Transform your business with our powerful tools and services\",\r\n    \"button_text\": \"Get Started\",\r\n    \"button_url\": \"/register\",\r\n    \"image\": \"/assets/images/hero.jpg\"\r\n}', '2025-02-04 02:13:44', '2025-02-04 02:13:44'),
(2, 'site_settings', '{\r\n    \"site_name\": \"Your Site Name\",\r\n    \"site_description\": \"Your site description\",\r\n    \"logo\": \"/assets/images/logo.png\",\r\n    \"favicon\": \"/assets/images/favicon.ico\",\r\n    \"email\": \"contact@yoursite.com\",\r\n    \"phone\": \"+1234567890\",\r\n    \"address\": \"Your Address\",\r\n    \"social_media\": {\r\n        \"facebook\": \"https://facebook.com/yourpage\",\r\n        \"twitter\": \"https://twitter.com/yourpage\",\r\n        \"instagram\": \"https://instagram.com/yourpage\"\r\n    }\r\n}', '2025-02-04 02:13:44', '2025-02-04 02:13:44'),
(3, 'howItWorks', '{\r\n    \"title\": \"How It Works\",\r\n    \"steps\": [\r\n        {\r\n            \"title\": \"Step 1\",\r\n            \"description\": \"Create your account\",\r\n            \"icon\": \"user-plus\"\r\n        },\r\n        {\r\n            \"title\": \"Step 2\",\r\n            \"description\": \"Choose your plan\",\r\n            \"icon\": \"package\"\r\n        },\r\n        {\r\n            \"title\": \"Step 3\",\r\n            \"description\": \"Start using our services\",\r\n            \"icon\": \"play-circle\"\r\n        }\r\n    ]\r\n}', '2025-02-04 02:13:44', '2025-02-04 02:13:44'),
(4, 'level', '{\r\n    \"title\": \"Experience Levels\",\r\n    \"levels\": [\r\n        {\r\n            \"name\": \"Beginner\",\r\n            \"description\": \"Perfect for starting out\",\r\n            \"icon\": \"star\"\r\n        },\r\n        {\r\n            \"name\": \"Intermediate\",\r\n            \"description\": \"For growing businesses\",\r\n            \"icon\": \"stars\"\r\n        },\r\n        {\r\n            \"name\": \"Advanced\",\r\n            \"description\": \"For established enterprises\",\r\n            \"icon\": \"award\"\r\n        }\r\n    ]\r\n}', '2025-02-04 02:13:44', '2025-02-04 02:13:44'),
(5, 'currency_symbol', '$', '2025-02-04 02:13:44', '2025-02-04 02:13:44'),
(6, 'mail_settings', '{\r\n    \"mail_driver\": \"smtp\",\r\n    \"mail_host\": \"smtp.mailtrap.io\",\r\n    \"mail_port\": \"2525\",\r\n    \"mail_username\": \"your-username\",\r\n    \"mail_password\": \"your-password\",\r\n    \"mail_encryption\": \"tls\"\r\n}', '2025-02-04 02:13:44', '2025-02-04 02:13:44'),
(7, 'seo_defaults', '{\r\n    \"meta_title\": \"Your Site Name - Home\",\r\n    \"meta_description\": \"Default meta description for your site\",\r\n    \"meta_keywords\": \"keyword1, keyword2, keyword3\",\r\n    \"og_image\": \"/assets/images/og-image.jpg\"\r\n}', '2025-02-04 02:13:44', '2025-02-04 02:13:44');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `word_limit` int(11) NOT NULL DEFAULT 0,
  `price` double NOT NULL DEFAULT 0,
  `duration_type` varchar(191) NOT NULL DEFAULT 'monthly',
  `data` text DEFAULT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'pending',
  `is_trial` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `termmetas`
--

CREATE TABLE `termmetas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `term_id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(191) NOT NULL,
  `value` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) NOT NULL,
  `slug` varchar(191) NOT NULL,
  `status` varchar(191) NOT NULL DEFAULT 'pending',
  `type` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transcations`
--

CREATE TABLE `transcations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `trx_id` varchar(191) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method` varchar(191) DEFAULT NULL,
  `amount` double NOT NULL,
  `status` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usermetas`
--

CREATE TABLE `usermetas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(191) NOT NULL,
  `value` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_type` varchar(191) NOT NULL DEFAULT 'user',
  `plan_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `status` varchar(191) NOT NULL DEFAULT 'active',
  `will_expire` varchar(191) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `documents_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `getways`
--
ALTER TABLE `getways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `langs`
--
ALTER TABLE `langs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `langs_code_unique` (`code`);

--
-- Indexes for table `menuitems`
--
ALTER TABLE `menuitems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menuitems_menu_id_foreign` (`menu_id`),
  ADD KEY `menuitems_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `plans_slug_unique` (`slug`);

--
-- Indexes for table `termmetas`
--
ALTER TABLE `termmetas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `termmetas_term_id_foreign` (`term_id`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `terms_slug_unique` (`slug`),
  ADD KEY `terms_user_id_foreign` (`user_id`);

--
-- Indexes for table `transcations`
--
ALTER TABLE `transcations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transcations_user_id_foreign` (`user_id`);

--
-- Indexes for table `usermetas`
--
ALTER TABLE `usermetas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usermetas_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_plan_id_foreign` (`plan_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `getways`
--
ALTER TABLE `getways`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `langs`
--
ALTER TABLE `langs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menuitems`
--
ALTER TABLE `menuitems`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `termmetas`
--
ALTER TABLE `termmetas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transcations`
--
ALTER TABLE `transcations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usermetas`
--
ALTER TABLE `usermetas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `documents`
--
ALTER TABLE `documents`
  ADD CONSTRAINT `documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `menuitems`
--
ALTER TABLE `menuitems`
  ADD CONSTRAINT `menuitems_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `menuitems_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `menuitems` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `termmetas`
--
ALTER TABLE `termmetas`
  ADD CONSTRAINT `termmetas_term_id_foreign` FOREIGN KEY (`term_id`) REFERENCES `terms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `terms`
--
ALTER TABLE `terms`
  ADD CONSTRAINT `terms_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transcations`
--
ALTER TABLE `transcations`
  ADD CONSTRAINT `transcations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `usermetas`
--
ALTER TABLE `usermetas`
  ADD CONSTRAINT `usermetas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_plan_id_foreign` FOREIGN KEY (`plan_id`) REFERENCES `plans` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
