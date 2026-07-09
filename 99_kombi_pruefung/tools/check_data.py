import json
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]
STORAGE = ROOT / "storage"

def read(name: str) -> list[dict]:
    path = STORAGE / name
    if not path.exists():
        return []
    return json.loads(path.read_text(encoding="utf-8"))

def main() -> None:
    contacts = read("contacts.json")
    notes = read("notes.json")
    orders = read("orders.json")
    total_gross = sum(float(order.get("gross", 0)) for order in orders)
    print("Kombi-Prüfung Datenreport")
    print("=========================")
    print(f"Kontakte: {len(contacts)}")
    print(f"Notizen:  {len(notes)}")
    print(f"Aufträge: {len(orders)}")
    print(f"Summe brutto: {total_gross:.2f} EUR")
    if orders:
        print("\nAuftragsliste:")
        for order in orders:
            print(f"- {order.get('customer')} · {order.get('title')} · {float(order.get('gross', 0)):.2f} EUR")

if __name__ == "__main__":
    main()
