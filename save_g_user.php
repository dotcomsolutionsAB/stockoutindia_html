<?php
header('Content-Type: application/json');

$raw = file_get_contents("php://input");

if (!$raw) {
    echo json_encode(['success' => false, 'message' => 'Empty input']);
    exit;
}

$data = json_decode($raw, true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON']);
    exit;
}

$path = __DIR__ . "/json/g-sign-in.json";

if (!is_dir(dirname($path))) {
    mkdir(dirname($path), 0755, true);
}

if (file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT))) {
    echo json_encode(['success' => true, 'message' => 'Data saved successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to write file']);
}
