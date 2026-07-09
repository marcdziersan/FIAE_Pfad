# PHP Lernpfad

Dieser Abschnitt isoliert PHP ohne Framework. Ziel ist ein nachvollziehbarer Weg von Syntax über Formulare bis zu OOP, JSON-Speicherung und einer kleinen API.

## Reihenfolge

1. `01_hello_world` – Ausgabe, Variablen, Datum
2. `02_datentypen_funktionen` – Arrays, Funktionen, einfache Berechnung
3. `03_formular_validierung` – GET/POST, Validierung, Escape-Ausgabe
4. `04_json_crud_notes` – Notizen per JSON speichern, anlegen, löschen
5. `05_oop_repository` – Klasse, Repository, klare Verantwortung
6. `06_mini_api` – kleine JSON-API mit `fetch`-fähigen Endpunkten

## Start

```bash
php -S localhost:8000 -t php/01_hello_world
php -S localhost:8001 -t php/03_formular_validierung
php -S localhost:8002 -t php/04_json_crud_notes/public
php -S localhost:8003 -t php/05_oop_repository/public
php -S localhost:8004 -t php/06_mini_api/public
```
