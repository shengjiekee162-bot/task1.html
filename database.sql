DROP DATABASE IF EXISTS e_commerce_auth;
CREATE DATABASE e_commerce_auth CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE e_commerce_auth;

-- Roles
CREATE TABLE Roles (
    RoleId CHAR(36) PRIMARY KEY,
    RoleName VARCHAR(50) NOT NULL UNIQUE
);

-- Users
CREATE TABLE Users (
    UserId CHAR(36) PRIMARY KEY,
    RoleId CHAR(36) NOT NULL,
    Email VARCHAR(255) NOT NULL UNIQUE,
    PasswordHash VARCHAR(255) NOT NULL,
    IsActive BOOLEAN DEFAULT TRUE,
    FailedAttempts INT DEFAULT 0,
    LockUntil DATETIME NULL,
    ResetToken CHAR(36) NULL,
    ResetTokenExpiry DATETIME NULL,
    LastLogin DATETIME NULL,
    CreatedDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (RoleId) REFERENCES Roles(RoleId)
);

INSERT INTO Roles (RoleId, RoleName)
VALUES
    (UUID(), 'Admin'),
    (UUID(), 'Member');