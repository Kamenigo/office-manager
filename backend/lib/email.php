<?php
/**
 * Office Manager - Email Library
 * Handles email sending for verification, notifications, etc.
 */

/**
 * Send verification email
 * 
 * @param string $to Email address
 * @param string $name User name
 * @param string $verification_link Verification URL
 * @param string $lang Language code
 * @return bool Success status
 */
function send_verification_email($to, $name, $verification_link, $lang = 'bg') {
  // Email templates by language
  $templates = [
    'bg' => [
      'subject' => 'Потвърдете вашия email - Office Manager',
      'greeting' => 'Здравейте',
      'intro' => 'Благодарим ви за регистрацията в Office Manager!',
      'instruction' => 'За да активирате вашия акаунт, моля кликнете на бутона по-долу:',
      'button' => 'Потвърди Email',
      'alt_text' => 'Или копирайте този линк в браузъра:',
      'expire' => 'Този линк е валиден 24 часа.',
      'footer' => 'Ако не сте се регистрирали в Office Manager, моля игнорирайте този имейл.',
    ],
    'en' => [
      'subject' => 'Verify your email - Office Manager',
      'greeting' => 'Hello',
      'intro' => 'Thank you for registering with Office Manager!',
      'instruction' => 'To activate your account, please click the button below:',
      'button' => 'Verify Email',
      'alt_text' => 'Or copy this link to your browser:',
      'expire' => 'This link is valid for 24 hours.',
      'footer' => 'If you did not register with Office Manager, please ignore this email.',
    ],
    'ru' => [
      'subject' => 'Подтвердите ваш email - Office Manager',
      'greeting' => 'Здравствуйте',
      'intro' => 'Спасибо за регистрацию в Office Manager!',
      'instruction' => 'Чтобы активировать ваш аккаунт, пожалуйста, нажмите на кнопку ниже:',
      'button' => 'Подтвердить Email',
      'alt_text' => 'Или скопируйте эту ссылку в браузер:',
      'expire' => 'Эта ссылка действительна 24 часа.',
      'footer' => 'Если вы не регистрировались в Office Manager, пожалуйста, игнорируйте это письмо.',
    ],
    'de' => [
      'subject' => 'Bestätigen Sie Ihre E-Mail - Office Manager',
      'greeting' => 'Hallo',
      'intro' => 'Vielen Dank für Ihre Registrierung bei Office Manager!',
      'instruction' => 'Um Ihr Konto zu aktivieren, klicken Sie bitte auf die Schaltfläche unten:',
      'button' => 'E-Mail bestätigen',
      'alt_text' => 'Oder kopieren Sie diesen Link in Ihren Browser:',
      'expire' => 'Dieser Link ist 24 Stunden gültig.',
      'footer' => 'Wenn Sie sich nicht bei Office Manager registriert haben, ignorieren Sie diese E-Mail bitte.',
    ],
  ];
  
  $t = $templates[$lang] ?? $templates['bg'];
  
  // HTML email body
  $html_body = "
<!DOCTYPE html>
<html>
<head>
  <meta charset='utf-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
      background-color: #1a1a1a;
      color: #e5e5e5;
    }
    .container {
      max-width: 600px;
      margin: 40px auto;
      background: #2a2a2a;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    }
    .header {
      background: linear-gradient(135deg, #D4AF37, #C5A028);
      padding: 40px 30px;
      text-align: center;
    }
    .logo {
      width: 64px;
      height: 64px;
      background: rgba(255,255,255,0.2);
      border-radius: 12px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 28px;
      font-weight: bold;
      color: #1a1a1a;
      margin-bottom: 16px;
    }
    .content {
      padding: 40px 30px;
      line-height: 1.6;
    }
    h1 {
      margin: 0 0 20px;
      font-size: 24px;
      font-weight: 600;
      color: #D4AF37;
    }
    p {
      margin: 0 0 20px;
      color: #b8b8b8;
      font-size: 16px;
    }
    .button {
      display: inline-block;
      padding: 16px 32px;
      background: linear-gradient(135deg, #D4AF37, #C5A028);
      color: #1a1a1a;
      text-decoration: none;
      border-radius: 8px;
      font-weight: 600;
      font-size: 16px;
      margin: 20px 0;
      box-shadow: 0 0 0 3px rgba(212,175,55,0.2);
    }
    .link-box {
      background: #1a1a1a;
      padding: 16px;
      border-radius: 8px;
      margin: 20px 0;
      word-break: break-all;
      font-size: 14px;
      color: #D4AF37;
      font-family: monospace;
    }
    .footer {
      padding: 30px;
      text-align: center;
      font-size: 14px;
      color: #666;
      border-top: 1px solid #3a3a3a;
    }
    .expire-notice {
      background: rgba(212,175,55,0.1);
      border-left: 3px solid #D4AF37;
      padding: 12px 16px;
      margin: 20px 0;
      font-size: 14px;
      color: #D4AF37;
    }
  </style>
</head>
<body>
  <div class='container'>
    <div class='header'>
      <div class='logo'>OM</div>
    </div>
    <div class='content'>
      <h1>{$t['greeting']}, $name!</h1>
      <p>{$t['intro']}</p>
      <p>{$t['instruction']}</p>
      <center>
        <a href='$verification_link' class='button'>{$t['button']}</a>
      </center>
      <p style='margin-top: 30px; font-size: 14px; color: #888;'>{$t['alt_text']}</p>
      <div class='link-box'>$verification_link</div>
      <div class='expire-notice'>{$t['expire']}</div>
    </div>
    <div class='footer'>
      <p>{$t['footer']}</p>
      <p style='margin-top: 10px;'>© " . date('Y') . " Office Manager. All rights reserved.</p>
    </div>
  </div>
</body>
</html>
  ";
  
  // Plain text version
  $text_body = "{$t['greeting']}, $name!\n\n";
  $text_body .= "{$t['intro']}\n\n";
  $text_body .= "{$t['instruction']}\n\n";
  $text_body .= "$verification_link\n\n";
  $text_body .= "{$t['expire']}\n\n";
  $text_body .= "{$t['footer']}\n\n";
  $text_body .= "© " . date('Y') . " Office Manager";
  
  // Email headers
  $headers = "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
  $headers .= "From: Office Manager <noreply@re-furnishbg.com>\r\n";
  $headers .= "Reply-To: support@re-furnishbg.com\r\n";
  $headers .= "X-Mailer: PHP/" . phpversion();
  
  // Send email
  $success = mail($to, $t['subject'], $html_body, $headers);
  
  // Log for debugging
  if (!$success) {
    error_log("Failed to send verification email to: $to");
  }
  
  return $success;
}

/**
 * Send password reset email
 * 
 * @param string $to Email address
 * @param string $name User name
 * @param string $reset_link Password reset URL
 * @param string $lang Language code
 * @return bool Success status
 */
function send_password_reset_email($to, $name, $reset_link, $lang = 'bg') {
  // TODO: Implement when needed
  return true;
}
