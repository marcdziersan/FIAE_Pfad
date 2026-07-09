-- Aufgabe 01: relationales Grundschema entwerfen
-- Ziel: Kunden und Aufträge mit Primär-/Fremdschlüssel modellieren.

CREATE TABLE kunden (
    id INTEGER PRIMARY KEY,
    vorname VARCHAR(80) NOT NULL,
    nachname VARCHAR(80) NOT NULL,
    email VARCHAR(160) NOT NULL UNIQUE,
    ort VARCHAR(120) NOT NULL
);

CREATE TABLE auftraege (
    id INTEGER PRIMARY KEY,
    kunde_id INTEGER NOT NULL,
    titel VARCHAR(160) NOT NULL,
    netto DECIMAL(10, 2) NOT NULL,
    status VARCHAR(30) NOT NULL,
    erstellt_am DATE NOT NULL,
    FOREIGN KEY (kunde_id) REFERENCES kunden(id)
);
