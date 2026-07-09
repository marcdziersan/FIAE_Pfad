USE fiae_mysql;

INSERT INTO kunden (name, email, ort) VALUES
('AGVS GmbH', 'kontakt@agvs.example', 'Lünen'),
('Polaris Nova', 'info@polaris.example', 'Dortmund'),
('Marbyte Lernsysteme', 'lernen@marbyte.example', 'Bochum');

INSERT INTO auftraege (kunde_id, titel, netto, status) VALUES
(1, 'Kanban Board erweitern', 1400.00, 'in_bearbeitung'),
(1, 'CSV-Export testen', 320.00, 'neu'),
(2, 'Portfolio Landingpage', 780.00, 'fertig'),
(3, 'AP2-Fragenimport', 650.00, 'neu');
