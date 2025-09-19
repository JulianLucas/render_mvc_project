-- Script de inicialización de base de datos para Web2 (MySQL)
-- Ejecuta este archivo desde phpMyAdmin (Importar) o con el CLI de MySQL.

CREATE DATABASE IF NOT EXISTS web2
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE web2;

CREATE TABLE IF NOT EXISTS usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
