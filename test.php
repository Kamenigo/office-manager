<?php
// Enable error display
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Dashboard Test</h2>";

echo "<h3>Step 1: Check files exist</h3>";
$files = [
  'backend/lib/auth_guard.php',
  'backend/lib/db.php',
  'backend/config.php',
  'app/index.html',
];

foreach ($files as $file) {
  $fullPath = __DIR__ . '/' . $file;
  $exists = file_exists($fullPath);
  echo "<p>";
  echo $exists ? "✅" : "❌";
  echo " <strong>$file</strong>";
  echo "</p>";
}

echo "<hr><h3>Step 2: Try to load auth_guard.php</h3>";
try {
  require_once __DIR__ . '/backend/lib/auth_guard.php';
  echo "✅ auth_guard.php loaded successfully<br>";
} catch (Exception $e) {
  echo "❌ Error loading auth_guard.php: " . $e->getMessage() . "<br>";
}

echo "<hr><h3>Step 3: Try to load db.php</h3>";
try {
  require_once __DIR__ . '/backend/lib/db.php';
  echo "✅ db.php loaded successfully<br>";
} catch (Exception $e) {
  echo "❌ Error loading db.php: " . $e->getMessage() . "<br>";
}

echo "<hr><h3>Step 4: Try to read config</h3>";
try {
  $config = om_config();
  echo "✅ Config loaded successfully<br>";
  echo "<pre>";
  echo "Database: " . ($config['db']['name'] ?? 'NOT SET') . "\n";
  echo "Host: " . ($config['db']['host'] ?? 'NOT SET') . "\n";
  echo "User: " . ($config['db']['user'] ?? 'NOT SET') . "\n";
  echo "</pre>";
} catch (Exception $e) {
  echo "❌ Error loading config: " . $e->getMessage() . "<br>";
}

echo "<hr><h3>Step 5: Try to connect to database</h3>";
try {
  $pdo = om_pdo();
  echo "✅ Database connection successful!<br>";
} catch (Exception $e) {
  echo "❌ Database connection failed: <strong style='color:red;'>" . $e->getMessage() . "</strong><br>";
}

echo "<hr><p>Test complete.</p>";
