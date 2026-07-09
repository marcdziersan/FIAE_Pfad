<?php

declare(strict_types=1);

final class NoteRepository
{
    public function __construct(private readonly string $filePath)
    {
        $directory = dirname($this->filePath);
        if (!is_dir($directory)) {
            mkdir($directory, 0775, true);
        }
        if (!file_exists($this->filePath)) {
            file_put_contents($this->filePath, json_encode([], JSON_PRETTY_PRINT));
        }
    }

    public function all(): array
    {
        $content = file_get_contents($this->filePath);
        $notes = json_decode($content ?: '[]', true);
        if (!is_array($notes)) {
            return [];
        }
        usort($notes, fn(array $a, array $b): int => strcmp($b['created_at'], $a['created_at']));
        return $notes;
    }

    public function add(string $title, string $content): void
    {
        $notes = $this->all();
        $notes[] = [
            'id' => bin2hex(random_bytes(8)),
            'title' => $title,
            'content' => $content,
            'done' => false,
            'created_at' => date('c'),
        ];
        $this->save($notes);
    }

    public function toggle(string $id): void
    {
        $notes = array_map(function (array $note) use ($id): array {
            if ($note['id'] === $id) {
                $note['done'] = !($note['done'] ?? false);
            }
            return $note;
        }, $this->all());
        $this->save($notes);
    }

    public function delete(string $id): void
    {
        $notes = array_values(array_filter($this->all(), fn(array $note): bool => $note['id'] !== $id));
        $this->save($notes);
    }

    private function save(array $notes): void
    {
        file_put_contents(
            $this->filePath,
            json_encode($notes, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            LOCK_EX
        );
    }
}
