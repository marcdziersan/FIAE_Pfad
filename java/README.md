# Lernstrecke: Java

Diese Lernstrecke zeigt Java-Grundlagen bis zu mehreren Swing-Anwendungen. Alle Beispiele sind mit `javac` kompilierbar und benötigen keine externen Bibliotheken.

## Beispiele

```text
01_hello_world          Konsolenausgabe
02_notiz_cli            CLI-Notiz-App mit Textdatei
03_notiz_swing          einfache Swing-Oberfläche
04_mini_crud_swing      vollständige Swing-CRUD-App mit Speicherung
05_taschenrechner_swing Swing-Taschenrechner
06_telefonbuch_swing    Swing-Telefonbuch mit Speicherung
07_business_app_swing   Swing-Auftragsverwaltung mit MwSt-Berechnung
```

## Ausführen

```bash
cd java/01_hello_world && javac HelloWorld.java && java HelloWorld
cd ../02_notiz_cli && javac *.java && java NotesCli list
cd ../03_notiz_swing && javac NotesSwingApp.java && java NotesSwingApp
cd ../04_mini_crud_swing && javac *.java && java NotesCrudSwing
cd ../05_taschenrechner_swing && javac CalculatorSwing.java && java CalculatorSwing
cd ../06_telefonbuch_swing && javac *.java && java PhoneBookSwing
cd ../07_business_app_swing && javac *.java && java BusinessAppSwing
```

Alle Beispiele kompilieren:

```bash
cd java
./compile_all.sh
```
