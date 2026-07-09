def brutto(netto: float, mwst: float = 0.19) -> float:
    return round(netto * (1 + mwst), 2)

positionen = [120.0, 350.0, 80.0]
summe = sum(positionen)
report = {
    "positionen_netto": positionen,
    "summe_netto": summe,
    "summe_brutto": brutto(summe),
    "themen": ["Listen", "Dicts", "Funktionen", "Formatierung"],
}

for key, value in report.items():
    print(f"{key}: {value}")
