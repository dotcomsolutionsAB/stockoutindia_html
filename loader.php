<?php
$map = [
    'auth' => 'configs/auth.js',
    'locked' => 'configs/locked_inc.js'
];

// Only allow keys defined in the map
if (isset($_GET['f']) && array_key_exists($_GET['f'], $map)) {
    $file = $map[$_GET['f']];

    if (file_exists($file)) {
        header("Content-Type: application/javascript");
        readfile($file);
        exit;
    } else {
        http_response_code(404);
        echo "// File not found";
        exit;
    }
}

// If not allowed or invalid
http_response_code(403);
echo "// Forbidden";
