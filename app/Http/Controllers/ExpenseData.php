<?php

namespace Modassir\Http\Controllers;
use Modassir\Http\Request\Request;
use Modassir\Http\Model\Spent;
use Modassir\Http\Model\Owner;

class ExpenseData
{
  public function index(Request $request)
  {
    $data = $request->checkRequest(['number']);
    $Auth = new Login(false);
    $number = $data['number'];

    $Auth->checkEmptyField($number, 'Number', '#search');
    $request->validate(['number' => $number], '#search', 'Mobile Number');

    $secretary = Owner::select('number', $number);
    if (!$secretary) {
      $Auth->exportJSON('error', 'Mobile number not found!', '#search');
    }

    $expenses = Spent::findAll($number);

    $vars = [
      'fullname' => $secretary->fullname,
      'number' => $secretary->number,
      'district' => $secretary->district,
      'block' => $secretary->circle,
      'village' => $secretary->village,
      'collected' => $secretary->collected,
      'expenses' => $expenses->toArray()
    ];

    $total_expense = 0;
    foreach($vars['expenses'] as $expense) {
      $total_expense += (int)$expense['amount'];
    }

    $vars['total_expense'] = $total_expense;
    $vars['total_balance'] = $total_expense + \intval($vars['collected']);

    ob_start();
    \view('ExpenseRecord')->with($vars);
    $body = ob_get_clean();
    die(json_encode(['body' => $body, 'popup' => true]));
  }
}
?>