<?php declare(strict_types=1);
$errors = [];
$result = null;
$name = trim((string)($_POST['name'] ?? ''));
$email = trim((string)($_POST['email'] ?? ''));
$message = trim((string)($_POST['message'] ?? ''));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($name === '') $errors[] = 'Name fehlt.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'E-Mail ist ungültig.';
    if (mb_strlen($message) < 10) $errors[] = 'Nachricht muss mindestens 10 Zeichen haben.';
    if (!$errors) {
        $result = ['name' => $name, 'email' => $email, 'message' => $message, 'time' => date('c')];
    }
}
function e(string $value): string { return htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); }
?>
<!doctype html>
<html lang="de">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>PHP 03 · Formular</title><link rel="stylesheet" href="style.css"></head>
<body>
<main class="wrap">
  <h1>Formular mit Validierung</h1>
  <?php if ($errors): ?><div class="error"><strong>Bitte prüfen:</strong><ul><?php foreach($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
  <?php if ($result): ?><div class="success"><strong>Valide Eingabe:</strong><pre><?= e(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) ?></pre></div><?php endif; ?>
  <form method="post" novalidate>
    <label>Name <input name="name" value="<?= e($name) ?>" required></label>
    <label>E-Mail <input name="email" type="email" value="<?= e($email) ?>" required></label>
    <label>Nachricht <textarea name="message" required><?= e($message) ?></textarea></label>
    <button>Prüfen</button>
  </form>
</main>
</body>
</html>
