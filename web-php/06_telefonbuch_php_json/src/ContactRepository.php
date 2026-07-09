<?php
final class ContactRepository
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
        return is_array($data) ? $data : [];
    }

    public function search(string $term): array
    {
        $term = mb_strtolower(trim($term));
        if ($term === '') {
            return $this->all();
        }
        return array_values(array_filter($this->all(), function (array $contact) use ($term): bool {
            return str_contains(mb_strtolower($contact['name']), $term)
                || str_contains(mb_strtolower($contact['phone']), $term)
                || str_contains(mb_strtolower($contact['email']), $term);
        }));
    }

    public function save(array $contacts): void
    {
        file_put_contents($this->file, json_encode(array_values($contacts), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public function create(string $name, string $phone, string $email): void
    {
        $contacts = $this->all();
        $contacts[] = [
            'id' => time() . random_int(100, 999),
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'created_at' => date('Y-m-d H:i'),
        ];
        $this->save($contacts);
    }

    public function delete(string $id): void
    {
        $this->save(array_filter($this->all(), fn(array $contact) => (string)$contact['id'] !== $id));
    }
}
