-- Aufgabe 06: Benutzer und Export einordnen.
-- Diese Befehle nur in einer lokalen Lernumgebung verwenden.

CREATE USER IF NOT EXISTS 'fiae_user'@'localhost' IDENTIFIED BY 'change-me-local-only';
GRANT SELECT, INSERT, UPDATE, DELETE ON fiae_mysql.* TO 'fiae_user'@'localhost';
FLUSH PRIVILEGES;

-- Export-Beispiel im Terminal, nicht in der SQL-Konsole:
-- mysqldump -u root -p fiae_mysql > fiae_mysql_backup.sql

-- Import-Beispiel im Terminal:
-- mysql -u root -p fiae_mysql < fiae_mysql_backup.sql
