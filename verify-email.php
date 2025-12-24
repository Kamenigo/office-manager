<?php
/**
 * Office Manager - Email Verification
 * Handles email verification from link
 */

require_once __DIR__ . '/backend/config/database.php';

session_start();

// Get parameters
$token = $_GET['token'] ?? '';
$lang = $_GET['lang'] ?? 'bg';

// Translations
$t = [
  'bg' => [
    'success_title' => 'Email потвърден успешно!',
    'success_message' => 'Вашият акаунт беше активиран. Можете да влезете в системата.',
    'error_title' => 'Грешка при потвърждение',
    'error_invalid' => 'Невалиден или изтекъл линк за потвърждение.',
    'error_already' => 'Този email вече е потвърден.',
    'login_btn' => 'Вход в системата',
  ],
  'en' => [
    'success_title' => 'Email verified successfully!',
    'success_message' => 'Your account has been activated. You can now log in.',
    'error_title' => 'Verification error',
    'error_invalid' => 'Invalid or expired verification link.',
    'error_already' => 'This email is already verified.',
    'login_btn' => 'Login to system',
  ],
  'ru' => [
    'success_title' => 'Email успешно подтвержден!',
    'success_message' => 'Ваш аккаунт был активирован. Вы можете войти в систему.',
    'error_title' => 'Ошибка подтверждения',
    'error_invalid' => 'Недействительная или истекшая ссылка подтверждения.',
    'error_already' => 'Этот email уже подтвержден.',
    'login_btn' => 'Вход в систему',
  ],
  'de' => [
    'success_title' => 'E-Mail erfolgreich bestätigt!',
    'success_message' => 'Ihr Konto wurde aktiviert. Sie können sich jetzt anmelden.',
    'error_title' => 'Bestätigungsfehler',
    'error_invalid' => 'Ungültiger oder abgelaufener Bestätigungslink.',
    'error_already' => 'Diese E-Mail ist bereits bestätigt.',
    'login_btn' => 'Anmelden',
  ],
];

$tr = $t[$lang] ?? $t['bg'];

$success = false;
$error = '';

if (empty($token)) {
  $error = $tr['error_invalid'];
} else {
  try {
    $db = get_db_connection();
    
    // Find user by token
    $stmt = $db->prepare("
      SELECT id, is_email_verified, created_at 
      FROM users 
      WHERE verification_token = ?
    ");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
      $error = $tr['error_invalid'];
    } elseif ($user['is_email_verified']) {
      $error = $tr['error_already'];
    } else {
      // Check if token is not expired (24 hours)
      $created_time = strtotime($user['created_at']);
      $current_time = time();
      $hours_passed = ($current_time - $created_time) / 3600;
      
      if ($hours_passed > 24) {
        $error = $tr['error_invalid'];
      } else {
        // Verify email
        $stmt = $db->prepare("
          UPDATE users 
          SET is_email_verified = 1, verification_token = NULL 
          WHERE id = ?
        ");
        $stmt->execute([$user['id']]);
        
        $success = true;
      }
    }
  } catch (Exception $e) {
    error_log("Email verification error: " . $e->getMessage());
    $error = $tr['error_invalid'];
  }
}
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $success ? $tr['success_title'] : $tr['error_title'] ?> - Office Manager</title>
  <link rel="stylesheet" href="app/css/main.css">
  <style>
    .verify-container {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: var(--space-4);
    }
    .verify-card {
      width: 100%;
      max-width: 500px;
      text-align: center;
    }
    .verify-icon {
      width: 80px;
      height: 80px;
      margin: 0 auto var(--space-6);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 40px;
    }
    .verify-icon.success {
      background: rgba(34, 197, 94, 0.1);
      color: #22c55e;
    }
    .verify-icon.error {
      background: rgba(248, 113, 113, 0.1);
      color: var(--color-error);
    }
    h1 {
      margin-bottom: var(--space-4);
    }
    .verify-message {
      color: var(--color-text-secondary);
      margin-bottom: var(--space-8);
      line-height: 1.6;
    }
  </style>
</head>
<body>
  <div class="app-container">
    <div class="verify-container">
      <div class="verify-card">
        <div class="card" style="padding: var(--space-8);">
          <?php if ($success): ?>
            <div class="verify-icon success">✓</div>
            <h1><?= $tr['success_title'] ?></h1>
            <p class="verify-message"><?= $tr['success_message'] ?></p>
            <a href="/office-manager/login.php?lang=<?= $lang ?>" class="btn btn-primary">
              <?= $tr['login_btn'] ?>
            </a>
          <?php else: ?>
            <div class="verify-icon error">✕</div>
            <h1><?= $tr['error_title'] ?></h1>
            <p class="verify-message"><?= $error ?></p>
            <a href="/office-manager/register.php?lang=<?= $lang ?>" class="btn btn-secondary">
              <?= $lang === 'bg' ? 'Регистрация отново' : ($lang === 'ru' ? 'Регистрация снова' : ($lang === 'de' ? 'Erneut registrieren' : 'Register again')) ?>
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
