CREATE INDEX IF NOT EXISTS idx_auftraege_status ON auftraege(status);
CREATE INDEX IF NOT EXISTS idx_auftraege_kunde ON auftraege(kunde_id);

BEGIN TRANSACTION;

UPDATE auftraege
SET status = 'fertig'
WHERE id = 2;

INSERT INTO auftraege (kunde_id, titel, netto, status)
VALUES (2, 'Wartungspaket', 299.00, 'neu');

COMMIT;

EXPLAIN QUERY PLAN
SELECT * FROM auftraege WHERE status = 'neu';
