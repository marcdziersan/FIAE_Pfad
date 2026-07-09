# Datenbanken · SQL, SQLite, MySQL, PostgreSQL, Firebird und MongoDB

Dieser zusätzliche Lernpfad ergänzt den FIAE-Grundlagenpfad um Datenbankgrundlagen. Der Fokus liegt auf nachvollziehbaren Aufgaben: Schema entwerfen, Daten einfügen, abfragen, ändern, löschen, auswerten, Transaktionen verstehen und einfache Reports erzeugen.

## Struktur

```text
datenbanken/
├── 01_sql_basis/       # allgemeine SQL-Grundlagen
├── 02_sqlite/          # SQLite lokal, ohne Server
├── 03_mysql/           # MySQL/MariaDB-nahe Aufgaben
├── 04_postgresql/      # PostgreSQL mit CTE, Views und Funktionen
├── 05_firebird/        # Firebird SQL, Sequenzen, Trigger, Stored Procedures
└── 06_mongodb/         # Dokumentdatenbank, CRUD, Aggregation und Indizes
```

## Lernziele

- Tabellen und Beziehungen modellieren
- Primärschlüssel, Fremdschlüssel, Constraints und Indizes einsetzen
- CRUD-Abfragen schreiben
- JOIN, GROUP BY, HAVING, Views und Reports anwenden
- Transaktionen und Datenintegrität erklären
- Unterschiede zwischen relationalen Datenbanken und MongoDB nachvollziehen

## Prüfbare Variante

SQLite ist ohne Datenbankserver prüfbar:

```bash
python datenbanken/02_sqlite/06_sqlite_pruefung.py
```

Die anderen Ordner enthalten ausführbare bzw. übertragbare Skripte für die jeweilige Datenbankumgebung. Sie sind bewusst klein gehalten und fachlich kommentiert.
