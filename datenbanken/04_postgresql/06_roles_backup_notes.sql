-- Aufgabe 06: Rollen und Backup einordnen.
-- Nur in lokaler Lernumgebung verwenden.

CREATE ROLE fiae_reader LOGIN PASSWORD 'change-me-local-only';
GRANT CONNECT ON DATABASE fiae_lernpfad TO fiae_reader;
GRANT USAGE ON SCHEMA public TO fiae_reader;
GRANT SELECT ON ALL TABLES IN SCHEMA public TO fiae_reader;

-- Export-Beispiel im Terminal:
-- pg_dump -U postgres -d fiae_lernpfad -f fiae_lernpfad_backup.sql

-- Import-Beispiel im Terminal:
-- psql -U postgres -d fiae_lernpfad -f fiae_lernpfad_backup.sql
