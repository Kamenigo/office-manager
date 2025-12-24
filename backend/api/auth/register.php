<?php
/**
 * Office Manager - Registration API
 * Handles user registration and sends email verification
 */

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../lib/email.php';

session_start();

// Get language
$lang = $_POST['lang'] ?? 'bg';

// Validation
if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['confirm_password'])) {
  header("Location: /office-manager/register.php?error=required&lang=$lang");
  exit;
}

$name = trim($_POST['name']);
$email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Email validation
if (!$email) {
  header("Location: /office-manager/register.php?error=invalid_email&lang=$lang");
  exit;
}

// Password validation
if (strlen($password) < 8) {
  header("Location: /office-manager/register.php?error=password_length&lang=$lang&name=" . urlencode($name) . "&email=" . urlencode($email));
  exit;
}

if ($password !== $confirm_password) {
  header("Location: /office-manager/register.php?error=password_mismatch&lang=$lang&name=" . urlencode($name) . "&email=" . urlencode($email));
  exit;
}

try {
  // Database connection
  $db = get_db_connection();
  
  // Check if email already exists
  $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
  $stmt->execute([$email]);
  if ($stmt->fetch()) {
    header("Location: /office-manager/register.php?error=email_exists&lang=$lang&name=" . urlencode($name));
    exit;
  }
  
  // Generate verification token
  $verification_token = bin2hex(random_bytes(32));
  
  // Hash password
  $password_hash = password_hash($password, PASSWORD_BCRYPT);
  
  // Insert user
  $stmt = $db->prepare("
    INSERT INTO users (name, email, password_hash, verification_token, is_email_verified, created_at) 
    VALUES (?, ?, ?, ?, 0, NOW())
  ");
  $stmt->execute([$name, $email, $password_hash, $verification_token]);
  
  // Send verification email
  $verification_link = "https://re-furnishbg.com/office-manager/verify-email.php?token=$verification_token&lang=$lang";
  
  $email_sent = send_verification_email($email, $name, $verification_link, $lang);
  
  if (!$email_sent) {
    // Log error but still proceed (user can request resend)
    error_log("Failed to send verification email to: $email");
  }
  
  // Redirect to success
  header("Location: /office-manager/register.php?success=1&lang=$lang");
  exit;
  
} catch (Exception $e) {
  error_log("Registration error: " . $e->getMessage());
  header("Location: /office-manager/register.php?error=default&lang=$lang");
  exit;
}
