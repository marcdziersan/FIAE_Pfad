def gross(net: float, vat: float = 0.19) -> float:
    if net < 0:
        raise ValueError("net must be positive")
    return round(net * (1 + vat), 2)

def order_total_gross(orders: list[dict]) -> float:
    return round(sum(order["gross"] for order in orders), 2)
