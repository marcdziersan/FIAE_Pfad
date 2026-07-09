CREATE DATABASE IF NOT EXISTS fiae_mysql
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE fiae_mysql;

DROP TABLE IF EXISTS auftraege;
DROP TABLE IF EXISTS kunden;

CREATE TABLE kunden (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(160) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    ort VARCHAR(120) NOT NULL,
    erstellt_am TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE auftraege (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kunde_id INT NOT NULL,
    titel VARCHAR(180) NOT NULL,
    netto DECIMAL(10,2) NOT NULL,
    status ENUM('neu', 'in_bearbeitung', 'fertig', 'storniert') NOT NULL DEFAULT 'neu',
    erstellt_am TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_auftraege_kunden
        FOREIGN KEY (kunde_id) REFERENCES kunden(id)
        ON DELETE CASCADE
) ENGINE=InnoDB;
