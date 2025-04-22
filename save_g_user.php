<?php
header('Content-Type: application/json');

// Get raw input
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

// Check for empty input
if (!$raw || !$data) {
    echo json_encode(['success' => false, 'message' => 'Empty raw input']);
    exit;
}

// Make sure the target folder exists
$path = __DIR__ . '/json/g-sign-in.json';
$dir = dirname($path);
if (!is_dir($dir)) {
    mkdir($dir, 0755, true);
}

// Save the data
if (file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT))) {
    echo json_encode(['success' => true, 'message' => 'Data saved to g-sign-in.json']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to save file']);
}
