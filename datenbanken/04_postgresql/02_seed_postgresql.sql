INSERT INTO kunden (name, email, ort) VALUES
('AGVS GmbH', 'kontakt@agvs.example', 'Lünen'),
('Polaris Nova', 'info@polaris.example', 'Dortmund'),
('Marbyte Lernsysteme', 'lernen@marbyte.example', 'Bochum');

INSERT INTO auftraege (kunde_id, titel, netto, status) VALUES
(1, 'Kanban Light API', 1600.00, 'in_bearbeitung'),
(1, 'Export validieren', 350.00, 'neu'),
(2, 'Webseite strukturieren', 950.00, 'fertig'),
(3, 'Lernplattform Import', 780.00, 'neu');
