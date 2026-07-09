-- Aufgabe 06: Transaktionen und Indizes
-- Ziel: Datenintegrität und Performance-Grundlagen erklären.

CREATE INDEX idx_auftraege_kunde_id ON auftraege(kunde_id);
CREATE INDEX idx_auftraege_status ON auftraege(status);

-- Beispiel: Statuswechsel als zusammenhängende Einheit
BEGIN TRANSACTION;

UPDATE auftraege
SET status = 'in_bearbeitung'
WHERE id = 1 AND status = 'neu';

-- COMMIT bestätigt die Änderung dauerhaft.
COMMIT;

-- Bei Fehlern würde statt COMMIT ein ROLLBACK erfolgen.
