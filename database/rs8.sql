-- =========================================================
-- RS8 Racing — Database Schema
-- Import this file in phpMyAdmin (or `mysql -u root -p < schema.sql`)
-- =========================================================

CREATE DATABASE IF NOT EXISTS rs8_racing
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE rs8_racing;

-- ---------------------------------------------------------
-- Users (customers + admin)
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  username      VARCHAR(50)  NOT NULL UNIQUE,
  email         VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role          ENUM('user','admin') NOT NULL DEFAULT 'user',
  created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- Contact form submissions
-- ---------------------------------------------------------
CREATE TABLE IF NOT EXISTS contact_messages (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  name          VARCHAR(100)  NOT NULL,
  email         VARCHAR(150)  NOT NULL,
  message       TEXT          NOT NULL,
  submitted_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- Seed the admin account
-- username: earl
-- password: earl123   (already hashed below with PHP's password_hash / bcrypt —
--                       the real password is never stored in plain text)
-- IMPORTANT: log in once and change this password from the admin dashboard,
-- or update it here before going live.
-- ---------------------------------------------------------
INSERT INTO users (username, email, password_hash, role)
VALUES (
  'earl',
  'earl@rs8racing.local',
  '$2y$10$Xdmrpj7aXnoj/kXH4CWXHe.kjsFn1xaY0s5XF4vdqbVOj8yBdD6wa',
  'admin'
);
