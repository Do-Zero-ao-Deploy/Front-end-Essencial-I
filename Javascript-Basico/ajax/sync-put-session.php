<?php
if (!isset($_SESSION)) {
    session_start();
}

function phpInput(bool $decode = true, bool $associative = true): mixed
{
    $content = file_get_contents('php://input');

    if (!$decode) {
        return $content;
    }

    return $content ? json_decode($content, $associative) : null;
}

function request(null|int|string $key = null, mixed $defaultValue = null): mixed
{
    $_REQUEST = array_merge(
        (array) (phpInput(true, true) ?? []),
        $_REQUEST,
        $_POST,
        $_GET,
    );

    if ($key === null) {
        return $_REQUEST ?? [];
    }

    return $_REQUEST[$key] ?? $defaultValue;
}

function putOnSession(int|string $key, mixed $value): void
{
    $_SESSION[$key] = $value;
}

function clearAllDataOnSession(int|string $key): void
{
    unset($_SESSION[$key]);
}

function sessionGet(null|int|string $key = null, mixed $defaultValue = null): mixed
{
    if ($key === null) {
        return $_SESSION ?? [];
    }

    return $_SESSION[$key] ?? $defaultValue;
}

function pushOnSession(int|string $key, mixed $value): void
{
    $items = (array) ($_SESSION[$key] ?? []);
    $value = is_array($value) ? $value : ['value' => $value];

    $uid = uniqid();
    $value = array_merge(
        $value,
        [
            '_uid' => $uid,
            '_creted_at' => date('c'),
        ],
    );

    if (count($value) === 2) {
        return;
    }

    $items[$uid] = $value;
    putOnSession($key, $items);
}

function removeOnSession(int|string $key, null|string $index = null): void
{
    if ($index === null) {
        unset($_SESSION[$key]);
        return;
    }

    unset($_SESSION[$key][$index]);
}

function removeItem(null|int|string $key, null|string $uid = null): void
{
    if (is_null($key) || is_null($uid)) {
        return;
    }

    removeOnSession($key, $uid);
}

function responseJson(mixed $data, int $statusCode = 200, array $headers = []): void
{
    http_response_code($statusCode);
    header('content-type: application/json');
    die(json_encode($data ?? [], 64));
}

function redirect(?string $redirectTo, int $statusCode = 403): void
{
    if (!$redirectTo) {
        return;
    }

    // http_response_code($statusCode);

    header("Location: {$redirectTo}");
    die();
}

$key = request('_key');
$type = request('_type', 'push');
$uid = request('_uid');
$redirectTo = request('redirect_to');
$data = array_filter(request(), fn($key) => !in_array($key, [
    '_key',
    '_type',
    'redirect_to',
]), ARRAY_FILTER_USE_KEY);

if ($key && (is_numeric($key) || is_string($key))) {
    match($type) {
        'push' => pushOnSession($key, $data),
        'clear' => clearAllDataOnSession($key),
        'put' => putOnSession($key, $data),
        'removeItem' => removeItem($key, $uid),
        default => [],
    };
}

if ($redirectTo) {
    redirect($redirectTo);
}

responseJson(sessionGet($key));
