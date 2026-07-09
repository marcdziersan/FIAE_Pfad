<?php declare(strict_types=1);
require __DIR__ . '/../src/TaskRepository.php';
$repo = new TaskRepository(__DIR__ . '/../storage/tasks.json');
function e(string $v): string { return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'create') $repo->create(trim((string)$_POST['title']), (string)$_POST['priority']);
    if ($action === 'toggle') $repo->toggle((string)$_POST['id']);
    header('Location: ./'); exit;
}
?>
<!doctype html><html lang="de"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>PHP 05 · OOP Repository</title><link rel="stylesheet" href="style.css"></head><body><main><h1>Aufgaben mit Repository-Klasse</h1><form method="post"><input type="hidden" name="action" value="create"><input name="title" placeholder="Aufgabe" required><select name="priority"><option>niedrig</option><option>mittel</option><option>hoch</option></select><button>Anlegen</button></form><ul><?php foreach($repo->all() as $task): ?><li class="<?= $task['done'] ? 'done' : '' ?>"><form method="post"><input type="hidden" name="action" value="toggle"><input type="hidden" name="id" value="<?= e($task['id']) ?>"><button><?= $task['done'] ? '✓' : '○' ?></button></form><span><?= e($task['title']) ?> · <?= e($task['priority']) ?></span></li><?php endforeach; ?></ul></main></body></html>
