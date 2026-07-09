import json
import sys
from pathlib import Path

FILE = Path(__file__).with_name("telefonbuch.json")

def load() -> list[dict]:
    if not FILE.exists():
        return []
    return json.loads(FILE.read_text(encoding="utf-8"))

def save(contacts: list[dict]) -> None:
    FILE.write_text(json.dumps(contacts, indent=2, ensure_ascii=False), encoding="utf-8")

def add(name: str, email: str, phone: str) -> None:
    contacts = load()
    contacts.append({"name": name, "email": email, "phone": phone})
    save(contacts)

def list_contacts() -> None:
    for index, contact in enumerate(load(), start=1):
        print(f"{index}. {contact['name']} · {contact['email']} · {contact['phone']}")

if __name__ == "__main__":
    if len(sys.argv) >= 2 and sys.argv[1] == "add" and len(sys.argv) == 5:
        add(sys.argv[2], sys.argv[3], sys.argv[4])
        print("Kontakt gespeichert.")
    elif len(sys.argv) == 2 and sys.argv[1] == "list":
        list_contacts()
    else:
        print("Nutzung: add NAME EMAIL PHONE | list")
