<?php
final class OrderRepository
{
    public function __construct(private string $file)
    {
        if (!file_exists($file)) {
            file_put_contents($file, json_encode([], JSON_PRETTY_PRINT));
        }
    }

    public function all(): array
    {
        $data = json_decode(file_get_contents($this->file), true);
        $orders = is_array($data) ? $data : [];
        usort($orders, fn($a, $b) => strcmp($b['created_at'], $a['created_at']));
        return $orders;
    }

    public function save(array $orders): void
    {
        file_put_contents($this->file, json_encode(array_values($orders), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public function create(string $customer, string $title, float $net, string $status): void
    {
        $orders = $this->all();
        $orders[] = [
            'id' => time() . random_int(100, 999),
            'customer' => $customer,
            'title' => $title,
            'net' => round($net, 2),
            'vat' => round($net * 0.19, 2),
            'gross' => round($net * 1.19, 2),
            'status' => $status,
            'created_at' => date('Y-m-d H:i'),
        ];
        $this->save($orders);
    }

    public function updateStatus(string $id, string $status): void
    {
        $orders = $this->all();
        foreach ($orders as &$order) {
            if ((string)$order['id'] === $id) {
                $order['status'] = $status;
            }
        }
        $this->save($orders);
    }

    public function delete(string $id): void
    {
        $this->save(array_filter($this->all(), fn(array $order) => (string)$order['id'] !== $id));
    }

    public function totals(): array
    {
        $net = 0.0; $vat = 0.0; $gross = 0.0;
        foreach ($this->all() as $order) {
            $net += (float)$order['net'];
            $vat += (float)$order['vat'];
            $gross += (float)$order['gross'];
        }
        return ['net' => $net, 'vat' => $vat, 'gross' => $gross];
    }
}
