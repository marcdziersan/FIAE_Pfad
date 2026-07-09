#!/usr/bin/env bash
set -euo pipefail

(cd 01_hello_world && javac HelloWorld.java)
(cd 02_notiz_cli && javac *.java)
(cd 03_notiz_swing && javac NotesSwingApp.java)
(cd 04_mini_crud_swing && javac *.java)
(cd 05_taschenrechner_swing && javac CalculatorSwing.java)
(cd 06_telefonbuch_swing && javac *.java)
(cd 07_business_app_swing && javac *.java)

echo "Alle Java-Beispiele wurden kompiliert."
