-- Migration: Add security tables for enhanced login functionality
-- Created: 2024-01-01
-- Description: Adds tables for login attempts tracking, login logs, and remember me tokens

-- Table for tracking failed login attempts
CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `reason` varchar(100) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `attempt_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_email_time` (`email`, `attempt_time`),
  KEY `idx_ip_time` (`ip_address`, `attempt_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table for logging successful logins
CREATE TABLE IF NOT EXISTS `login_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login_time` datetime NOT NULL,
  `user_agent` text,
  PRIMARY KEY (`id`),
  KEY `idx_email_time` (`email`, `login_time`),
  KEY `idx_ip_time` (`ip_address`, `login_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table for remember me tokens
CREATE TABLE IF NOT EXISTS `remember_tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_token` (`token`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_expires_at` (`expires_at`),
  FOREIGN KEY (`user_id`) REFERENCES `user`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add last_login column to user table if it doesn't exist
ALTER TABLE `user` 
ADD COLUMN IF NOT EXISTS `last_login` datetime DEFAULT NULL AFTER `status`;

-- Create indexes for better performance
CREATE INDEX IF NOT EXISTS `idx_user_status` ON `user`(`status`);
CREATE INDEX IF NOT EXISTS `idx_user_email` ON `user`(`email`);

-- Clean up old login attempts (older than 24 hours)
-- This can be run as a scheduled task
-- DELETE FROM `login_attempts` WHERE `attempt_time` < DATE_SUB(NOW(), INTERVAL 24 HOUR);

-- Clean up expired remember tokens
-- This can be run as a scheduled task  
-- DELETE FROM `remember_tokens` WHERE `expires_at` < NOW();
