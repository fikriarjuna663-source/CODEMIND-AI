CREATE DATABASE IF NOT EXISTS codemind_ai;
USE codemind_ai;

CREATE TABLE users (

id INT AUTO_INCREMENT PRIMARY KEY,

nama_lengkap VARCHAR(100) NOT NULL,

username VARCHAR(50) NOT NULL UNIQUE,

email VARCHAR(100) NOT NULL UNIQUE,

password VARCHAR(255) NOT NULL,

role ENUM('admin','user') DEFAULT 'user',

foto VARCHAR(255) DEFAULT 'default.png',

status ENUM('aktif','nonaktif') DEFAULT 'aktif',

created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

CREATE TABLE conversations (

id INT AUTO_INCREMENT PRIMARY KEY,

user_id INT NOT NULL,

judul VARCHAR(255) DEFAULT 'Percakapan Baru',

created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE

);

CREATE TABLE messages (

id INT AUTO_INCREMENT PRIMARY KEY,

conversation_id INT NOT NULL,

sender ENUM('user','ai') NOT NULL,

message LONGTEXT,

created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

FOREIGN KEY(conversation_id) REFERENCES conversations(id) ON DELETE CASCADE

);

CREATE TABLE settings (

id INT AUTO_INCREMENT PRIMARY KEY,

user_id INT NOT NULL,

theme VARCHAR(20) DEFAULT 'dark',

language VARCHAR(20) DEFAULT 'id',

api_key TEXT,

FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE

);

CREATE TABLE activity_logs (

id INT AUTO_INCREMENT PRIMARY KEY,

user_id INT,

aktivitas VARCHAR(255),

created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE SET NULL

);