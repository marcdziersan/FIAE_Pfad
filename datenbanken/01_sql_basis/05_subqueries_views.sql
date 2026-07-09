-- Aufgabe 05: Subquery und View
-- Ziel: wiederverwendbare Abfragen strukturieren.

SELECT titel, netto
FROM auftraege
WHERE netto > (SELECT AVG(netto) FROM auftraege)
ORDER BY netto DESC;

CREATE VIEW v_auftragsuebersicht AS
SELECT
    k.vorname,
    k.nachname,
    k.email,
    a.titel,
    a.netto,
    ROUND(a.netto * 1.19, 2) AS brutto,
    a.status
FROM kunden k
JOIN auftraege a ON a.kunde_id = k.id;

SELECT * FROM v_auftragsuebersicht ORDER BY nachname;
