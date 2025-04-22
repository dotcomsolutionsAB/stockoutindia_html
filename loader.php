<?php
// Secure file map (use random or hashed keys for production)
$map = [
    'auth-js' => 'configs/auth_check.js',
    'locked-js' => 'configs/locked_inc.js',
    'admin-css' => 'configs/admin.css',
    'static-data' => 'configs/static_data.php'  // Only include-safe
];

$key = $_GET['f'] ?? '';
$ext = pathinfo($map[$key] ?? '', PATHINFO_EXTENSION);

if (array_key_exists($key, $map)) {
    $file = $map[$key];
    $realPath = realpath($file);
    $allowedDir = realpath(__DIR__ . '/configs');

    // Only allow files inside /configs/ directory
    if ($realPath && strpos($realPath, $allowedDir) === 0 && file_exists($realPath)) {
        // Serve with proper content-type
        switch ($ext) {
            case 'js':
                header("Content-Type: application/javascript");
                break;
            // case 'css':
            //     header("Content-Type: text/css");
            //     break;
            // case 'php':
            //     header("Content-Type: application/json");
            //     include($realPath); // Use include instead of readfile
            //     exit;
            default:
                http_response_code(403);
                echo "// Invalid file type";
                exit;
        }

        readfile($realPath);
        exit;
    }
}

// If invalid key or not allowed
http_response_code(403);
echo "// Forbidden";
