<?php
$allowed = ['auth'];
$map = [
    'auth' => 'configs/auth.js',
    'locked' => 'configs/locked_inc.js'
    // add more as needed
];

if (isset($_GET['f']) && in_array($_GET['f'], $allowed)) {
    $file = $map[$_GET['f']];
    header("Content-Type: application/javascript");
    readfile($file);
    exit;
}

http_response_code(403);
echo "// Forbidden";
