<?php
header('Content-Type: application/json');

$raw = file_get_contents('php://input');

// Debug: log the raw input in case of empty data
if (!$raw) {
    echo json_encode([
        'success' => false,
        'message' => 'Empty raw input',
        'note' => 'Check fetch() method and Content-Type header'
    ]);
    exit;
}

$data = json_decode($raw, true);

if (!$data) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid JSON or empty object',
        'raw' => $raw
    ]);
    exit;
}
file_put_contents(__DIR__ . '/json/debug.txt', $raw);

$path ='json/g-sign-in.json';

if (!is_dir(dirname($path))) {
    mkdir(dirname($path), 0755, true);
}

if (file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT))) {
    echo json_encode(['success' => true, 'message' => 'Saved successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to write file']);
}
