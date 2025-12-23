
-- Office Manager SaaS - Core schema v1 (Auth + Workspace + Invites + Roles)
-- MySQL / MariaDB, shared hosting friendly

SET NAMES utf8mb4;
SET time_zone = '+00:00';

-- =========================
-- WORKSPACES (companies)
-- =========================
CREATE TABLE IF NOT EXISTS workspaces (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(120) NOT NULL,
  owner_user_id BIGINT UNSIGNED NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =========================
-- USERS (email login)
-- =========================
CREATE TABLE IF NOT EXISTS users (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  full_name VARCHAR(190) NULL,
  phone VARCHAR(50) NULL,

  -- Email verification (HARD RULE: must be verified before login)
  is_email_verified TINYINT(1) NOT NULL DEFAULT 0,
  email_verify_token VARCHAR(120) NULL,
  email_verify_expires_at DATETIME NULL,

  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

ALTER TABLE workspaces
  ADD CONSTRAINT fk_workspaces_owner
  FOREIGN KEY (owner_user_id) REFERENCES users(id)
  ON DELETE SET NULL;

-- =========================
-- WORKSPACE MEMBERS (roles + permissions scope)
-- =========================
CREATE TABLE IF NOT EXISTS workspace_members (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  workspace_id BIGINT UNSIGNED NOT NULL,
  user_id BIGINT UNSIGNED NOT NULL,

  role ENUM('admin','pm','worker') NOT NULL,

  -- Compensation (hidden from lower roles in UI; stored here)
  compensation_type ENUM('hourly','daily','fixed','percent') NULL,
  compensation_value DECIMAL(12,2) NULL,

  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  UNIQUE KEY uq_ws_user (workspace_id, user_id),

  CONSTRAINT fk_wm_ws FOREIGN KEY (workspace_id) REFERENCES workspaces(id) ON DELETE CASCADE,
  CONSTRAINT fk_wm_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =========================
-- INVITES (Owner sends email + role; invitee must verify email)
-- =========================
CREATE TABLE IF NOT EXISTS workspace_invites (
  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  workspace_id BIGINT UNSIGNED NOT NULL,
  invited_email VARCHAR(190) NOT NULL,
  invited_role ENUM('admin','pm','worker') NOT NULL DEFAULT 'worker',

  token VARCHAR(120) NOT NULL UNIQUE,
  expires_at DATETIME NOT NULL,

  invited_by_user_id BIGINT UNSIGNED NOT NULL,
  accepted_at DATETIME NULL,

  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  INDEX idx_inv_email (invited_email),
  INDEX idx_inv_ws (workspace_id),

  CONSTRAINT fk_inv_ws FOREIGN KEY (workspace_id) REFERENCES workspaces(id) ON DELETE CASCADE,
  CONSTRAINT fk_inv_by FOREIGN KEY (invited_by_user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;
