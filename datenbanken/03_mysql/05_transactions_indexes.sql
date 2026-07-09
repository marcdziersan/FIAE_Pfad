USE fiae_mysql;

CREATE INDEX idx_auftraege_status ON auftraege(status);
CREATE INDEX idx_auftraege_kunde ON auftraege(kunde_id);

START TRANSACTION;

UPDATE auftraege
SET status = 'fertig'
WHERE id = 2 AND status = 'neu';

INSERT INTO auftraege (kunde_id, titel, netto, status)
VALUES (2, 'Wartung und Nachpflege', 250.00, 'neu');

COMMIT;

EXPLAIN SELECT * FROM auftraege WHERE status = 'neu';
