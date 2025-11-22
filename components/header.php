<?php
ob_start();

use Modassir\Middleware\AuthGuard;
require __DIR__.'/../vendor/autoload.php';
$auth_guard = new AuthGuard;

define('csrf', sha1(random_bytes(16)));
session()->put('CSRF-TOKEN', csrf);

$response_code = http_response_code();
if ($response_code === 403) {
  header('location: /');
  die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#0171E0"/>
  <title><?=getenv('APP_NAME')?></title>
  <link rel="shortcut icon" href="resources/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="resources/css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vkbd@1.0.1/lib/vkbd.min.css">
  <script src="resources/js/jquery.js"></script>
  <script src="resources/js/provider.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vkbd@1.0.1/lib/vkbd.min.js"></script>
  <script>
    let kbdUI = new vkbd({
      lang: 'hi',      // 'hi' or 'en'
      theme: 'light',  // e.g, 'light', 'dark', 'system'
      themeVariant: 1, // 1-3
    });
  </script>
</head>
<body>
  <!-- Login Dialogs -->
  <dialog id="popupUI">
    <div class="response"></div>
    <div class="loader">
      <svg viewBox="0 0 19 19" fill="none" class="motion-safe:animate-spin icon-lg"><path d="M9.5 2.9375V5.5625M9.5 13.4375V16.0625M2.9375 9.5H5.5625M13.4375 9.5H16.0625" stroke="currentColor" stroke-width="1.875" stroke-linecap="square"></path><path d="M4.86011 4.85961L6.71627 6.71577M12.2847 12.2842L14.1409 14.1404M4.86011 14.1404L6.71627 12.2842M12.2847 6.71577L14.1409 4.85961" stroke="currentColor" stroke-width="1.875" stroke-linecap="square"></path></svg>
    </div>
  </dialog>

  <!-- Nav Bar -->
  <nav>
    <div class="logo">
      <img src="resources/assets/logo.png" alt="logo" width="100" height="100" draggable="false">
    </div>
    <div class="header-text">
      <div class="upper-text">
        <h1><?=$_ENV['APP_NAME']?></h1>
      </div>
      <div class="lower-text">
        <strong>Digital manage of monthly mosque donations fund. / مسجد کی خدمت اور دیکھ بھال کے لیے ماہانہ چندے کا ڈیجیٹل انتظام</strong>
      </div>
    </div>
  </nav>
<?=$auth_guard->optRender()?>