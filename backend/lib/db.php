<?php
// backend/lib/db.php
// Single DB connector (PDO). Reads backend/config.php on server.

function om_config(): array {
  $base = dirname(__DIR__); // /backend
  $real = $base . '/config.php';
  $example = $base . '/config.example.php';

  if (file_exists($real)) {
    return require $real;
  }

  // In GitHub you only have config.example.php. This fallback helps local dev,
  // but on production you MUST create backend/config.php with real credentials.
  return require $example;
}

function om_pdo(): PDO {
  static $pdo = null;
  if ($pdo instanceof PDO) return $pdo;

  $cfg = om_config();
  $db = $cfg['db'];

  $dsn = sprintf(
    'mysql:host=%s;dbname=%s;charset=%s',
    $db['host'],
    $db['name'],
    $db['charset'] ?? 'utf8mb4'
  );

  $options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
  ];

  $pdo = new PDO($dsn, $db['user'], $db['pass'], $options);
  return $pdo;
}
