<?php

namespace Modassir\Http\Controllers;
use Modassir\Http\Request\Request;

header('Content-Type: application/json');

class Logout
{
  public function logout(Request $request)
  {
    session()->flush();
    die(\json_encode(['logged_out'=> true]));
  }
}
?>