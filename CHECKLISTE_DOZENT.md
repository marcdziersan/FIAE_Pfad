# Checkliste für die Sichtung

## Allgemein

- [ ] Repository ist klar strukturiert
- [ ] Jede Technologie besitzt einen eigenen Lernpfad
- [ ] Beispiele sind lokal startbar
- [ ] README-Dateien erklären Zweck und Start
- [ ] Keine externen Frameworks notwendig

## HTML

- [ ] Semantische Elemente vorhanden
- [ ] Formulare mit Labels vorhanden
- [ ] Tabellen korrekt ausgezeichnet
- [ ] Grundlegende Barrierefreiheit berücksichtigt

## CSS

- [ ] Box-Modell nachvollziehbar
- [ ] Flexbox-Beispiel vorhanden
- [ ] Grid/responsives Layout vorhanden
- [ ] Zustände/Animation vorhanden
- [ ] Print-Styles vorhanden

## JavaScript

- [ ] DOM-Manipulation vorhanden
- [ ] Events vorhanden
- [ ] Taschenrechner vorhanden
- [ ] localStorage-CRUD vorhanden
- [ ] Fetch-Beispiel vorhanden

## PHP

- [ ] Ausgabe/Variablen/Funktionen vorhanden
- [ ] Formularvalidierung vorhanden
- [ ] JSON-CRUD vorhanden
- [ ] OOP/Repository vorhanden
- [ ] Mini-API vorhanden

## Python

- [ ] CLI-Skripte vorhanden
- [ ] Taschenrechner vorhanden
- [ ] Telefonbuch mit JSON vorhanden
- [ ] Business-Logik vorhanden
- [ ] Unit-Test vorhanden


## Datenbanken

- [ ] Allgemeine SQL-Aufgaben vorhanden
- [ ] SQLite-Pfad mit lokalem Prüfskript vorhanden
- [ ] MySQL/MariaDB-Skripte vorhanden
- [ ] PostgreSQL-Skripte vorhanden
- [ ] Firebird-Skripte vorhanden
- [ ] MongoDB-Skripte vorhanden
- [ ] CRUD, JOIN/Aggregation, Indizes und Transaktionen werden abgedeckt

## Bestehende Pfade

- [ ] Web/PHP enthält Taschenrechner, Telefonbuch, Business-App
- [ ] Go enthält Taschenrechner, Telefonbuch, Business-App
- [ ] Java enthält Taschenrechner, Telefonbuch, Business-App

## Kombinierte Prüfung

- [ ] `99_kombi_pruefung` startet per PHP-Built-in-Server
- [ ] Frontend nutzt HTML/CSS/JS
- [ ] Backend nutzt PHP-API
- [ ] Speicherung erfolgt in JSON
- [ ] Python-Prüfskript erzeugt Report

## Startbefehle

```bash
php -S localhost:8099 -t 99_kombi_pruefung/public
python 99_kombi_pruefung/tools/check_data.py
python -m unittest discover -s python/06_tests
python datenbanken/02_sqlite/06_sqlite_pruefung.py
```
