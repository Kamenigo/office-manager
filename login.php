<?php
// Language handling
session_start();

// Get language from URL or session (default: bg)
$lang = $_GET['lang'] ?? $_SESSION['lang'] ?? 'bg';
if (in_array($lang, ['bg', 'en', 'ru', 'de'])) {
  $_SESSION['lang'] = $lang;
} else {
  $lang = 'bg';
}

// Translations
$t = [
  'bg' => [
    'title' => 'Вход в системата',
    'subtitle' => 'Въведете вашите данни за достъп',
    'email' => 'Email адрес',
    'password' => 'Парола',
    'login_btn' => 'Вход',
    'no_account' => 'Нямате акаунт?',
    'register' => 'Регистрирайте се',
    'error_invalid' => 'Грешен email или парола.',
    'error_required' => 'Моля, попълнете всички полета.',
    'error_not_verified' => 'Моля, потвърдете вашия email адрес.',
    'error_default' => 'Възникна грешка при влизането.',
  ],
  'en' => [
    'title' => 'Login',
    'subtitle' => 'Enter your credentials to access',
    'email' => 'Email address',
    'password' => 'Password',
    'login_btn' => 'Login',
    'no_account' => 'Don\'t have an account?',
    'register' => 'Register',
    'error_invalid' => 'Invalid email or password.',
    'error_required' => 'Please fill in all fields.',
    'error_not_verified' => 'Please verify your email address.',
    'error_default' => 'An error occurred during login.',
  ],
  'ru' => [
    'title' => 'Вход в систему',
    'subtitle' => 'Введите ваши данные для доступа',
    'email' => 'Email адрес',
    'password' => 'Пароль',
    'login_btn' => 'Войти',
    'no_account' => 'Нет аккаунта?',
    'register' => 'Зарегистрироваться',
    'error_invalid' => 'Неверный email или пароль.',
    'error_required' => 'Пожалуйста, заполните все поля.',
    'error_not_verified' => 'Пожалуйста, подтвердите ваш email адрес.',
    'error_default' => 'Произошла ошибка при входе.',
  ],
  'de' => [
    'title' => 'Anmeldung',
    'subtitle' => 'Geben Sie Ihre Anmeldedaten ein',
    'email' => 'E-Mail-Adresse',
    'password' => 'Passwort',
    'login_btn' => 'Anmelden',
    'no_account' => 'Noch kein Konto?',
    'register' => 'Registrieren',
    'error_invalid' => 'Ungültige E-Mail oder Passwort.',
    'error_required' => 'Bitte füllen Sie alle Felder aus.',
    'error_not_verified' => 'Bitte bestätigen Sie Ihre E-Mail-Adresse.',
    'error_default' => 'Bei der Anmeldung ist ein Fehler aufgetreten.',
  ],
];

$tr = $t[$lang];

// Language info for dropdown
$languages = [
  'bg' => ['name' => 'Български', 'flag' => 'flag-bg'],
  'en' => ['name' => 'English', 'flag' => 'flag-en'],
  'ru' => ['name' => 'Русский', 'flag' => 'flag-ru'],
  'de' => ['name' => 'Deutsch', 'flag' => 'flag-de'],
];

// Redirect if already logged in
if (!empty($_SESSION['user_id']) && !empty($_SESSION['is_email_verified'])) {
  header('Location: /office-manager/dashboard.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $tr['title'] ?> - Office Manager</title>
  <link rel="stylesheet" href="app/css/main.css">
  <style>
    .login-container {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: var(--space-4);
      position: relative;
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
    
    /* Dropdown Language Switcher */
    .language-dropdown {
      position: absolute;
      top: var(--space-6);
      right: var(--space-6);
      z-index: 100;
    }
    
    .lang-current {
      width: 44px;
      height: 32px;
      border-radius: var(--radius-md);
      cursor: pointer;
      transition: all var(--transition-fast);
      border: 2px solid var(--color-accent-primary);
      overflow: hidden;
      position: relative;
      box-shadow: 0 0 0 3px var(--color-accent-glow), var(--shadow-md);
      background: var(--color-surface);
    }
    
    .lang-current:hover {
      transform: scale(1.05);
      box-shadow: 0 0 0 4px var(--color-accent-glow), var(--shadow-lg);
    }
    
    .lang-menu {
      position: absolute;
      top: calc(100% + var(--space-2));
      right: 0;
      background: var(--color-surface);
      border: 1px solid var(--color-border-default);
      border-radius: var(--radius-md);
      box-shadow: var(--shadow-lg);
      overflow: hidden;
      opacity: 0;
      transform: translateY(-10px);
      pointer-events: none;
      transition: all var(--transition-fast);
      min-width: 160px;
    }
    
    .language-dropdown.open .lang-menu {
      opacity: 1;
      transform: translateY(0);
      pointer-events: all;
    }
    
    .lang-option {
      display: flex;
      align-items: center;
      gap: var(--space-3);
      padding: var(--space-3);
      text-decoration: none;
      color: var(--color-text-primary);
      transition: background var(--transition-fast);
      cursor: pointer;
    }
    
    .lang-option:hover {
      background: var(--color-background-secondary);
    }
    
    .lang-option.active {
      background: rgba(212, 175, 55, 0.1);
      color: var(--color-accent-primary);
      font-weight: var(--font-weight-medium);
    }
    
    .lang-flag {
      width: 32px;
      height: 22px;
      border-radius: 3px;
      overflow: hidden;
      position: relative;
      flex-shrink: 0;
      box-shadow: var(--shadow-sm);
    }
    
    .lang-name {
      font-size: var(--font-size-sm);
    }
    
    /* Bulgarian Flag - White, Green, Red */
    .flag-bg {
      background: linear-gradient(to bottom, 
        #FFFFFF 0%, #FFFFFF 33.33%,
        #00966E 33.33%, #00966E 66.66%,
        #D62612 66.66%, #D62612 100%
      );
    }
    
    /* UK Flag - Union Jack (simplified) */
    .flag-en {
      background: #012169;
      position: relative;
    }
    .flag-en::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: 
        linear-gradient(to bottom, transparent 40%, #FFFFFF 40%, #FFFFFF 60%, transparent 60%),
        linear-gradient(to right, transparent 40%, #FFFFFF 40%, #FFFFFF 60%, transparent 60%);
    }
    .flag-en::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: 
        linear-gradient(to bottom, transparent 45%, #C8102E 45%, #C8102E 55%, transparent 55%),
        linear-gradient(to right, transparent 45%, #C8102E 45%, #C8102E 55%, transparent 55%);
    }
    
    /* Russian Flag - White, Blue, Red */
    .flag-ru {
      background: linear-gradient(to bottom, 
        #FFFFFF 0%, #FFFFFF 33.33%,
        #0039A6 33.33%, #0039A6 66.66%,
        #D52B1E 66.66%, #D52B1E 100%
      );
    }
    
    /* German Flag - Black, Red, Gold */
    .flag-de {
      background: linear-gradient(to bottom, 
        #000000 0%, #000000 33.33%,
        #DD0000 33.33%, #DD0000 66.66%,
        #FFCE00 66.66%, #FFCE00 100%
      );
    }
    
    @media (max-width: 768px) {
      .language-dropdown {
        top: var(--space-4);
        right: var(--space-4);
      }
      .lang-current {
        width: 40px;
        height: 28px;
      }
    }
  </style>
</head>
<body>
  <div class="app-container">
    
    <!-- Dropdown Language Switcher -->
    <div class="language-dropdown" id="langDropdown">
      <div class="lang-current <?= $languages[$lang]['flag'] ?>" onclick="toggleLangMenu()"></div>
      <div class="lang-menu">
        <?php foreach ($languages as $code => $info): ?>
          <a href="?lang=<?= $code ?>" class="lang-option <?= $lang === $code ? 'active' : '' ?>">
            <div class="lang-flag <?= $info['flag'] ?>"></div>
            <span class="lang-name"><?= $info['name'] ?></span>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
    
    <div class="login-container">
      <div class="login-card">
        <div class="login-header">
          <div class="login-logo">OM</div>
          <h1 style="margin-bottom: var(--space-2);"><?= $tr['title'] ?></h1>
          <p class="text-secondary" style="font-size: var(--font-size-sm);"><?= $tr['subtitle'] ?></p>
        </div>

        <div class="card">
          <?php if (isset($_GET['error'])): ?>
            <div class="error-message">
              <?php
                $error = htmlspecialchars($_GET['error']);
                if ($error === 'invalid') echo $tr['error_invalid'];
                elseif ($error === 'required') echo $tr['error_required'];
                elseif ($error === 'not_verified') echo $tr['error_not_verified'];
                else echo $tr['error_default'];
              ?>
            </div>
          <?php endif; ?>

          <form method="POST" action="/office-manager/backend/api/auth/login.php">
            <input type="hidden" name="lang" value="<?= $lang ?>">
            
            <div class="form-group">
              <label for="email" class="form-label"><?= $tr['email'] ?></label>
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
              <label for="password" class="form-label"><?= $tr['password'] ?></label>
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
              <?= $tr['login_btn'] ?>
            </button>
          </form>
        </div>

        <p style="text-align: center; margin-top: var(--space-6); color: var(--color-text-tertiary); font-size: var(--font-size-sm);">
          <?= $tr['no_account'] ?> <a href="/office-manager/register.php?lang=<?= $lang ?>"><?= $tr['register'] ?></a>
        </p>
      </div>
    </div>
  </div>

  <script>
    // Language dropdown toggle
    function toggleLangMenu() {
      document.getElementById('langDropdown').classList.toggle('open');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
      const dropdown = document.getElementById('langDropdown');
      if (!dropdown.contains(e.target)) {
        dropdown.classList.remove('open');
      }
    });
  </script>
</body>
</html>
