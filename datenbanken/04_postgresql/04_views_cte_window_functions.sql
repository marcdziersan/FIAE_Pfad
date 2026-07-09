CREATE OR REPLACE VIEW v_umsatz_kunden AS
SELECT
    k.id,
    k.name,
    COUNT(a.id) AS anzahl_auftraege,
    COALESCE(SUM(a.netto), 0) AS netto_summe
FROM kunden k
LEFT JOIN auftraege a ON a.kunde_id = k.id
GROUP BY k.id, k.name;

WITH offene_auftraege AS (
    SELECT * FROM auftraege WHERE status IN ('neu', 'in_bearbeitung')
)
SELECT
    k.name,
    o.titel,
    o.netto,
    RANK() OVER (ORDER BY o.netto DESC) AS wert_rang
FROM offene_auftraege o
JOIN kunden k ON k.id = o.kunde_id;
