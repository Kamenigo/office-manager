<?php
// backend/lib/auth_guard.php
// Minimal, strict guard: session required + email verified + role check (optional)

function om_start_session(): void {
  if (session_status() === PHP_SESSION_NONE) {
    // Secure-ish defaults for shared hosting
    ini_set('session.use_strict_mode', '1');
    session_start();
  }
}

function om_require_login(): void {
  om_start_session();

  if (empty($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
  }

  if (empty($_SESSION['is_email_verified']) || $_SESSION['is_email_verified'] != 1) {
    header('Location: /verify-required.php');
    exit;
  }
}

/**
 * @param array $allowed_roles e.g. ['admin','pm']
 */
function om_require_role(array $allowed_roles): void {
  om_require_login();

  $role = $_SESSION['role'] ?? null;
  if (!$role || !in_array($role, $allowed_roles, true)) {
    http_response_code(403);
    echo "403 Forbidden - на ясно си че нямаш работа тук. Твоят IP adress е записан!";
    exit;
  }
}

