-- =====================================================================
-- Ministry of Youth Empowerment website - Admin/CMS database schema
-- =====================================================================
-- Import this once into MySQL/MariaDB, e.g.:
--   mysql -u root -p < database/schema.sql
--
-- It creates the database, all tables, and two starter accounts:
--   editor      / Editor@2026
--   subeditor   / SubEditor@2026
-- CHANGE THESE PASSWORDS after first login (see admin/profile.php).
-- =====================================================================

CREATE DATABASE IF NOT EXISTS minyouth_cms
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE minyouth_cms;

-- ---------------------------------------------------------------------
-- OPTIONAL: a dedicated, less-privileged database user for this site.
-- Skip this if you're on XAMPP/local dev and just using root - the
-- default config/database.php already points at root with no password.
-- If you DO want a separate user (recommended for a real server),
-- uncomment the two lines below, pick your own password, and update
-- config/database.php to match.
-- ---------------------------------------------------------------------
-- CREATE USER IF NOT EXISTS 'minyouth'@'localhost' IDENTIFIED BY 'ChangeThisPassword123!';
-- GRANT ALL PRIVILEGES ON minyouth_cms.* TO 'minyouth'@'localhost';

-- ---------------------------------------------------------------------
-- Admin users: two roles only - 'editor' and 'sub_editor'
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  full_name     VARCHAR(150)        NOT NULL,
  username      VARCHAR(60)         NOT NULL UNIQUE,
  email         VARCHAR(150)        NOT NULL UNIQUE,
  password_hash VARCHAR(255)        NOT NULL,
  role          ENUM('chief_editor','editor','sub_editor') NOT NULL DEFAULT 'sub_editor',
  status        ENUM('active','inactive')                  NOT NULL DEFAULT 'active',
  created_at    DATETIME DEFAULT CURRENT_TIMESTAMP,
  last_login    DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------
-- News & Events
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS news (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  title         VARCHAR(255) NOT NULL,
  slug          VARCHAR(255) NOT NULL UNIQUE,
  excerpt       TEXT,
  body          LONGTEXT,
  image         VARCHAR(255),
  status        ENUM('draft','pending','approved','published','rejected') NOT NULL DEFAULT 'draft',
  author_id     INT NOT NULL,
  reviewed_by   INT NULL,
  review_note   TEXT NULL,
  created_at    DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at    DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  published_at  DATETIME NULL,
  CONSTRAINT fk_news_author FOREIGN KEY (author_id) REFERENCES users(id),
  CONSTRAINT fk_news_reviewer FOREIGN KEY (reviewed_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------
-- Gallery (images & videos)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS gallery_items (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  title         VARCHAR(255) NOT NULL,
  category      VARCHAR(100) NOT NULL DEFAULT 'exhibitions',
  media_type    ENUM('image','video') NOT NULL DEFAULT 'image',
  file_path     VARCHAR(255) NOT NULL,
  video_url     VARCHAR(255) NULL,
  status        ENUM('draft','pending','approved','published','rejected') NOT NULL DEFAULT 'draft',
  author_id     INT NOT NULL,
  reviewed_by   INT NULL,
  review_note   TEXT NULL,
  created_at    DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at    DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_gallery_author FOREIGN KEY (author_id) REFERENCES users(id),
  CONSTRAINT fk_gallery_reviewer FOREIGN KEY (reviewed_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------
-- Resources / downloadable documents
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS resources (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  title         VARCHAR(255) NOT NULL,
  description   TEXT,
  category      VARCHAR(100) NOT NULL DEFAULT 'General',
  file_path     VARCHAR(255) NOT NULL,
  status        ENUM('draft','pending','approved','published','rejected') NOT NULL DEFAULT 'draft',
  author_id     INT NOT NULL,
  reviewed_by   INT NULL,
  review_note   TEXT NULL,
  created_at    DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at    DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_resources_author FOREIGN KEY (author_id) REFERENCES users(id),
  CONSTRAINT fk_resources_reviewer FOREIGN KEY (reviewed_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------
-- Departments directory (core + support departments)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS departments (
  id            INT AUTO_INCREMENT PRIMARY KEY,
  name          VARCHAR(150) NOT NULL,
  group_type    ENUM('core','support') NOT NULL DEFAULT 'core',
  description   TEXT,
  icon          VARCHAR(50) NOT NULL DEFAULT 'apartment',
  image         VARCHAR(255),
  link_url      VARCHAR(255) NULL,
  sort_order    INT NOT NULL DEFAULT 0,
  status        ENUM('draft','pending','approved','published','rejected') NOT NULL DEFAULT 'draft',
  author_id     INT NOT NULL,
  reviewed_by   INT NULL,
  review_note   TEXT NULL,
  created_at    DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at    DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_departments_author FOREIGN KEY (author_id) REFERENCES users(id),
  CONSTRAINT fk_departments_reviewer FOREIGN KEY (reviewed_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------
-- Activity log (simple audit trail shown on the dashboard)
-- ---------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS activity_log (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  user_id     INT NOT NULL,
  action      VARCHAR(255) NOT NULL,
  details     VARCHAR(500),
  created_at  DATETIME DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_log_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------------------
-- Starter accounts
--   editor    / Editor@2026
--   subeditor / SubEditor@2026
-- (bcrypt hashes generated with PHP password_hash - change after login)
-- ---------------------------------------------------------------------
INSERT INTO users (full_name, username, email, password_hash, role, status) VALUES
('Chief Editor',      'chiefeditor', 'chiefeditor@minyouth.gov.zw',
 '$2y$10$x/3l0WBWsE1AWqpXSgwFZetxXE0lDxnmFpe8x0g/kBVtxYDUXRfCu', 'chief_editor', 'active'),
('Editor',            'editor',      'editor@minyouth.gov.zw',
 '$2y$10$RZ1HVPplAZFMEgkKnhcxa.9do92.zH5u2wMY2uZ6edUacHnJP0YPy', 'editor',       'active'),
('Junior Sub-Editor', 'subeditor',   'subeditor@minyouth.gov.zw',
 '$2y$10$R76Zyhc.UGsyKePgs/07q.5lDgLncpTucicZu96gNPCDCbTd8.Li6', 'sub_editor',   'active')
ON DUPLICATE KEY UPDATE username = username;

-- ---------------------------------------------------------------------
-- Seed the department directory with the site's original 12 departments
-- (4 core + 8 support), already published, owned by the editor account.
-- Edit/replace these freely from the admin once it's running.
-- ---------------------------------------------------------------------
INSERT INTO departments (name, group_type, description, icon, image, link_url, sort_order, status, author_id, reviewed_by) VALUES
('Youth Empowerment & Development', 'core', 'Empowering the youth through leadership programs and developmental initiatives across the nation.', 'psychology', 'assets/departments/youthdevelopment.jpg', 'assets/departments/department-dedicated-pages/youth_empowerment_development.html', 1, 'published', 1, 1),
('Youth Service in Zimbabwe', 'core', 'Cultivating a sense of national service, discipline, and patriotic values among the younger generation.', 'volunteer_activism', 'assets/departments/nationalyouthservice.jpg', 'assets/departments/department-dedicated-pages/youth_service.html', 2, 'published', 1, 1),
('Vocational Training Centers', 'core', 'Providing industry-standard technical skills and certifications to bridge the youth employment gap.', 'handyman', 'assets/departments/commin.jpg', 'assets/departments/department-dedicated-pages/vocational_training.html', 3, 'published', 1, 1),
('Business Development', 'core', 'Supporting youth-led startups and SMEs with strategic resources, financing, and business training.', 'business_center', 'assets/departments/planning.jpg', 'assets/departments/department-dedicated-pages/business_development.html', 4, 'published', 1, 1),
('Procurement Management', 'support', 'Supply chain & acquisition services.', 'shopping_cart', 'assets/departments/procurement.jpg', 'assets/departments/department-dedicated-pages/procurement_management.html', 1, 'published', 1, 1),
('Communication and Advocacy', 'support', 'Public relations & media engagement.', 'campaign', 'assets/departments/communication.jpg', 'assets/departments/department-dedicated-pages/communication_and_advocacy.html', 2, 'published', 1, 1),
('Internal Audit', 'support', 'Financial oversight & compliance.', 'fact_check', 'assets/departments/finance.jpg', 'assets/departments/department-dedicated-pages/internal_audit.html', 3, 'published', 1, 1),
('Human Resources', 'support', 'Staff development & welfare.', 'groups', 'assets/departments/commin.jpg', 'assets/departments/department-dedicated-pages/human_resources.html', 4, 'published', 1, 1),
('Legal Services', 'support', 'Legal advisory & legislative compliance.', 'gavel', 'assets/departments/legal.jpg', 'assets/departments/department-dedicated-pages/legal_services.html', 5, 'published', 1, 1),
('Finance and Administration', 'support', 'Budgeting & financial planning.', 'payments', 'assets/departments/finance.jpg', 'assets/departments/department-dedicated-pages/finance_and_administration.html', 6, 'published', 1, 1),
('Gender Mainstreaming & Wellness', 'support', 'Inclusion & mental health support.', 'diversity_3', 'assets/departments/gender.jpg', 'assets/departments/department-dedicated-pages/gender_mainstreaming.html', 7, 'published', 1, 1),
('Strategic Policy & Evaluation', 'support', 'Monitoring & future planning.', 'analytics', 'assets/departments/planning.jpg', 'assets/departments/department-dedicated-pages/strategic_policy.html', 8, 'published', 1, 1);

-- =====================================================================
-- MULTILINGUAL SUPPORT
-- =====================================================================

CREATE TABLE IF NOT EXISTS languages (
  code         VARCHAR(5)   PRIMARY KEY,
  name         VARCHAR(50)  NOT NULL,
  native_name  VARCHAR(50)  NOT NULL,
  flag         VARCHAR(10)  NOT NULL DEFAULT '🏳',
  is_active    TINYINT(1)   NOT NULL DEFAULT 1,
  sort_order   INT          NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO languages (code, name, native_name, flag, is_active, sort_order) VALUES
('en', 'English',    'English',     '🇬🇧', 1, 1),
('sn', 'Shona',      'ChiShona',    '🇿🇼', 1, 2),
('nd', 'Ndebele',    'isiNdebele',  '🇿🇼', 1, 3)
ON DUPLICATE KEY UPDATE name = name;

CREATE TABLE IF NOT EXISTS content_translations (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  content_type ENUM('news','gallery_items','resources','departments') NOT NULL,
  content_id   INT          NOT NULL,
  language     VARCHAR(5)   NOT NULL,
  field_name   VARCHAR(50)  NOT NULL,
  field_value  LONGTEXT,
  updated_at   DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY uq_translation (content_type, content_id, language, field_name),
  KEY idx_lookup (content_type, content_id, language)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =====================================================================
-- CHATBOT SETTINGS  (key-value store managed via admin/chatbot.php)
-- =====================================================================

CREATE TABLE IF NOT EXISTS chatbot_config (
  cfg_key    VARCHAR(100) PRIMARY KEY,
  cfg_value  TEXT,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO chatbot_config (cfg_key, cfg_value) VALUES
('enabled',         '1'),
('api_key',         ''),
('model',           'claude-sonnet-4-6'),
('max_tokens',      '500'),
('welcome_en',      'Hello! I am the Ministry of Youth Empowerment assistant. How can I help you today?'),
('welcome_sn',      'Mhoro! Ndini mubatsiri weMutsindo weMajaya. Ndingakubatsira sei nhasi?'),
('welcome_nd',      'Sawubona! Ngingumsizi weNdawo Yentsha. Ngingakusiza ngani namuhla?')
ON DUPLICATE KEY UPDATE cfg_key = cfg_key;
