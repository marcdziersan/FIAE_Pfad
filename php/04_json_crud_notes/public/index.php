<?php declare(strict_types=1);
require __DIR__ . '/../src/NoteStore.php';
$store = new NoteStore(__DIR__ . '/../storage/notes.json');
function e(string $v): string { return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'add') {
        $title = trim((string)($_POST['title'] ?? ''));
        $text = trim((string)($_POST['text'] ?? ''));
        if ($title !== '' && $text !== '') $store->add($title, $text);
    }
    if ($action === 'delete') $store->delete((string)($_POST['id'] ?? ''));
    header('Location: ./'); exit;
}
$notes = $store->all();
?>
<!doctype html><html lang="de"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>PHP 04 · JSON CRUD</title><link rel="stylesheet" href="style.css"></head><body>
<main class="wrap"><h1>PHP JSON Notizen</h1><form method="post" class="card"><input type="hidden" name="action" value="add"><label>Titel<input name="title" required></label><label>Text<textarea name="text" required></textarea></label><button>Speichern</button></form>
<section class="grid"><?php foreach($notes as $note): ?><article class="card"><h2><?= e($note['title']) ?></h2><p><?= nl2br(e($note['text'])) ?></p><small><?= e($note['created_at']) ?></small><form method="post"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= e($note['id']) ?>"><button class="danger">Löschen</button></form></article><?php endforeach; ?></section></main>
</body></html>
