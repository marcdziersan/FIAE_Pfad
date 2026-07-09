#!/usr/bin/env python3
"""Prüft den SQLite-Lernpfad ohne externen Datenbankserver."""
from __future__ import annotations

import sqlite3
from pathlib import Path

BASE = Path(__file__).resolve().parent
DB_PATH = BASE / "lernpfad.sqlite"


def run_script(con: sqlite3.Connection, filename: str) -> None:
    sql = (BASE / filename).read_text(encoding="utf-8")
    con.executescript(sql)


def main() -> None:
    if DB_PATH.exists():
        DB_PATH.unlink()

    con = sqlite3.connect(DB_PATH)
    con.row_factory = sqlite3.Row
    con.execute("PRAGMA foreign_keys = ON")

    run_script(con, "01_create_database.sql")
    run_script(con, "02_seed_data.sql")
    run_script(con, "04_views_reports.sql")
    run_script(con, "05_transactions_indexes.sql")

    kunden = con.execute("SELECT COUNT(*) AS c FROM kunden").fetchone()["c"]
    auftraege = con.execute("SELECT COUNT(*) AS c FROM auftraege").fetchone()["c"]
    offene = con.execute("SELECT COUNT(*) AS c FROM v_offene_auftraege").fetchone()["c"]
    netto = con.execute("SELECT ROUND(SUM(netto), 2) AS s FROM auftraege").fetchone()["s"]

    assert kunden >= 3, "Es sollten mindestens drei Kunden vorhanden sein."
    assert auftraege >= 5, "Es sollten mindestens fünf Aufträge vorhanden sein."
    assert offene >= 1, "Die View sollte offene Aufträge liefern."
    assert netto > 0, "Die Netto-Summe muss positiv sein."

    print("SQLite-Prüfung erfolgreich")
    print(f"Kunden: {kunden}")
    print(f"Aufträge: {auftraege}")
    print(f"Offene Aufträge: {offene}")
    print(f"Netto-Summe: {netto:.2f} EUR")

    con.close()


if __name__ == "__main__":
    main()
