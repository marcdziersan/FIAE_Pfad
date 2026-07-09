INSERT INTO kunden (id, name, email, ort) VALUES (1, 'AGVS GmbH', 'kontakt@agvs.example', 'Lünen');
INSERT INTO kunden (id, name, email, ort) VALUES (2, 'Polaris Nova', 'info@polaris.example', 'Dortmund');
INSERT INTO kunden (id, name, email, ort) VALUES (3, 'Marbyte Lernsysteme', 'lernen@marbyte.example', 'Bochum');

INSERT INTO auftraege (id, kunde_id, titel, netto, status) VALUES (1, 1, 'Bestandsmaske prüfen', 900.00, 'in_bearbeitung');
INSERT INTO auftraege (id, kunde_id, titel, netto, status) VALUES (2, 1, 'Report erstellen', 430.00, 'neu');
INSERT INTO auftraege (id, kunde_id, titel, netto, status) VALUES (3, 2, 'Datenimport', 750.00, 'fertig');
INSERT INTO auftraege (id, kunde_id, titel, netto, status) VALUES (4, 3, 'Lernsystem Auswertung', 520.00, 'neu');

COMMIT;
