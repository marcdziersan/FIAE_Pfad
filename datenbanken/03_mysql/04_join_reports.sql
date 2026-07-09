USE fiae_mysql;

SELECT
    k.name AS kunde,
    COUNT(a.id) AS anzahl_auftraege,
    COALESCE(SUM(a.netto), 0) AS netto_summe,
    COALESCE(SUM(a.netto * 1.19), 0) AS brutto_summe
FROM kunden k
LEFT JOIN auftraege a ON a.kunde_id = k.id
GROUP BY k.id, k.name
ORDER BY netto_summe DESC;

SELECT
    status,
    COUNT(*) AS anzahl,
    ROUND(AVG(netto), 2) AS durchschnitt
FROM auftraege
GROUP BY status
ORDER BY anzahl DESC;
