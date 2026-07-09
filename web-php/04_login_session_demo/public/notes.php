<?php

declare(strict_types=1);
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: /');
    exit;
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: /');
    exit;
}

$note = trim((string)($_POST['note'] ?? ''));
?>
<!doctype html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Geschützte Notiz</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <main class="card">
    <p class="kicker">Angemeldet als <?= htmlspecialchars((string)$_SESSION['user'], ENT_QUOTES, 'UTF-8') ?></p>
    <h1>Geschützte Notizseite</h1>
    <form method="post">
      <label for="note">Kurze Notiz</label>
      <textarea id="note" name="note" rows="4"><?= htmlspecialchars($note, ENT_QUOTES, 'UTF-8') ?></textarea>
      <button type="submit">Anzeigen</button>
    </form>
    <?php if ($note !== ''): ?>
      <section class="result">
        <h2>Ausgabe</h2>
        <p><?= nl2br(htmlspecialchars($note, ENT_QUOTES, 'UTF-8')) ?></p>
      </section>
    <?php endif; ?>
    <form method="post">
      <button type="submit" name="logout" value="1" class="secondary">Ausloggen</button>
    </form>
  </main>
</body>
</html>
