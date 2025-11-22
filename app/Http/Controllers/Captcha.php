<?php

namespace Modassir\Http\Controllers;

header('Content-Type: application/json');

class Captcha
{
  public function generate($request)
  {
    $captcha = \rand(111111, 999999);
    $request->session()->put('captcha', \encrypt($captcha));
    echo json_encode(['code' => $captcha]);
  }
}
?>