CREATE DATABASE IF NOT EXISTS codemind_ai;
USE codemind_ai;

-- ===========================
-- USERS
-- ===========================

CREATE TABLE users(

id INT AUTO_INCREMENT PRIMARY KEY,

nama_lengkap VARCHAR(100) NOT NULL,

username VARCHAR(50) UNIQUE NOT NULL,

email VARCHAR(100) UNIQUE NOT NULL,

password VARCHAR(255) NOT NULL,

foto VARCHAR(255) DEFAULT 'avatar-default.png',

created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

-- ===========================
-- CONVERSATIONS
-- ===========================

CREATE TABLE conversations(

id INT AUTO_INCREMENT PRIMARY KEY,

user_id INT NOT NULL,

title VARCHAR(255) DEFAULT 'New Chat',

created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

FOREIGN KEY(user_id)
REFERENCES users(id)
ON DELETE CASCADE

);

-- ===========================
-- MESSAGES
-- ===========================

CREATE TABLE messages(

id INT AUTO_INCREMENT PRIMARY KEY,

conversation_id INT NOT NULL,

sender ENUM('user','ai') NOT NULL,

message LONGTEXT,

created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

FOREIGN KEY(conversation_id)
REFERENCES conversations(id)
ON DELETE CASCADE

);

-- ===========================
-- SETTINGS
-- ===========================

CREATE TABLE settings(

id INT AUTO_INCREMENT PRIMARY KEY,

user_id INT NOT NULL,

theme ENUM('dark','light') DEFAULT 'dark',

language VARCHAR(30) DEFAULT 'Indonesia',

created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

FOREIGN KEY(user_id)
REFERENCES users(id)
ON DELETE CASCADE

);