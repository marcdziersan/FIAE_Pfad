<?php
/**
 * Aufgabe 03: CRUD mit Prepared Statements.
 * Vor Ausführung Zugangsdaten anpassen.
 */
$mysqli = new mysqli('localhost', 'root', '', 'fiae_mysql');
$mysqli->set_charset('utf8mb4');

if ($mysqli->connect_error) {
    die('DB-Verbindung fehlgeschlagen: ' . $mysqli->connect_error);
}

// CREATE
$stmt = $mysqli->prepare('INSERT INTO kunden (name, email, ort) VALUES (?, ?, ?)');
$name = 'Demo Kunde GmbH';
$email = 'demo@example.de';
$ort = 'Lünen';
$stmt->bind_param('sss', $name, $email, $ort);
$stmt->execute();

// READ
$stmt = $mysqli->prepare('SELECT id, name, email, ort FROM kunden WHERE ort = ? ORDER BY name');
$stmt->bind_param('s', $ort);
$stmt->execute();
$result = $stmt->get_result();
foreach ($result as $row) {
    echo $row['id'] . ' · ' . $row['name'] . ' · ' . $row['email'] . PHP_EOL;
}

// UPDATE
$stmt = $mysqli->prepare('UPDATE kunden SET ort = ? WHERE email = ?');
$neuerOrt = 'Dortmund';
$stmt->bind_param('ss', $neuerOrt, $email);
$stmt->execute();

// DELETE
$stmt = $mysqli->prepare('DELETE FROM kunden WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();

$mysqli->close();
