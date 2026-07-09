# FIAE Grundlagenpfad

Dieses Repository ist ein didaktischer Grundlagenpfad für die Anwendungsentwicklung. Es ergänzt größere Praxisprojekte durch kleine, klar prüfbare Lernstationen.

Der Fokus liegt auf Nachvollziehbarkeit: jedes Teilprojekt ist bewusst klein gehalten, lokal startbar und mit einem klaren Lernziel versehen.

## Struktur

```text
fiae-grundlagenpfad/
├── web-php/              # bisheriger kombinierter Web/PHP-Pfad
├── go/                   # Go-Grundlagen und kleine Anwendungen
├── java/                 # Java CLI und Swing, javac-kompilierbar
├── php/                  # eigener PHP-Lernpfad
├── js/                   # eigener JavaScript-Lernpfad
├── python/               # eigener Python-Lernpfad
├── html/                 # eigener HTML-Lernpfad
├── css/                  # eigener CSS-Lernpfad
├── datenbanken/          # SQL, SQLite, MySQL, PostgreSQL, Firebird, MongoDB
└── 99_kombi_pruefung/    # Kombination aus HTML, CSS, JS, PHP und Python
```

## Zweck

Der Pfad zeigt Grundlagen in kleinen, prüfbaren Schritten:

- Ausgabe und Syntax
- Variablen, Funktionen, Arrays/Listen
- Formulare und Validierung
- DOM, Events und Fetch
- JSON-Speicherung
- CRUD-Grundmuster
- kleine Business-Logik
- einfache Tests und Prüfskripte
- responsive und semantische Oberfläche
- relationale Datenbanken und dokumentorientierte Datenhaltung
- SQL-Reports, Transaktionen, Indizes und CRUD

## Datenbankpfad

Der zusätzliche Ordner `datenbanken` enthält eigene Aufgabenpakete für SQL, SQLite, MySQL, PostgreSQL, Firebird und MongoDB. Jede Datenbankstrecke umfasst mehrere kleine Skripte oder Aufgaben und ist auf typische FIAE-Grundlagen ausgelegt. SQLite ist direkt lokal prüfbar:

```bash
python datenbanken/02_sqlite/06_sqlite_pruefung.py
```

## Abschluss-Kombination

Die Anwendung `99_kombi_pruefung` verbindet am Ende HTML, CSS, JavaScript, PHP und Python:

```bash
php -S localhost:8099 -t 99_kombi_pruefung/public
python 99_kombi_pruefung/tools/check_data.py
```

Damit sind die Einzelpfade nicht nur separat, sondern auch im Zusammenspiel prüfbar.

## Hinweis zur Einordnung

Dieses Repository ist nicht als Ersatz für größere Portfolio-Projekte gedacht. Es dient als sauberer Grundlagen- und Nachweispfad, damit Lernschritte, Basiswissen und technische Kernmuster schnell nachvollzogen werden können.
