-- CREATE
INSERT INTO kunden (name, email, ort)
VALUES ('Beispielkunde GmbH', 'kunde@example.de', 'Kamen');

-- READ
SELECT id, name, email, ort
FROM kunden
ORDER BY name;

-- UPDATE
UPDATE kunden
SET ort = 'Unna'
WHERE email = 'kunde@example.de';

-- DELETE
DELETE FROM kunden
WHERE email = 'kunde@example.de';
