<?php declare(strict_types=1); ?>
<!doctype html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PHP 01 · Hello World</title>
  <style>body{font-family:system-ui;margin:2rem;line-height:1.6}.card{max-width:720px;border:1px solid #ddd;border-radius:14px;padding:1.25rem}</style>
</head>
<body>
  <main class="card">
    <h1>Hallo Welt aus PHP</h1>
    <?php
      $name = 'Marcus';
      $topic = 'FIAE-Grundlagen';
      $today = date('d.m.Y H:i');
    ?>
    <p>Hallo <?= htmlspecialchars($name) ?>, dies ist der Startpunkt für <?= htmlspecialchars($topic) ?>.</p>
    <p>Serverzeit: <strong><?= htmlspecialchars($today) ?></strong></p>
  </main>
</body>
</html>
