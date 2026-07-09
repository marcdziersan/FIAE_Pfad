PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS auftraege;
DROP TABLE IF EXISTS kunden;

CREATE TABLE kunden (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    ort TEXT NOT NULL,
    erstellt_am TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE auftraege (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    kunde_id INTEGER NOT NULL,
    titel TEXT NOT NULL,
    netto REAL NOT NULL CHECK (netto >= 0),
    status TEXT NOT NULL CHECK (status IN ('neu', 'in_bearbeitung', 'fertig', 'storniert')),
    erstellt_am TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (kunde_id) REFERENCES kunden(id) ON DELETE CASCADE
);
