<?php

use Modassir\Session\Session;
use Modassir\View\View;

require __DIR__.'/../../config/app.php';

date_default_timezone_set('Asia/Kolkata');

if (!\function_exists('encrypt')) {
  function encrypt($data) {
    return @cryptor->encrypt($data);
  }
}

if (!\function_exists('decrypt')) {
  function decrypt($data) {
    return @cryptor->decrypt($data);
  }
}

if (!\function_exists('session')) {
  function session() {
    return new Session;
  }
}

if (!\function_exists('verify_encryption')) {
  function verify_encryption($plain, $encrypted) {
    return @cryptor->verify($plain, $encrypted);
  }
}

if (!\function_exists('verify_captcha')) {
  function verify_captcha(string $captcha) {
    return @cryptor->verify($captcha, session()->get('captcha'));
  }
}

if (!\function_exists('view')) {
  function view(string $blade) {
    return new View($blade);
  }
}

if (!\function_exists('getenv')) {
  function getenv($varname) {
    return $_ENV[$varname];
  }
}

?>