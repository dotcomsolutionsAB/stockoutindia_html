<?php
// Hidden mapping: encrypted/random key => actual file
$map = [
    '1a2b3c4d' => 'configs/auth.js',
    '9f8e7d6c' => 'configs/locked_inc.js'
];

// Check if key is valid
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

// Forbidden if no valid access
http_response_code(403);
echo "// Forbidden";
