<?php
/**
 * Office Manager - Example config (DO NOT put real passwords in Git)
 * Copy this file to: backend/config.php and fill real values on the server.
 */

return [
  'db' => [
    'host' => 'localhost',
    'name' => 'refurnis_TaskPilot',
    'user' => 'db_user',
    'pass' => 'db_password',
    'charset' => 'utf8mb4',
  ],

  // App base url used for email links (verify/invite)
  'app' => [
    'base_url' => 'https://your-domain.com',
  ],

  // For sessions / tokens (set real random string in backend/config.php)
  'security' => [
    'app_key' => 'CHANGE_ME_RANDOM_LONG_STRING',
  ],
];






