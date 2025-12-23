<?php
session_start();
$email = $_SESSION['email'] ?? 'вашият email';
?>
<!DOCTYPE html>
<html lang="bg">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Email верификация - Office Manager</title>
  <link rel="stylesheet" href="app/css/main.css">
  <style>
    .verify-container {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: var(--space-4);
      text-align: center;
    }
    .verify-card {
      max-width: 500px;
    }
    .verify-icon {
      font-size: 64px;
      margin-bottom: var(--space-4);
    }
  </style>
</head>
<body>
  <div class="app-container">
    <div class="verify-container">
      <div class="verify-card">
        <div class="verify-icon">📧</div>
        <div class="card">
          <h2>Email верификация необходима</h2>
          <p class="text-secondary" style="margin-top: var(--space-4);">
            Изпратихме верификационен линк на <strong><?= htmlspecialchars($email) ?></strong>
          </p>
          <p class="text-secondary">
            Моля, проверете вашата поща и кликнете върху линка за да активирате акаунта си.
          </p>
          <div style="margin-top: var(--space-6);">
            <a href="/office-manager/login.php" class="btn btn-secondary">Обратно към вход</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
