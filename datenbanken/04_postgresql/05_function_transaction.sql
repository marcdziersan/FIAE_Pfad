CREATE OR REPLACE FUNCTION brutto(netto NUMERIC)
RETURNS NUMERIC AS $$
BEGIN
    RETURN ROUND(netto * 1.19, 2);
END;
$$ LANGUAGE plpgsql;

BEGIN;

UPDATE auftraege
SET status = 'fertig'
WHERE id = 2 AND status = 'neu';

INSERT INTO auftraege (kunde_id, titel, netto, status)
VALUES (2, 'Nachpflege', 290.00, 'neu');

COMMIT;

SELECT titel, netto, brutto(netto) AS brutto FROM auftraege;
