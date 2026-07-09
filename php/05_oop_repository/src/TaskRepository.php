<?php declare(strict_types=1);

final class TaskRepository
{
    public function __construct(private string $file)
    {
        if (!is_file($file)) file_put_contents($file, '[]');
    }

    public function all(): array
    {
        $data = json_decode((string)file_get_contents($this->file), true);
        return is_array($data) ? $data : [];
    }

    public function create(string $title, string $priority): void
    {
        $tasks = $this->all();
        $tasks[] = ['id' => uniqid('task_', true), 'title' => $title, 'priority' => $priority, 'done' => false];
        $this->write($tasks);
    }

    public function toggle(string $id): void
    {
        $tasks = array_map(function(array $task) use ($id): array {
            if ($task['id'] === $id) $task['done'] = !$task['done'];
            return $task;
        }, $this->all());
        $this->write($tasks);
    }

    private function write(array $tasks): void
    {
        file_put_contents($this->file, json_encode($tasks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
