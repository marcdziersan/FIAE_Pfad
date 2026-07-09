import sys

def calculate(a: float, op: str, b: float) -> float:
    if op == "+":
        return a + b
    if op == "-":
        return a - b
    if op == "*":
        return a * b
    if op == "/":
        if b == 0:
            raise ValueError("Division durch 0 ist nicht erlaubt.")
        return a / b
    raise ValueError("Unbekannter Operator.")

if __name__ == "__main__":
    if len(sys.argv) != 4:
        print("Nutzung: python 03_taschenrechner_cli.py 10 + 5")
        sys.exit(1)
    try:
        print(calculate(float(sys.argv[1]), sys.argv[2], float(sys.argv[3])))
    except ValueError as exc:
        print(f"Fehler: {exc}")
        sys.exit(2)
