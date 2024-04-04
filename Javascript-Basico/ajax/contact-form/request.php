<?php

if (!isset($_SESSION)) {
    session_start();
}

$requestInput = function(?string $key = null, mixed $default = null) {
    $request = array_merge(
        $_REQUEST,
        $_POST,
        $_GET,
    );

    if ($key === null) {
        return $request;
    }

    return $request[$key] ?? $default;
};

$putData = function(mixed $data, string $dbName): bool|int {
    $dbName = trim($dbName) ? trim($dbName) : null;

    if (!$dbName) {
        return false;
    }

    $dbName = str_replace(['/', '\\', '.', 'json',], '-', $dbName);
    $filePath = __DIR__ . "/{$dbName}.json";

    if (!is_file($filePath)) {
        file_put_contents($filePath, '[]');
    }

    $currentData = json_decode(file_get_contents($filePath), true);
    $currentData['content'] = $currentData['content'] ?? [];

    if (!is_array($currentData['content'])) {
        $currentData['content'] = [];
    }

    $currentData['dbid'] ??= date('YmdHis').uniqid();

    $uid = date('Hi').uniqid();

    $data = is_array($data) ? array_merge([
        'created_at' => date('c'),
        'uid' => $uid,
    ], $data) : [
        'uid' => $uid,
        'created_at' => date('c'),
        'value' => $data
    ];

    $currentData['content'][$uid] = $data;
    $currentData['last_update'] = date('c');

    return file_put_contents($filePath, json_encode($currentData, 64|128|256));
};

$name = filter_var($requestInput('name'));
$email = filter_var($requestInput('email'), FILTER_VALIDATE_EMAIL);
$subject = filter_var($requestInput('subject'));
$message = filter_var($requestInput('message'));

$data = [
    'name' => $name,
    'email' => $email,
    'subject' => $subject,
    'message' => $message,
];

$errors = array_filter($data, fn($item) => !$item);

foreach(array_keys($errors) as $key) {
    $_SESSION['error'] = sprintf('Erro no campo "%s"', $key);
    header('Location: ./index.php');
    die();
}

$success = $putData($data, 'contacts');

$key = $success ? 'success' : 'error';
$message = $success ? 'Registrado com sucesso!' : 'Falha ao registrar';

$_SESSION[$key] = $message;

// usleep(1000000 / 2);

header('Location: ./index.php');
