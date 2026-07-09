<?php declare(strict_types=1);
$file = __DIR__ . '/../storage/items.json';
if (!is_file($file)) file_put_contents($file, '[]');
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if ($path === '/api/items') {
    header('Content-Type: application/json; charset=utf-8');
    $items = json_decode((string)file_get_contents($file), true) ?: [];
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        echo json_encode($items, JSON_UNESCAPED_UNICODE); exit;
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = json_decode((string)file_get_contents('php://input'), true) ?: [];
        $title = trim((string)($input['title'] ?? ''));
        if ($title === '') { http_response_code(422); echo json_encode(['error' => 'title required']); exit; }
        $items[] = ['id' => uniqid('item_', true), 'title' => $title];
        file_put_contents($file, json_encode($items, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        http_response_code(201); echo json_encode(['ok' => true]); exit;
    }
}
?>
<!doctype html><html lang="de"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>PHP 06 · Mini API</title><link rel="stylesheet" href="style.css"></head><body><main><h1>Mini API mit PHP</h1><form id="form"><input id="title" placeholder="Eintrag" required><button>Senden</button></form><ul id="list"></ul></main><script src="app.js"></script></body></html>
