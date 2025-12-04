<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#0171E0"/>
  <title>Secretary Registration</title>
  <link rel="shortcut icon" href="resources/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="/resources/css/font-awesome.min.css">
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
      <i class="fa fa-spinner fa-spin fa-5x ploading"></i>
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