<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/NoteRepository.php';
require_once __DIR__ . '/../src/helpers.php';

$repository = new NoteRepository(__DIR__ . '/../storage/notes.json');
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $title = trim((string)($_POST['title'] ?? ''));
        $content = trim((string)($_POST['content'] ?? ''));

        if (mb_strlen($title) < 3 || mb_strlen($content) < 3) {
            $error = 'Titel und Inhalt müssen mindestens 3 Zeichen haben.';
        } else {
            $repository->add($title, $content);
            redirect_home();
        }
    }

    if ($action === 'toggle') {
        $repository->toggle((string)($_POST['id'] ?? ''));
        redirect_home();
    }

    if ($action === 'delete') {
        $repository->delete((string)($_POST['id'] ?? ''));
        redirect_home();
    }
}

$notes = $repository->all();
?>
<!doctype html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>03 PHP JSON Notiz-App</title>
  <link rel="stylesheet" href="/assets/style.css">
</head>
<body>
  <main class="layout">
    <header class="hero">
      <p class="kicker">FIAE Grundlagen · PHP JSON CRUD</p>
      <h1>Notiz-App mit PHP</h1>
      <p>Dieses Beispiel zeigt CRUD mit HTML-Formularen, serverseitiger Validierung und JSON-Datei.</p>
    </header>

    <section class="panel">
      <h2>Neue Notiz</h2>
      <?php if ($error): ?>
        <p class="error"><?= e($error) ?></p>
      <?php endif; ?>
      <form method="post" class="form" id="noteForm">
        <input type="hidden" name="action" value="add">
        <label for="title">Titel</label>
        <input id="title" name="title" maxlength="80" required>
        <label for="content">Inhalt</label>
        <textarea id="content" name="content" rows="4" maxlength="400" required></textarea>
        <button type="submit">Speichern</button>
      </form>
    </section>

    <section class="panel">
      <h2>Notizen</h2>
      <?php if (count($notes) === 0): ?>
        <p class="muted">Noch keine Notizen vorhanden.</p>
      <?php endif; ?>

      <div class="notes">
        <?php foreach ($notes as $note): ?>
          <article class="note <?= ($note['done'] ?? false) ? 'is-done' : '' ?>">
            <div>
              <h3><?= e((string)$note['title']) ?></h3>
              <p><?= e((string)$note['content']) ?></p>
              <small><?= e(date('d.m.Y H:i', strtotime((string)$note['created_at']))) ?></small>
            </div>
            <div class="actions">
              <form method="post">
                <input type="hidden" name="action" value="toggle">
                <input type="hidden" name="id" value="<?= e((string)$note['id']) ?>">
                <button type="submit" class="secondary"><?= ($note['done'] ?? false) ? 'Offen' : 'Erledigt' ?></button>
              </form>
              <form method="post" class="delete-form">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= e((string)$note['id']) ?>">
                <button type="submit" class="danger">Löschen</button>
              </form>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </section>
  </main>
  <script src="/assets/app.js"></script>
</body>
</html>
