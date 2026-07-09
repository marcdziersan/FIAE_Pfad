# Lernstrecke: HTML, CSS, JavaScript und PHP

Diese Lernstrecke zeigt Webgrundlagen von statischen Seiten bis zu kleinen PHP-Anwendungen mit JSON-Speicher.

## Beispiele

```text
01_hello_world              Statische HTML-Seite mit CSS und JavaScript
02_notiz_app_frontend       Notiz-App nur im Browser mit localStorage
03_notiz_app_php_json       PHP-CRUD mit JSON-Datei als Speicher
04_login_session_demo       PHP-Session-Demo mit einfacher geschützter Notizseite
05_taschenrechner_php_js    Taschenrechner mit JS-Vorschau und PHP-Ergebnis
06_telefonbuch_php_json     Telefonbuch-CRUD mit JSON-Datei
07_business_app_php_json    Mini-Auftragsverwaltung mit Business-Berechnung
```

## Start

### 01 und 02

Die Datei `index.html` direkt im Browser öffnen.

### 03 PHP JSON CRUD

```bash
cd web-php/03_notiz_app_php_json
php -S localhost:8000 -t public
```

### 04 Login/Session Demo

```bash
cd web-php/04_login_session_demo
php -S localhost:8001 -t public
```

Demo-Login:

```text
Benutzer: marcus
Passwort: fiae
```

### 05 Taschenrechner

```bash
cd web-php/05_taschenrechner_php_js
php -S localhost:8002 -t public
```

### 06 Telefonbuch

```bash
cd web-php/06_telefonbuch_php_json
php -S localhost:8003 -t public
```

### 07 Business-App

```bash
cd web-php/07_business_app_php_json
php -S localhost:8004 -t public
```
