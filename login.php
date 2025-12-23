<?php
// Redirect if already logged in
session_start();
if (!empty($_SESSION['user_id']) && !empty($_SESSION['is_email_verified'])) {
  header('Location: /office-manager/dashboard.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="bg">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Вход - Office Manager</title>
  <link rel="stylesheet" href="app/css/main.css">
  <style>
    .login-container {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: var(--space-4);
    }
    .login-card {
      width: 100%;
      max-width: 420px;
    }
    .login-header {
      text-align: center;
      margin-bottom: var(--space-8);
    }
    .login-logo {
      width: 64px;
      height: 64px;
      background: linear-gradient(135deg, var(--color-accent-primary), var(--color-accent-secondary));
      border-radius: var(--radius-lg);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: var(--font-size-2xl);
      font-weight: var(--font-weight-bold);
      color: var(--color-text-on-accent);
      margin: 0 auto var(--space-4);
      box-shadow: var(--shadow-glow);
    }
    .form-group {
      margin-bottom: var(--space-5);
    }
    .form-label {
      display: block;
      margin-bottom: var(--space-2);
      font-size: var(--font-size-sm);
      font-weight: var(--font-weight-medium);
      color: var(--color-text-secondary);
    }
    .error-message {
      background: rgba(248, 113, 113, 0.1);
      border: 1px solid var(--color-error);
      border-radius: var(--radius-md);
      padding: var(--space-4);
      margin-bottom: var(--space-6);
      color: var(--color-error);
      font-size: var(--font-size-sm);
    }
  </style>
</head>
<body>
  <div class="app-container">
    <div class="login-container">
      <div class="login-card">
        <div class="login-header">
          <div class="login-logo">OM</div>
          <h1 style="margin-bottom: var(--space-2);">Вход в системата</h1>
          <p class="text-secondary" style="font-size: var(--font-size-sm);">Въведете вашите данни за достъп</p>
        </div>

        <div class="card">
          <?php if (isset($_GET['error'])): ?>
            <div class="error-message">
              <?php
                $error = htmlspecialchars($_GET['error']);
                if ($error === 'invalid') echo 'Грешен email или парола.';
                elseif ($error === 'required') echo 'Моля, попълнете всички полета.';
                else echo 'Възникна грешка при влизането.';
              ?>
            </div>
          <?php endif; ?>

          <form method="POST" action="/office-manager/backend/api/auth/login.php">
            <div class="form-group">
              <label for="email" class="form-label">Email адрес</label>
              <input 
                type="email" 
                id="email" 
                name="email" 
                class="input" 
                placeholder="your@email.com"
                required
                autocomplete="email"
              >
            </div>

            <div class="form-group">
              <label for="password" class="form-label">Парола</label>
              <input 
                type="password" 
                id="password" 
                name="password" 
                class="input" 
                placeholder="••••••••"
                required
                autocomplete="current-password"
              >
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: var(--space-4);">
              Вход
            </button>
          </form>
        </div>

        <p style="text-align: center; margin-top: var(--space-6); color: var(--color-text-tertiary); font-size: var(--font-size-sm);">
          Нямате акаунт? <a href="/office-manager/register.php">Регистрирайте се</a>
        </p>
      </div>
    </div>
  </div>
</body>
</html>
