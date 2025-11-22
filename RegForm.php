<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#0171E0"/>
  <title>Secretary Registration</title>
  <link rel="shortcut icon" href="resources/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="resources/css/style.css">
  <link rel="stylesheet" href="resources/css/admin.css">
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
<body style="background:#eee;">
  <!-- Login Dialogs -->
  <dialog id="popupUI">
    <div class="response"></div>
    <div class="loader">
      <svg viewBox="0 0 19 19" fill="none" class="motion-safe:animate-spin icon-lg"><path d="M9.5 2.9375V5.5625M9.5 13.4375V16.0625M2.9375 9.5H5.5625M13.4375 9.5H16.0625" stroke="currentColor" stroke-width="1.875" stroke-linecap="square"></path><path d="M4.86011 4.85961L6.71627 6.71577M12.2847 12.2842L14.1409 14.1404M4.86011 14.1404L6.71627 12.2842M12.2847 6.71577L14.1409 4.85961" stroke="currentColor" stroke-width="1.875" stroke-linecap="square"></path></svg>
    </div>
  </dialog>
  <div id="xcontent">
    <?php
      require __DIR__.'/vendor/autoload.php';
      $data = \array_merge(['vars' => $vars ?? []], $_GET);
      view('RegForm')->with($data);
    ?>
  </div>
<script src="resources/js/App.js"></script>
<script>generateCaptcha();</script>
</body>
</html>