<?php
// Optional: enable error reporting for debugging (disable in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Get the JSON POST body
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['password'])) {
    $password = $data['password'];
    $success = isset($data['success']) ? $data['success'] : false;

    // Get absolute path — replace this with your actual home path
    $logFile = '/home/canabozs/attempt_logs/attempts.log';

    // Make sure directory exists
    if (!file_exists(dirname($logFile))) {
        mkdir(dirname($logFile), 0700, true);
    }

    // Build log line
    $logLine = date('c') . " - Tried password: {$password} - " . ($success ? '✅ SUCCESS' : '❌ FAILURE') . PHP_EOL;

    // Append log to file
    file_put_contents($logFile, $logLine, FILE_APPEND | LOCK_EX);

    echo "Logged";
} else {
    http_response_code(400);
    echo "No password provided";
}
?>
