DROP VIEW IF EXISTS v_offene_auftraege;

CREATE VIEW v_offene_auftraege AS
SELECT
    a.id,
    k.name AS kunde,
    a.titel,
    a.netto,
    ROUND(a.netto * 1.19, 2) AS brutto,
    a.status
FROM auftraege a
JOIN kunden k ON k.id = a.kunde_id
WHERE a.status IN ('neu', 'in_bearbeitung');

SELECT * FROM v_offene_auftraege ORDER BY brutto DESC;

SELECT
    k.name,
    COUNT(a.id) AS anzahl,
    ROUND(SUM(a.netto), 2) AS netto_summe
FROM kunden k
LEFT JOIN auftraege a ON a.kunde_id = k.id
GROUP BY k.id, k.name
ORDER BY netto_summe DESC;
