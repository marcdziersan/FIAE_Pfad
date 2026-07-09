-- Aufgabe 04: Auswertungen schreiben
-- Ziel: COUNT, SUM, AVG, GROUP BY und HAVING einsetzen.

SELECT
    k.id,
    k.nachname,
    COUNT(a.id) AS anzahl_auftraege,
    COALESCE(SUM(a.netto), 0) AS netto_summe
FROM kunden k
LEFT JOIN auftraege a ON a.kunde_id = k.id
GROUP BY k.id, k.nachname
ORDER BY netto_summe DESC;

SELECT status, COUNT(*) AS anzahl, AVG(netto) AS durchschnitt_netto
FROM auftraege
GROUP BY status
HAVING COUNT(*) >= 1
ORDER BY anzahl DESC;
