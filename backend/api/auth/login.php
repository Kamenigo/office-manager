<?php
require_once __DIR__ . '/../../lib/db.php';
require_once __DIR__ . '/../../lib/auth_guard.php';

om_start_session();

// Only POST allowed
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit('Method not allowed');
}

$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

// Validation
if (empty($email) || empty($password)) {
  header('Location: /office-manager/login.php?error=required');
  exit;
}

$pdo = om_pdo();

// Find user by email
$stmt = $pdo->prepare("
  SELECT id, email, password_hash, full_name, is_email_verified
  FROM users
  WHERE email = ?
  LIMIT 1
");
$stmt->execute([$email]);
$user = $stmt->fetch();

// Check credentials
if (!$user || !password_verify($password, $user['password_hash'])) {
  header('Location: /office-manager/login.php?error=invalid');
  exit;
}

// Set session
$_SESSION['user_id'] = $user['id'];
$_SESSION['email'] = $user['email'];
$_SESSION['full_name'] = $user['full_name'];
$_SESSION['is_email_verified'] = (int)$user['is_email_verified'];

// SECURITY RULE: Email verification is mandatory
if ($user['is_email_verified'] != 1) {
  header('Location: /office-manager/verify-required.php');
  exit;
}

// Check workspace membership
$stmt = $pdo->prepare("
  SELECT wm.workspace_id, wm.role, w.name as workspace_name
  FROM workspace_members wm
  JOIN workspaces w ON w.id = wm.workspace_id
  WHERE wm.user_id = ? AND wm.is_active = 1
  LIMIT 1
");
$stmt->execute([$user['id']]);
$membership = $stmt->fetch();

// No workspace membership -> onboarding
if (!$membership) {
  header('Location: /office-manager/onboarding.php');
  exit;
}

// Set workspace context in session (SECURITY: tenant isolation)
$_SESSION['workspace_id'] = $membership['workspace_id'];
$_SESSION['workspace_name'] = $membership['workspace_name'];
$_SESSION['role'] = $membership['role'];

// Route by role to correct panel
switch ($membership['role']) {
  case 'admin':
    header('Location: /office-manager/dashboard.php');
    break;
  case 'pm':
    header('Location: /office-manager/dashboard.php');
    break;
  case 'worker':
    header('Location: /office-manager/dashboard.php');
    break;
  default:
    header('Location: /office-manager/dashboard.php');
}
exit;
