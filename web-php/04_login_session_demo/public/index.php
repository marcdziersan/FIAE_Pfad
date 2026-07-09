<?php

declare(strict_types=1);
session_start();

const USERNAME = 'marcus';
const PASSWORD = 'fiae';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim((string)($_POST['username'] ?? ''));
    $password = trim((string)($_POST['password'] ?? ''));

    if ($username === USERNAME && $password === PASSWORD) {
        $_SESSION['user'] = $username;
        header('Location: /notes.php');
        exit;
    }

    $error = 'Login nicht erfolgreich.';
}
?>
<!doctype html>
<html lang="de">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>04 Login Session Demo</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <main class="card">
    <p class="kicker">FIAE Grundlagen · PHP Session</p>
    <h1>Login-Demo</h1>
    <p>Demo-Zugang: marcus / fiae</p>
    <?php if ($error): ?><p class="error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p><?php endif; ?>
    <form method="post">
      <label for="username">Benutzer</label>
      <input id="username" name="username" required>
      <label for="password">Passwort</label>
      <input id="password" name="password" type="password" required>
      <button type="submit">Einloggen</button>
    </form>
  </main>
</body>
</html>
