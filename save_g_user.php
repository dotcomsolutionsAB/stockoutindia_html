<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

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
