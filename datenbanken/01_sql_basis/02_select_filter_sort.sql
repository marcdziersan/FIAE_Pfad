-- Aufgabe 02: Daten filtern und sortieren
-- Ziel: SELECT, WHERE, LIKE, BETWEEN und ORDER BY anwenden.

SELECT id, vorname, nachname, ort
FROM kunden
WHERE ort = 'Lünen'
ORDER BY nachname ASC, vorname ASC;

SELECT id, titel, netto, status
FROM auftraege
WHERE netto BETWEEN 100.00 AND 1000.00
ORDER BY netto DESC;

SELECT id, email
FROM kunden
WHERE email LIKE '%@example.de';
