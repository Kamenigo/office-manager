<?php
/**
 * Office Manager - Dashboard Gate
 * Serves app/index.html ONLY after session + email verification checks.
 */

require_once __DIR__ . '/backend/lib/auth_guard.php';

// SECURITY: Check session + email verified
om_require_login();

// Read the dashboard HTML
$htmlPath = __DIR__ . '/app/index.html';

if (!file_exists($htmlPath)) {
  http_response_code(500);
  exit('Dashboard HTML not found');
}

$html = file_get_contents($htmlPath);

// Fix CSS/asset paths: inject <base> tag to make relative paths work from /office-manager/
// This ensures css/main.css becomes /office-manager/app/css/main.css
$html = str_replace(
  '<head>',
  '<head>' . "\n" . '  <base href="/office-manager/app/">',
  $html
);

// Output
header('Content-Type: text/html; charset=UTF-8');
echo $html;

