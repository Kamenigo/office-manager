<?php
require_once __DIR__ . '/backend/lib/auth_guard.php';
om_require_login(); // Must be logged in and verified

$userName = $_SESSION['full_name'] ?? 'Потребител';
?>
<!DOCTYPE html>
<html lang="bg">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Първоначална настройка - Office Manager</title>
  <link rel="stylesheet" href="app/css/main.css">
  <style>
    .onboarding-container {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: var(--space-4);
    }
    .onboarding-content {
      max-width: 700px;
      width: 100%;
    }
    .choice-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: var(--space-6);
      margin-top: var(--space-8);
    }
    .choice-card {
      cursor: pointer;
      text-align: center;
      padding: var(--space-8);
    }
    .choice-card:hover {
      border-color: var(--color-accent-primary);
    }
    .choice-icon {
      font-size: 48px;
      margin-bottom: var(--space-4);
    }
  </style>
</head>
<body>
  <div class="app-container">
    <div class="onboarding-container">
      <div class="onboarding-content">
        <div style="text-align: center; margin-bottom: var(--space-8);">
          <h1>Добре дошли, <?= htmlspecialchars($userName) ?>!</h1>
          <p class="text-secondary" style="margin-top: var(--space-4);">
            Как желаете да използвате Office Manager?
          </p>
        </div>

        <div class="choice-grid">
          <div class="card choice-card" onclick="alert('Функция в разработка: Създаване на workspace')">
            <div class="choice-icon">🏢</div>
            <h3>Работя сам</h3>
            <p class="text-secondary" style="margin-top: var(--space-3);">
              Създайте собствен workspace и започнете да управлявате вашия бизнес
            </p>
          </div>

          <div class="card choice-card" onclick="alert('Функция в разработка: Приемане на покана')">
            <div class="choice-icon">✉️</div>
            <h3>Имам покана</h3>
            <p class="text-secondary" style="margin-top: var(--space-3);">
              Присъединете се към съществуващ workspace по покана
            </p>
          </div>
        </div>

        <div style="text-align: center; margin-top: var(--space-8);">
          <a href="/office-manager/backend/api/auth/logout.php" class="btn btn-ghost">Изход</a>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
