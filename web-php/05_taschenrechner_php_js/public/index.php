<?php
$result = null;
$error = null;
$a = $_POST['a'] ?? '';
$b = $_POST['b'] ?? '';
$op = $_POST['op'] ?? '+';

function calculate(float $a, float $b, string $op): float
{
    return match ($op) {
        '+' => $a + $b,
        '-' => $a - $b,
        '*' => $a * $b,
        '/' => $b == 0.0 ? throw new InvalidArgumentException('Division durch 0 ist nicht erlaubt.') : $a / $b,
        default => throw new InvalidArgumentException('Unbekannter Operator.'),
    };
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!is_numeric($a) || !is_numeric($b)) {
        $error = 'Bitte zwei gültige Zahlen eingeben.';
    } else {
        try {
            $result = calculate((float)$a, (float)$b, $op);
        } catch (Throwable $e) {
            $error = $e->getMessage();
        }
    }
}
?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Taschenrechner · Web/PHP</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<main class="card">
    <p class="kicker">05 · Web/PHP</p>
    <h1>Taschenrechner</h1>
    <p>Clientseitige Vorschau mit JavaScript, endgültige Berechnung mit PHP.</p>

    <form method="post" id="calcForm">
        <label>Zahl A
            <input name="a" id="a" type="number" step="any" value="<?= htmlspecialchars((string)$a) ?>" required>
        </label>
        <label>Operator
            <select name="op" id="op">
                <?php foreach (['+' => 'Plus', '-' => 'Minus', '*' => 'Mal', '/' => 'Geteilt'] as $symbol => $label): ?>
                    <option value="<?= $symbol ?>" <?= $op === $symbol ? 'selected' : '' ?>><?= $symbol ?> <?= $label ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Zahl B
            <input name="b" id="b" type="number" step="any" value="<?= htmlspecialchars((string)$b) ?>" required>
        </label>
        <button type="submit">Berechnen</button>
    </form>

    <section class="result" aria-live="polite">
        <strong>JavaScript-Vorschau:</strong>
        <span id="preview">Noch keine Eingabe.</span>
    </section>

    <?php if ($error): ?>
        <section class="message error"><?= htmlspecialchars($error) ?></section>
    <?php elseif ($result !== null): ?>
        <section class="message success">PHP-Ergebnis: <strong><?= number_format($result, 2, ',', '.') ?></strong></section>
    <?php endif; ?>
</main>
<script src="assets/app.js"></script>
</body>
</html>
