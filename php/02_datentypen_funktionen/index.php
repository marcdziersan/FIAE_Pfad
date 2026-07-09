<?php declare(strict_types=1);

function brutto(float $netto, float $mwst = 0.19): float
{
    return round($netto * (1 + $mwst), 2);
}

$skills = ['Variablen', 'Arrays', 'Funktionen', 'Schleifen', 'Escape-Ausgabe'];
$positionen = [
    ['name' => 'Analyse', 'netto' => 120.00],
    ['name' => 'Umsetzung', 'netto' => 350.00],
    ['name' => 'Dokumentation', 'netto' => 80.00],
];
$summeNetto = array_sum(array_column($positionen, 'netto'));
?>
<!doctype html>
<html lang="de">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>PHP 02 · Datentypen</title><style>body{font-family:system-ui;margin:2rem}table{border-collapse:collapse}td,th{border:1px solid #ccc;padding:.5rem}.box{max-width:760px}</style></head>
<body>
<main class="box">
  <h1>PHP: Datentypen, Arrays, Funktionen</h1>
  <h2>Behandelte Themen</h2>
  <ul><?php foreach ($skills as $skill): ?><li><?= htmlspecialchars($skill) ?></li><?php endforeach; ?></ul>
  <h2>Mini-Rechnung</h2>
  <table>
    <thead><tr><th>Position</th><th>Netto</th><th>Brutto</th></tr></thead>
    <tbody>
      <?php foreach ($positionen as $pos): ?>
      <tr><td><?= htmlspecialchars($pos['name']) ?></td><td><?= number_format($pos['netto'], 2, ',', '.') ?> €</td><td><?= number_format(brutto($pos['netto']), 2, ',', '.') ?> €</td></tr>
      <?php endforeach; ?>
    </tbody>
    <tfoot><tr><th>Summe</th><th><?= number_format($summeNetto, 2, ',', '.') ?> €</th><th><?= number_format(brutto($summeNetto), 2, ',', '.') ?> €</th></tr></tfoot>
  </table>
</main>
</body>
</html>
