<?php declare(strict_types=1);

final class NoteStore
{
    public function __construct(private string $file)
    {
        if (!is_file($this->file)) {
            file_put_contents($this->file, json_encode([], JSON_PRETTY_PRINT));
        }
    }

    public function all(): array
    {
        $data = json_decode((string)file_get_contents($this->file), true);
        return is_array($data) ? $data : [];
    }

    public function add(string $title, string $text): void
    {
        $notes = $this->all();
        $notes[] = [
            'id' => bin2hex(random_bytes(4)),
            'title' => $title,
            'text' => $text,
            'created_at' => date('c'),
        ];
        $this->save($notes);
    }

    public function delete(string $id): void
    {
        $this->save(array_values(array_filter($this->all(), fn(array $note) => $note['id'] !== $id)));
    }

    private function save(array $notes): void
    {
        file_put_contents($this->file, json_encode($notes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
