# 99 · Kombinierter Prüfpfad

Diese Anwendung verbindet die getrennten Lernpfade am Ende in einem prüfbaren Mini-Projekt.

## Enthaltene Kompetenzen

- **HTML:** semantische Struktur, Formulare, Tabellen, Landmarken
- **CSS:** responsive Layouts, Cards, Statusfarben, Druckansicht
- **JavaScript:** DOM, Events, Validierung, Fetch, Rendering
- **PHP:** JSON-API, Routing über Request-Methode, Validierung, HTTP-Statuscodes
- **Python:** Prüfskript für Datenbestand und Summenreport

## Anwendung

Mini-Business-Board für Kontakte, Notizen und Aufträge. Die Daten werden als JSON gespeichert.

## Start

```bash
php -S localhost:8099 -t 99_kombi_pruefung/public
```

Browser öffnen:

```text
http://localhost:8099
```

## Python-Prüfung

```bash
python 99_kombi_pruefung/tools/check_data.py
```

Das Skript liest die JSON-Dateien und gibt eine prüfbare Zusammenfassung aus.
