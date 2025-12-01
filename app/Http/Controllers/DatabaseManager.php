<?php

namespace Modassir\Http\Controllers;
use Modassir\Http\Request\Request;
use Modassir\Http\Model\Admin;
use Modassir\Http\Model\Spent;
use Modassir\Http\Model\RequestModal;

class DatabaseManager
{
  public function truncate(Request $request)
  {
    $data = $request->checkRequest(['table']);
    $Auth = new Login(false);
    $table = $data['table'];

    $admin = Admin::select('session', session()->get('logged_session'));

    if (!$admin) {
      $Auth->exportJSON('dberror', 'Unauthorized Administrator!');
    }

    $tables = [
      'request' => RequestModal::class,
      'spent' => Spent::class
    ];

    $db_table = $tables[$table] ?? null;
    if (!$db_table) {
      $Auth->exportJSON('dberror', 'Bad Request!');
    }

    if ((new $db_table)->truncate()) {
      die(json_encode(['message' => \sprintf('Table [%s] truncate successfully!', $table)]));
    }
  }
}
?>