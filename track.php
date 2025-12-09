<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Track Registration Status</title>
  <link rel="shortcut icon" href="resources/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="/resources/css/font-awesome.min.css">
  <link rel="stylesheet" href="/resources/css/style.css">
  <link rel="stylesheet" href="/resources/css/status.css">
  <script src="/resources/js/jquery.js"></script>
  <script src="/resources/js/provider.js"></script>
</head>
<body style="display:flex;flex-direction:column;background:#eee;padding:11px;" class="track-status">
  <?php
    require 'vendor/autoload.php';
    if (!isset($_GET['stage'])) {
      die('<h1 class="not-found">Bad Request!</h1>');
    }
    view('data_input')->with(\array_merge([], $_GET, $_POST));
    session()->forget(['captcha-error', 'ref-error', 'ref-no']);
  ?>
</body>
</html>