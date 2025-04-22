<?php
header('Content-Type: application/json');

$raw = file_get_contents('php://input');  // Get raw JSON input
$data = json_decode($raw, true);          // Decode to array

if (!$raw) {
    echo json_encode(['success' => false, 'message' => 'Empty raw input']);
    exit;
}

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON', 'raw' => $raw]);
    exit;
}

if ($data) {
    $path = __DIR__ . '/json/g-sign-in.json';

    // Make sure the directory exists
    if (!is_dir(dirname($path))) {
        mkdir(dirname($path), 0755, true);
    }

    // Save the JSON file
    if (file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT))) {
        echo json_encode(['success' => true, 'message' => 'Data saved']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save file']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No data received']);
}
