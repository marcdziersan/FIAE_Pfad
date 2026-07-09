-- Aufgabe 03: Tabellen verbinden
-- Ziel: INNER JOIN und LEFT JOIN unterscheiden.

-- Nur Kunden mit Auftrag:
SELECT k.nachname, k.email, a.titel, a.netto, a.status
FROM kunden k
INNER JOIN auftraege a ON a.kunde_id = k.id
ORDER BY k.nachname, a.id;

-- Alle Kunden, auch ohne Auftrag:
SELECT k.nachname, k.email, a.titel, a.status
FROM kunden k
LEFT JOIN auftraege a ON a.kunde_id = k.id
ORDER BY k.nachname;
