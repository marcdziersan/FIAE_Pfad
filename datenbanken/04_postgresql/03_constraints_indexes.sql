CREATE INDEX idx_auftraege_status ON auftraege(status);
CREATE INDEX idx_auftraege_kunde_id ON auftraege(kunde_id);
CREATE INDEX idx_kunden_ort ON kunden(ort);

-- Erwartet Fehler wegen CHECK-Constraint:
-- INSERT INTO auftraege (kunde_id, titel, netto, status)
-- VALUES (1, 'Fehlerhafter Auftrag', -1.00, 'neu');

EXPLAIN
SELECT * FROM auftraege WHERE status = 'neu';
