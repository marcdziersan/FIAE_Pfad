@echo off
cd 01_hello_world && javac HelloWorld.java && cd ..
cd 02_notiz_cli && javac *.java && cd ..
cd 03_notiz_swing && javac NotesSwingApp.java && cd ..
cd 04_mini_crud_swing && javac *.java && cd ..
cd 05_taschenrechner_swing && javac CalculatorSwing.java && cd ..
cd 06_telefonbuch_swing && javac *.java && cd ..
cd 07_business_app_swing && javac *.java && cd ..
echo Alle Java-Beispiele wurden kompiliert.
