-- Esquema de la base de datos "cursox" (inferido del código PHP del proyecto)
SET NAMES utf8mb4;

CREATE DATABASE IF NOT EXISTS cursox
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_unicode_ci;

USE cursox;

-- Usada por: conexion.php, conectar.php, buscar_maestro.php,
--            guardar_perfil.php, guardar_curso.php, modi.php
CREATE TABLE IF NOT EXISTS maestros (
  ID      VARCHAR(20)  NOT NULL,
  Nombre  VARCHAR(150) DEFAULT NULL,
  Tel     VARCHAR(30)  DEFAULT NULL,
  Curso   VARCHAR(200) DEFAULT NULL,
  Tcurso  VARCHAR(50)  DEFAULT NULL,
  Costo   VARCHAR(50)  DEFAULT NULL,
  Foto    VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Usada por: procesar_reseñas.php
-- maestro_id es BIGINT porque las IDs de 10 dígitos desbordan un INT con signo.
CREATE TABLE IF NOT EXISTS reseñas (
  id         INT          NOT NULL AUTO_INCREMENT,
  maestro_id BIGINT       NOT NULL,
  texto      TEXT         NOT NULL,
  PRIMARY KEY (id),
  KEY idx_maestro (maestro_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
