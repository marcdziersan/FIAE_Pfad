<?php declare(strict_types=1);
header('Content-Type: application/json; charset=utf-8');

$base = __DIR__ . '/../storage';
if (!is_dir($base)) mkdir($base, 0777, true);

function readJson(string $file): array {
    if (!is_file($file)) file_put_contents($file, '[]');
    $data = json_decode((string)file_get_contents($file), true);
    return is_array($data) ? $data : [];
}
function writeJson(string $file, array $data): void {
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}
function input(): array {
    return json_decode((string)file_get_contents('php://input'), true) ?: [];
}
function fail(string $message, int $status = 422): never {
    http_response_code($status);
    echo json_encode(['error' => $message], JSON_UNESCAPED_UNICODE);
    exit;
}
function requiredString(array $data, string $key): string {
    $value = trim((string)($data[$key] ?? ''));
    if ($value === '') fail("Feld '$key' fehlt.");
    return $value;
}
function gross(float $net): float { return round($net * 1.19, 2); }

$files = [
    'contacts' => $base . '/contacts.json',
    'notes' => $base . '/notes.json',
    'orders' => $base . '/orders.json',
];
$action = $_GET['action'] ?? 'all';

if ($action === 'all') {
    echo json_encode([
        'contacts' => readJson($files['contacts']),
        'notes' => readJson($files['notes']),
        'orders' => readJson($files['orders']),
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') fail('POST erforderlich.', 405);
$data = input();

if ($action === 'addContact') {
    $contacts = readJson($files['contacts']);
    $email = requiredString($data, 'email');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) fail('Ungültige E-Mail.');
    $contacts[] = ['id' => uniqid('c_', true), 'name' => requiredString($data, 'name'), 'email' => $email, 'phone' => requiredString($data, 'phone')];
    writeJson($files['contacts'], $contacts);
    http_response_code(201); echo json_encode(['ok' => true]); exit;
}

if ($action === 'addNote') {
    $notes = readJson($files['notes']);
    $notes[] = ['id' => uniqid('n_', true), 'title' => requiredString($data, 'title'), 'text' => requiredString($data, 'text')];
    writeJson($files['notes'], $notes);
    http_response_code(201); echo json_encode(['ok' => true]); exit;
}

if ($action === 'addOrder') {
    $orders = readJson($files['orders']);
    $net = (float)($data['net'] ?? -1);
    if ($net < 0) fail('Netto muss positiv sein.');
    $orders[] = ['id' => uniqid('o_', true), 'customer' => requiredString($data, 'customer'), 'title' => requiredString($data, 'title'), 'net' => $net, 'gross' => gross($net), 'status' => 'offen'];
    writeJson($files['orders'], $orders);
    http_response_code(201); echo json_encode(['ok' => true]); exit;
}

fail('Unbekannte Aktion.', 404);
