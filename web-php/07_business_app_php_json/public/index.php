<?php
require_once __DIR__ . '/../src/OrderRepository.php';
$repo = new OrderRepository(__DIR__ . '/../storage/orders.json');
$error = null;
$statuses = ['offen', 'in Arbeit', 'erledigt', 'abgerechnet'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'create') {
        $customer = trim($_POST['customer'] ?? '');
        $title = trim($_POST['title'] ?? '');
        $net = str_replace(',', '.', trim($_POST['net'] ?? ''));
        $status = $_POST['status'] ?? 'offen';
        if ($customer === '' || $title === '' || !is_numeric($net) || (float)$net < 0) {
            $error = 'Bitte Kunde, Auftrag und einen gültigen Nettobetrag eingeben.';
        } else {
            $repo->create($customer, $title, (float)$net, in_array($status, $statuses, true) ? $status : 'offen');
            header('Location: index.php');
            exit;
        }
    }
    if ($action === 'status') {
        $repo->updateStatus((string)($_POST['id'] ?? ''), $_POST['status'] ?? 'offen');
        header('Location: index.php');
        exit;
    }
    if ($action === 'delete') {
        $repo->delete((string)($_POST['id'] ?? ''));
        header('Location: index.php');
        exit;
    }
}

$orders = $repo->all();
$totals = $repo->totals();
function e(string $value): string { return htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); }
function euro(float $value): string { return number_format($value, 2, ',', '.') . ' €'; }
?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mini-Auftragsverwaltung · PHP</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<main class="app">
    <header>
        <p class="kicker">07 · Web/PHP</p>
        <h1>Mini-Auftragsverwaltung</h1>
        <p>Business-Grundlage: Auftrag erfassen, Netto/MwSt/Brutto berechnen, Status ändern.</p>
    </header>

    <section class="summary">
        <div><strong><?= euro($totals['net']) ?></strong><span>Netto gesamt</span></div>
        <div><strong><?= euro($totals['vat']) ?></strong><span>MwSt. 19%</span></div>
        <div><strong><?= euro($totals['gross']) ?></strong><span>Brutto gesamt</span></div>
    </section>

    <?php if ($error): ?><div class="error"><?= e($error) ?></div><?php endif; ?>

    <section class="panel">
        <h2>Auftrag erfassen</h2>
        <form method="post" class="grid">
            <input type="hidden" name="action" value="create">
            <label>Kunde<input name="customer" required></label>
            <label>Auftrag<input name="title" required></label>
            <label>Netto<input name="net" type="number" step="0.01" min="0" required></label>
            <label>Status<select name="status"><?php foreach ($statuses as $s): ?><option><?= e($s) ?></option><?php endforeach; ?></select></label>
            <button>Speichern</button>
        </form>
    </section>

    <section class="panel">
        <h2>Aufträge</h2>
        <div class="table">
            <div class="row head"><span>Kunde</span><span>Auftrag</span><span>Netto</span><span>Brutto</span><span>Status</span><span>Aktion</span></div>
            <?php foreach ($orders as $order): ?>
                <div class="row">
                    <span><?= e($order['customer']) ?></span>
                    <span><?= e($order['title']) ?></span>
                    <span><?= euro((float)$order['net']) ?></span>
                    <span><?= euro((float)$order['gross']) ?></span>
                    <form method="post">
                        <input type="hidden" name="action" value="status">
                        <input type="hidden" name="id" value="<?= e((string)$order['id']) ?>">
                        <select name="status" onchange="this.form.submit()">
                            <?php foreach ($statuses as $s): ?><option <?= $order['status'] === $s ? 'selected' : '' ?>><?= e($s) ?></option><?php endforeach; ?>
                        </select>
                    </form>
                    <form method="post">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= e((string)$order['id']) ?>">
                        <button class="danger">Löschen</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>
</body>
</html>
