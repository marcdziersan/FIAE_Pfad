# Aufgabe 06 · Firebird Prüfhilfe

## Fachliche Punkte

- Firebird nutzt klassische relationale Konzepte: Tabellen, Primärschlüssel, Fremdschlüssel, Indizes und Transaktionen.
- Ältere Firebird-Projekte arbeiten häufig mit Sequenzen/Generatoren und Triggern für IDs.
- Stored Procedures können Reports oder fachliche Datenbanklogik kapseln.
- `COMMIT` und `ROLLBACK` sind wichtig, weil Änderungen transaktional verarbeitet werden.

## Typische Prüffragen

- Warum braucht `auftraege.kunde_id` einen Fremdschlüssel?
- Was leistet ein Index auf `status`?
- Warum ist eine Stored Procedure nicht immer besser als Logik im Backend?
- Wann nutzt man `COMMIT`, wann `ROLLBACK`?
