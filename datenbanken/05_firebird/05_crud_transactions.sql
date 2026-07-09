-- CREATE
INSERT INTO kunden (id, name, email, ort)
VALUES (10, 'Demo Kunde GmbH', 'demo@example.de', 'Lünen');

-- READ
SELECT id, name, email, ort
FROM kunden
ORDER BY name;

-- UPDATE
UPDATE kunden
SET ort = 'Dortmund'
WHERE email = 'demo@example.de';

-- DELETE
DELETE FROM kunden
WHERE email = 'demo@example.de';

COMMIT;

CREATE INDEX idx_auftraege_status ON auftraege(status);
CREATE INDEX idx_auftraege_kunde ON auftraege(kunde_id);
