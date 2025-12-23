<?php
/**
 * Office Manager - Dashboard Gate (TEST VERSION)
 * Shows what would happen instead of redirecting
 */

// Enable errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/backend/lib/auth_guard.php';

// Start session
om_start_session();

echo "<h2>Dashboard Gate - Test Mode</h2>";

// Check if logged in
if (empty($_SESSION['user_id'])) {
  echo "<p>❌ Not logged in (no user_id in session)</p>";
  echo "<p>Would redirect to: /office-manager/login.php</p>";
  echo "<hr>";
  echo "<p><strong>Next step:</strong> We need to create login.php</p>";
  exit;
}

// Check if email verified
if (empty($_SESSION['is_email_verified']) || $_SESSION['is_email_verified'] != 1) {
  echo "<p>❌ Email not verified</p>";
  echo "<p>Would redirect to: /office-manager/verify-required.php</p>";
  exit;
}

// If we get here, user is logged in and verified
echo "<p>✅ User is logged in and verified!</p>";
echo "<p>✅ Loading dashboard...</p>";

// Read the dashboard HTML
$htmlPath = __DIR__ . '/app/index.html';

if (!file_exists($htmlPath)) {
  http_response_code(500);
  exit('Dashboard HTML not found');
}

$html = file_get_contents($htmlPath);

// Fix CSS/asset paths
$html = str_replace(
  '<head>',
  '<head>' . "\n" . '  <base href="/office-manager/app/">',
  $html
);

// Output
header('Content-Type: text/html; charset=UTF-8');
echo $html;
