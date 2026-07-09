<?php
require_once __DIR__ . '/../src/ContactRepository.php';
$repo = new ContactRepository(__DIR__ . '/../storage/contacts.json');
$error = null;
$search = $_GET['q'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'create') {
        $name = trim($_POST['name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $email = trim($_POST['email'] ?? '');
        if ($name === '' || $phone === '') {
            $error = 'Name und Telefonnummer sind Pflichtfelder.';
        } elseif ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Die E-Mail-Adresse ist ungültig.';
        } else {
            $repo->create($name, $phone, $email);
            header('Location: index.php');
            exit;
        }
    }
    if ($action === 'delete') {
        $repo->delete((string)($_POST['id'] ?? ''));
        header('Location: index.php');
        exit;
    }
}

$contacts = $repo->search($search);
function e(string $value): string { return htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); }
?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Telefonbuch · PHP JSON</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<main class="app">
    <header>
        <p class="kicker">06 · Web/PHP</p>
        <h1>Telefonbuch</h1>
        <p>Kontakte anlegen, suchen und löschen. Speicherung erfolgt in einer JSON-Datei.</p>
    </header>

    <?php if ($error): ?><div class="error"><?= e($error) ?></div><?php endif; ?>

    <section class="panel">
        <h2>Kontakt hinzufügen</h2>
        <form method="post" class="grid">
            <input type="hidden" name="action" value="create">
            <label>Name<input name="name" required></label>
            <label>Telefon<input name="phone" required></label>
            <label>E-Mail<input name="email" type="email"></label>
            <button>Speichern</button>
        </form>
    </section>

    <section class="panel">
        <form method="get" class="search">
            <label>Suche<input name="q" value="<?= e($search) ?>" placeholder="Name, Telefon oder E-Mail"></label>
            <button>Suchen</button>
            <a href="index.php">Zurücksetzen</a>
        </form>
    </section>

    <section class="panel">
        <h2>Kontakte (<?= count($contacts) ?>)</h2>
        <div class="table">
            <div class="row head"><span>Name</span><span>Telefon</span><span>E-Mail</span><span>Aktion</span></div>
            <?php foreach ($contacts as $contact): ?>
                <div class="row">
                    <span><?= e($contact['name']) ?></span>
                    <span><?= e($contact['phone']) ?></span>
                    <span><?= e($contact['email']) ?></span>
                    <form method="post">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= e((string)$contact['id']) ?>">
                        <button class="danger">Löschen</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>
</body>
</html>
