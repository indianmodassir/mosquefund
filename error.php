<?php
  require __DIR__.'/vendor/autoload.php';
  $code = http_response_code();
  $errors = [
    '404' => 'Page Not Found',
    '403' => 'Access Denied'
  ];
  $error = $errors[$code];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?=\sprintf('%s | %s', $code, $error);?></title>
  <style>
    * {
      padding: 0;
      margin: 0;
      box-sizing: border-box;
    }
    body {
      font-family: sans-serif;
      background: #f7f2f2;
      display: flex;
      height: 100vh;
      align-items: center;
      color: #a9a7a7;
      justify-content: center;
    }
  </style>
</head>
<body>
  <?php view('error')->with(['code' => $code, 'error' => $error]); ?>
</body>
</html>