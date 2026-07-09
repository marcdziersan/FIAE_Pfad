INSERT INTO kunden (name, email, ort) VALUES
('AGVS GmbH', 'kontakt@agvs.example', 'Lünen'),
('Polaris Nova', 'info@polaris.example', 'Dortmund'),
('Marbyte Lernsysteme', 'lernen@marbyte.example', 'Bochum');

INSERT INTO auftraege (kunde_id, titel, netto, status) VALUES
(1, 'Interne Aufgabenverwaltung', 1250.00, 'in_bearbeitung'),
(1, 'CSV-Export erweitern', 350.00, 'neu'),
(2, 'Landingpage optimieren', 890.00, 'fertig'),
(3, 'Fragenimport prüfen', 640.00, 'neu');
