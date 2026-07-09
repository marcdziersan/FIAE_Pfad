# Lernstrecke: Go

Diese Lernstrecke zeigt Go-Grundlagen von einfacher Ausgabe bis zu kleinen CLI- und Web-Anwendungen mit JSON-Persistenz.

## Beispiele

```text
01_hello_world          einfache Ausgabe
02_basics               Variablen, Funktionen, Structs, Slices
03_notiz_cli_json       CLI-Notiz-App mit JSON-Datei
04_notiz_web_json       Web-Notiz-App mit net/http und JSON-Datei
05_taschenrechner_cli   CLI-Taschenrechner mit Fehlerbehandlung
06_telefonbuch_cli_json CLI-Telefonbuch mit JSON-Datei
07_business_app_web_json Web-Auftragsverwaltung mit JSON-Datei
```

## Ausführen

```bash
cd go/01_hello_world && go run .
cd ../02_basics && go run .
cd ../03_notiz_cli_json && go run . add "HTML wiederholen" "Semantik und Formulare"
cd ../04_notiz_web_json && go run .
cd ../05_taschenrechner_cli && go run . 12 + 5
cd ../06_telefonbuch_cli_json && go run . add "Max Muster" "0231 123456" "max@example.de"
cd ../07_business_app_web_json && go run .
```
