<?php
/**
 * Office Manager - Dashboard (Multilingual)
 */

require_once __DIR__ . '/backend/lib/auth_guard.php';
om_require_login();

// Get language from session
$lang = $_SESSION['lang'] ?? 'bg';

// Get user info
$userName = $_SESSION['full_name'] ?? 'Потребител';
$userInitials = '';
if ($userName) {
  $nameParts = explode(' ', $userName);
  $userInitials = strtoupper(substr($nameParts[0], 0, 1));
  if (isset($nameParts[1])) {
    $userInitials .= strtoupper(substr($nameParts[1], 0, 1));
  }
}

// Translations
$t = [
  'bg' => [
    'workspace' => 'Основно работно пространство',
    'premium' => 'Премиум',
    'dashboard' => 'Табло',
    'tasks' => 'Задачи',
    'orders' => 'Поръчки',
    'purchases' => 'Покупки',
    'clients' => 'Клиенти',
    'invoices' => 'Фактури',
    'reports' => 'Отчети',
    'settings' => 'Настройки',
    'dashboard_overview' => 'Преглед на таблото',
    'welcome_back' => 'Добре дошли! Ето какво се случва с вашия бизнес днес.',
    'total_orders' => 'Общо поръчки',
    'tasks_today' => 'Задачи днес',
    'active_purchases' => 'Активни покупки',
    'pending_alerts' => 'Чакащи известия',
    'from_last_week' => 'от миналата седмица',
    'from_yesterday' => 'от вчера',
    'this_month' => 'този месец',
    'new_today' => 'нови днес',
    'todays_tasks' => 'Днешни задачи',
    'scheduled_activities' => 'Вашите планирани дейности за днес',
    'task' => 'Задача',
    'client' => 'Клиент',
    'priority' => 'Приоритет',
    'due_time' => 'Краен час',
    'status' => 'Статус',
    'high' => 'Висок',
    'medium' => 'Среден',
    'low' => 'Нисък',
    'in_progress' => 'В процес',
    'scheduled' => 'Планирано',
    'internal' => 'Вътрешен',
    'system_alerts' => 'Системни известия',
    'notifications_attention' => 'Важни уведомления, изискващи вашето внимание',
    'profile' => 'Профил',
    'driver_data' => 'Шофьорски данни',
    'logout' => 'Изход',
  ],
  'en' => [
    'workspace' => 'Main Workspace',
    'premium' => 'Premium',
    'dashboard' => 'Dashboard',
    'tasks' => 'Tasks',
    'orders' => 'Orders',
    'purchases' => 'Purchases',
    'clients' => 'Clients',
    'invoices' => 'Invoices',
    'reports' => 'Reports',
    'settings' => 'Settings',
    'dashboard_overview' => 'Dashboard Overview',
    'welcome_back' => 'Welcome back! Here\'s what\'s happening with your business today.',
    'total_orders' => 'Total Orders',
    'tasks_today' => 'Tasks Today',
    'active_purchases' => 'Active Purchases',
    'pending_alerts' => 'Pending Alerts',
    'from_last_week' => 'from last week',
    'from_yesterday' => 'from yesterday',
    'this_month' => 'this month',
    'new_today' => 'new today',
    'todays_tasks' => 'Today\'s Tasks',
    'scheduled_activities' => 'Your scheduled activities for today',
    'task' => 'Task',
    'client' => 'Client',
    'priority' => 'Priority',
    'due_time' => 'Due Time',
    'status' => 'Status',
    'high' => 'High',
    'medium' => 'Medium',
    'low' => 'Low',
    'in_progress' => 'In Progress',
    'scheduled' => 'Scheduled',
    'internal' => 'Internal',
    'system_alerts' => 'System Alerts',
    'notifications_attention' => 'Important notifications requiring your attention',
    'profile' => 'Profile',
    'driver_data' => 'Driver Data',
    'logout' => 'Logout',
  ],
  'ru' => [
    'workspace' => 'Основное рабочее пространство',
    'premium' => 'Премиум',
    'dashboard' => 'Панель',
    'tasks' => 'Задачи',
    'orders' => 'Заказы',
    'purchases' => 'Покупки',
    'clients' => 'Клиенты',
    'invoices' => 'Счета',
    'reports' => 'Отчеты',
    'settings' => 'Настройки',
    'dashboard_overview' => 'Обзор панели',
    'welcome_back' => 'Добро пожаловать! Вот что происходит с вашим бизнесом сегодня.',
    'total_orders' => 'Всего заказов',
    'tasks_today' => 'Задачи сегодня',
    'active_purchases' => 'Активные покупки',
    'pending_alerts' => 'Ожидающие уведомления',
    'from_last_week' => 'с прошлой недели',
    'from_yesterday' => 'со вчерашнего дня',
    'this_month' => 'в этом месяце',
    'new_today' => 'новых сегодня',
    'todays_tasks' => 'Сегодняшние задачи',
    'scheduled_activities' => 'Ваши запланированные действия на сегодня',
    'task' => 'Задача',
    'client' => 'Клиент',
    'priority' => 'Приоритет',
    'due_time' => 'Срок',
    'status' => 'Статус',
    'high' => 'Высокий',
    'medium' => 'Средний',
    'low' => 'Низкий',
    'in_progress' => 'В процессе',
    'scheduled' => 'Запланировано',
    'internal' => 'Внутренний',
    'system_alerts' => 'Системные уведомления',
    'notifications_attention' => 'Важные уведомления, требующие вашего внимания',
    'profile' => 'Профиль',
    'driver_data' => 'Данные водителя',
    'logout' => 'Выход',
  ],
];

$tr = $t[$lang];
?>
<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Office Manager - Premium Business Management Platform">
  <title><?= $tr['dashboard'] ?> - Office Manager</title>
  <base href="/office-manager/app/">
  <link rel="stylesheet" href="css/main.css">
  <style>
    /* User Dropdown Menu */
    .topbar-user {
      position: relative;
      cursor: pointer;
    }
    .user-dropdown {
      position: absolute;
      top: calc(100% + var(--space-2));
      right: 0;
      min-width: 200px;
      background: var(--color-surface);
      border: 1px solid var(--color-border-default);
      border-radius: var(--radius-lg);
      box-shadow: var(--shadow-xl);
      opacity: 0;
      visibility: hidden;
      transform: translateY(-10px);
      transition: all var(--transition-fast);
      z-index: 1000;
      overflow: hidden;
    }
    .user-dropdown.active {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }
    .dropdown-item {
      display: flex;
      align-items: center;
      gap: var(--space-3);
      padding: var(--space-4) var(--space-5);
      color: var(--color-text-secondary);
      text-decoration: none;
      font-size: var(--font-size-sm);
      font-weight: var(--font-weight-medium);
      transition: all var(--transition-fast);
      border-bottom: 1px solid var(--color-border-subtle);
    }
    .dropdown-item:last-child {
      border-bottom: none;
    }
    .dropdown-item:hover {
      background: var(--color-surface-hover);
      color: var(--color-text-primary);
    }
    .dropdown-item.logout {
      color: var(--color-error);
    }
    .dropdown-item.logout:hover {
      background: rgba(248, 113, 113, 0.1);
    }
    .dropdown-icon {
      width: 20px;
      height: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: var(--font-size-base);
    }
  </style>
</head>
<body>
  <div class="app-container">
    
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="sidebar-header">
        <div class="sidebar-logo">
          <div class="sidebar-logo-icon">OM</div>
          <span>Office Manager</span>
        </div>
      </div>
      
      <nav class="sidebar-nav">
        <a href="#" class="sidebar-nav-item active">
          <span class="sidebar-nav-icon">📊</span>
          <span><?= $tr['dashboard'] ?></span>
        </a>
        <a href="#" class="sidebar-nav-item">
          <span class="sidebar-nav-icon">📋</span>
          <span><?= $tr['tasks'] ?></span>
        </a>
        <a href="#" class="sidebar-nav-item">
          <span class="sidebar-nav-icon">📦</span>
          <span><?= $tr['orders'] ?></span>
        </a>
        <a href="#" class="sidebar-nav-item">
          <span class="sidebar-nav-icon">🛒</span>
          <span><?= $tr['purchases'] ?></span>
        </a>
        <a href="#" class="sidebar-nav-item">
          <span class="sidebar-nav-icon">👥</span>
          <span><?= $tr['clients'] ?></span>
        </a>
        <a href="#" class="sidebar-nav-item">
          <span class="sidebar-nav-icon">📄</span>
          <span><?= $tr['invoices'] ?></span>
        </a>
        <a href="#" class="sidebar-nav-item">
          <span class="sidebar-nav-icon">📈</span>
          <span><?= $tr['reports'] ?></span>
        </a>
        <a href="#" class="sidebar-nav-item">
          <span class="sidebar-nav-icon">⚙️</span>
          <span><?= $tr['settings'] ?></span>
        </a>
      </nav>
    </aside>

    <!-- Top Bar -->
    <header class="topbar">
      <div class="topbar-workspace">
        <h1 class="topbar-workspace-name"><?= $tr['workspace'] ?></h1>
        <span class="topbar-workspace-badge"><?= $tr['premium'] ?></span>
      </div>
      
      <div class="topbar-actions">
        <button class="btn btn-ghost">
          <span>🔔</span>
        </button>
        
        <div class="topbar-user" id="userMenuBtn">
          <div class="topbar-user-avatar"><?= htmlspecialchars($userInitials) ?></div>
          <span class="topbar-user-name"><?= htmlspecialchars($userName) ?></span>
          
          <!-- Dropdown Menu -->
          <div class="user-dropdown" id="userDropdown">
            <a href="#" class="dropdown-item" onclick="alert('<?= addslashes($tr['profile']) ?> - функцията ще бъде активирана скоро'); return false;">
              <span class="dropdown-icon">👤</span>
              <span><?= $tr['profile'] ?></span>
            </a>
            <a href="#" class="dropdown-item" onclick="alert('<?= addslashes($tr['driver_data']) ?> - функцията ще бъде активирана скоро'); return false;">
              <span class="dropdown-icon">🚗</span>
              <span><?= $tr['driver_data'] ?></span>
            </a>
            <a href="/office-manager/backend/api/auth/logout.php" class="dropdown-item logout">
              <span class="dropdown-icon">🚪</span>
              <span><?= $tr['logout'] ?></span>
            </a>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
      <div class="content-header">
        <h2 class="content-title"><?= $tr['dashboard_overview'] ?></h2>
        <p class="content-subtitle"><?= $tr['welcome_back'] ?></p>
      </div>

      <!-- KPI Cards -->
      <div class="kpi-grid">
        <div class="kpi">
          <div class="kpi-label"><?= $tr['total_orders'] ?></div>
          <div class="kpi-value">247</div>
          <span class="kpi-change positive">↑ 12% <?= $tr['from_last_week'] ?></span>
        </div>

        <div class="kpi">
          <div class="kpi-label"><?= $tr['tasks_today'] ?></div>
          <div class="kpi-value">18</div>
          <span class="kpi-change negative">↓ 3 <?= $tr['from_yesterday'] ?></span>
        </div>

        <div class="kpi">
          <div class="kpi-label"><?= $tr['active_purchases'] ?></div>
          <div class="kpi-value">32</div>
          <span class="kpi-change positive">↑ 8% <?= $tr['this_month'] ?></span>
        </div>

        <div class="kpi">
          <div class="kpi-label"><?= $tr['pending_alerts'] ?></div>
          <div class="kpi-value">5</div>
          <span class="kpi-change negative">↑ 2 <?= $tr['new_today'] ?></span>
        </div>
      </div>

      <!-- Today's Tasks Table -->
      <div class="card mb-8">
        <div class="card-header">
          <h3 class="card-title"><?= $tr['todays_tasks'] ?></h3>
          <p class="card-subtitle"><?= $tr['scheduled_activities'] ?></p>
        </div>
        
        <div class="table-container">
          <table class="table">
            <thead>
              <tr>
                <th><?= $tr['task'] ?></th>
                <th><?= $tr['client'] ?></th>
                <th><?= $tr['priority'] ?></th>
                <th><?= $tr['due_time'] ?></th>
                <th><?= $tr['status'] ?></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="text-primary font-medium">Review Q4 financial reports</td>
                <td><?= $tr['internal'] ?></td>
                <td><span class="badge badge-error"><?= $tr['high'] ?></span></td>
                <td>10:00 AM</td>
                <td><span class="badge badge-warning"><?= $tr['in_progress'] ?></span></td>
              </tr>
              <tr>
                <td class="text-primary font-medium">Client meeting - Project Alpha</td>
                <td>Acme Corp</td>
                <td><span class="badge badge-error"><?= $tr['high'] ?></span></td>
                <td>2:00 PM</td>
                <td><span class="badge badge-info"><?= $tr['scheduled'] ?></span></td>
              </tr>
              <tr>
                <td class="text-primary font-medium">Update inventory database</td>
                <td><?= $tr['internal'] ?></td>
                <td><span class="badge badge-warning"><?= $tr['medium'] ?></span></td>
                <td>4:00 PM</td>
                <td><span class="badge badge-info"><?= $tr['scheduled'] ?></span></td>
              </tr>
              <tr>
                <td class="text-primary font-medium">Process supplier invoices</td>
                <td>Various</td>
                <td><span class="badge badge-warning"><?= $tr['medium'] ?></span></td>
                <td>5:00 PM</td>
                <td><span class="badge badge-info"><?= $tr['scheduled'] ?></span></td>
              </tr>
              <tr>
                <td class="text-primary font-medium">Prepare weekly team summary</td>
                <td><?= $tr['internal'] ?></td>
                <td><span class="badge badge-success"><?= $tr['low'] ?></span></td>
                <td>6:00 PM</td>
                <td><span class="badge badge-info"><?= $tr['scheduled'] ?></span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Alerts Card -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title"><?= $tr['system_alerts'] ?></h3>
          <p class="card-subtitle"><?= $tr['notifications_attention'] ?></p>
        </div>
        
        <div class="card-body">
          <div style="display: flex; flex-direction: column; gap: var(--space-4);">
            
            <div style="padding: var(--space-4); background: var(--color-bg-tertiary); border-radius: var(--radius-md); border-left: 3px solid var(--color-error);">
              <div style="display: flex; align-items: start; gap: var(--space-3); margin-bottom: var(--space-2);">
                <span style="font-size: var(--font-size-lg);">⚠️</span>
                <div style="flex: 1;">
                  <div class="text-primary font-semibold" style="margin-bottom: var(--space-1);">Contract expiring soon</div>
                  <div class="text-secondary" style="font-size: var(--font-size-sm);">
                    Client contract with TechVentures expires in 5 days
                  </div>
                </div>
                <span class="badge badge-error">Urgent</span>
              </div>
            </div>

            <div style="padding: var(--space-4); background: var(--color-bg-tertiary); border-radius: var(--radius-md); border-left: 3px solid var(--color-warning);">
              <div style="display: flex; align-items: start; gap: var(--space-3); margin-bottom: var(--space-2);">
                <span style="font-size: var(--font-size-lg);">📦</span>
                <div style="flex: 1;">
                  <div class="text-primary font-semibold" style="margin-bottom: var(--space-1);">Low stock alert</div>
                  <div class="text-secondary" style="font-size: var(--font-size-sm);">
                    3 items are running low in inventory and need reordering
                  </div>
                </div>
                <span class="badge badge-warning">Medium</span>
              </div>
            </div>

            <div style="padding: var(--space-4); background: var(--color-bg-tertiary); border-radius: var(--radius-md); border-left: 3px solid var(--color-info);">
              <div style="display: flex; align-items: start; gap: var(--space-3); margin-bottom: var(--space-2);">
                <span style="font-size: var(--font-size-lg);">💰</span>
                <div style="flex: 1;">
                  <div class="text-primary font-semibold" style="margin-bottom: var(--space-1);">Payment reminder</div>
                  <div class="text-secondary" style="font-size: var(--font-size-sm);">
                    Invoice #2847 payment due from GlobalTech in 2 days
                  </div>
                </div>
                <span class="badge badge-info">Normal</span>
              </div>
            </div>

            <div style="padding: var(--space-4); background: var(--color-bg-tertiary); border-radius: var(--radius-md); border-left: 3px solid var(--color-success);">
              <div style="display: flex; align-items: start; gap: var(--space-3); margin-bottom: var(--space-2);">
                <span style="font-size: var(--font-size-lg);">✅</span>
                <div style="flex: 1;">
                  <div class="text-primary font-semibold" style="margin-bottom: var(--space-1);">Backup completed</div>
                  <div class="text-secondary" style="font-size: var(--font-size-sm);">
                    Weekly system backup completed successfully at 3:00 AM
                  </div>
                </div>
                <span class="badge badge-success">Info</span>
              </div>
            </div>

            <div style="padding: var(--space-4); background: var(--color-bg-tertiary); border-radius: var(--radius-md); border-left: 3px solid var(--color-warning);">
              <div style="display: flex; align-items: start; gap: var(--space-3); margin-bottom: var(--space-2);">
                <span style="font-size: var(--font-size-lg);">📅</span>
                <div style="flex: 1;">
                  <div class="text-primary font-semibold" style="margin-bottom: var(--space-1);">Upcoming maintenance</div>
                  <div class="text-secondary" style="font-size: var(--font-size-sm);">
                    System maintenance scheduled for this Saturday, 2:00 AM - 4:00 AM
                  </div>
                </div>
                <span class="badge badge-warning">Scheduled</span>
              </div>
            </div>

          </div>
        </div>
      </div>

    </main>
  </div>
  
  <script>
    // User dropdown toggle
    const userMenuBtn = document.getElementById('userMenuBtn');
    const userDropdown = document.getElementById('userDropdown');
    
    if (userMenuBtn && userDropdown) {
      userMenuBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        userDropdown.classList.toggle('active');
      });
      
      document.addEventListener('click', function(e) {
        if (!userMenuBtn.contains(e.target)) {
          userDropdown.classList.remove('active');
        }
      });
      
      userDropdown.addEventListener('click', function(e) {
        e.stopPropagation();
      });
    }
  </script>
</body>
</html>
