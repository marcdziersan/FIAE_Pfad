import json
import sys
from pathlib import Path

FILE = Path(__file__).with_name("orders.json")

def gross(net: float, vat: float = 0.19) -> float:
    return round(net * (1 + vat), 2)

def load() -> list[dict]:
    if not FILE.exists():
        return []
    return json.loads(FILE.read_text(encoding="utf-8"))

def save(orders: list[dict]) -> None:
    FILE.write_text(json.dumps(orders, indent=2, ensure_ascii=False), encoding="utf-8")

def create(customer: str, title: str, net: float) -> None:
    orders = load()
    orders.append({"customer": customer, "title": title, "net": net, "gross": gross(net), "status": "offen"})
    save(orders)

def report() -> None:
    orders = load()
    total = sum(order["gross"] for order in orders)
    for order in orders:
        print(f"{order['customer']}: {order['title']} · {order['gross']:.2f} EUR · {order['status']}")
    print(f"Summe brutto: {total:.2f} EUR")

if __name__ == "__main__":
    if len(sys.argv) == 5 and sys.argv[1] == "create":
        create(sys.argv[2], sys.argv[3], float(sys.argv[4]))
        print("Auftrag gespeichert.")
    elif len(sys.argv) == 2 and sys.argv[1] == "report":
        report()
    else:
        print("Nutzung: create KUNDE TITEL NETTO | report")
