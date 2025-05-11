<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['password'])) {
    $password = $data['password'];
    $success = isset($data['success']) ? $data['success'] : false;

    $logFile = '/home/canabozs/attempt_logs/attempts.log';

    if (!file_exists(dirname($logFile))) {
        mkdir(dirname($logFile), 0700, true);
    }

    $logLine = date('c') . " - Tried password: {$password} - " . ($success ? '✅ SUCCESS' : '❌ FAILURE') . PHP_EOL;

    file_put_contents($logFile, $logLine, FILE_APPEND | LOCK_EX);

    echo "Logged";
} else {
    http_response_code(400);
    echo "No password provided";
}
?>
