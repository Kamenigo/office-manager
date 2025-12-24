<?php
require_once __DIR__ . '/backend/lib/auth_guard.php';
om_require_login(); // Трябва да е логнат и верифициран

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
    }////////////////
.choice-icon svg {
      width: 48px;
      height: 48px;
      stroke: var(--color-accent-primary, #d4af37);
      stroke-width: 1.5;
      fill: none;
      stroke-linecap: round;
      stroke-linejoin: round;
      animation: iconGlow 3s ease-in-out infinite;
    }
    @keyframes iconGlow {
      0%, 100% { opacity: 0.7; filter: drop-shadow(0 0 2px rgba(212, 175, 55, 0.3)); }
      50% { opacity: 1; filter: drop-shadow(0 0 6px rgba(212, 175, 55, 0.5)); }
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
          <div class="card choice-card" onclick="alert('Функцията ще бъде активирана скоро: Създаване на работно пространство')">
            
           <svg viewBox="0 0 24 24" width="1.2em" height="1.2em" style="vertical-align:-0.2em;stroke:currentColor;stroke-width:1.5;fill:none;stroke-linecap:round;stroke-linejoin:round" aria-label="Solo">
  <circle cx="12" cy="7" r="4"/>
  <path d="M5.5 21v-2a4 4 0 0 1 4-4h5a4 4 0 0 1 4 4v2"/>
</svg>

            <h3>Самостоятелна работа</h3>
            <p class="text-secondary" style="margin-top: var(--space-3);">
              Създайте собствено работно пространство 
            </p>
          </div>

          <div class="card choice-card" onclick="alert('Функцията ще бъде активирана скоро: Приемане на покана')">
            <svg viewBox="0 0 24 24" width="1.2em" height="1.2em" style="vertical-align:-0.2em;stroke:currentColor;stroke-width:1.5;fill:none;stroke-linecap:round;stroke-linejoin:round" aria-label="Team">
  <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
  <circle cx="9" cy="7" r="4"/>
  <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
  <circle cx="19" cy="7" r="3"/>
</svg>

            <h3>Работа в екип</h3>
            <p class="text-secondary" style="margin-top: var(--space-3);">
              Създай отборно работно пространство
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
