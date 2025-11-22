<?php

namespace Modassir\Http\Controllers;

use Modassir\Http\Request\Request;
use Modassir\Middleware\AuthGuard;
use Modassir\Http\Model\Admin;
use Modassir\Http\Model\Owner;
use Modassir\Http\Model\Collector;
use Modassir\Http\Model\MemberDetails;
use Modassir\Http\Model\Member;
use Lazervel\MailSender\MailSender;

class MemberRegistration extends MailSender
{
  /**
   * GET Handler for Component loads
   */
  public function index(Request $request)
  {
    $genders = ['', 'Male', 'Female', 'Other'];
    $data = $request->all();
    $Auth = new Login(false);
    $session_id = session()->get('logged_session');
    $model = Owner::select('session', $session_id);
    $owner_id = $model->number;

    if (!$model) {
      $Auth->exportJSON('error', 'Illegal activity detected!', '.status');
    }

    $Auth->checkEmptyField($data['fullname'], 'Fullname', '#fullname');
    $request->validate(['username' => $data['fullname']], '#fullname', 'Applicant name');
    $Auth->checkEmptyField($data['number'], 'Number', '#number');
    $request->validate(['number' => $data['number']], '#number', 'Mobile number');

    $data['number'] = \trim($data['number']);
    $model = Member::select('number', $data['number']);

    if ($model) {
      $Auth->exportJSON('error', 'Mobile number already exists.', '#number');
    }

    $Auth->checkEmptyField($data['profile']['name'], 'Upload profile', '#profile');
    $Auth->checkEmptyField($data['amount'], 'Paid Amount', '#amount');
    $request->validate(['amount' => $data['amount']], '#amount', 'Amount');
    $Auth->checkEmptyField($data['village'], 'Village', '#village');
    $request->validate(['scalar' => $data['village']], '#village', 'Village');

    $genderIndex = $data['gender'];
    $gender = $genders[$genderIndex] ?? '';

    if (!$gender) {
      $Auth->exportJSON('error', 'Select your gender.', '#gender');
    }

    if (!isset($data['declaration'])) {
      $Auth->exportJSON('error', 'Accept self Declaration.', '#declaration');
    }

    $Auth->checkEmptyField($data['captcha'], 'Captcha', '#captcha');
    $Auth->verifyCaptcha($data['captcha']);
    
    $session = session();
    $session_id = $session->id();
    $data['session_id'] = $session_id;
    $json = \json_encode($data);

    $fileData = $data['profile'];
    $fileTmp = $fileData['tmp_name'];
    $fileType = $fileData['type'];
    $type = \preg_split('/\//', $fileType)[1];

    $imageData = file_get_contents($fileTmp);
    $base64 = 'data:' . $fileType . ';base64,' . \base64_encode($imageData);

    $session
      ->put('session_id', $session_id)
      ->put('form-data', \encrypt($json))
      ->put('fullname', $data['fullname'])
      ->put('number', $data['number'])
      ->put('profile', $base64)
      ->put('regdate', date('d/m/Y'))
      ->put('type', '.'.$type)
      ->put('image_data', $imageData)
      ->put('amount', $data['amount'])
      ->put('gender', $gender)
      ->put('village', $data['village']);

    $data['owner_id'] = $owner_id;

    \ob_start();
    view('layout.owner.review')->with($data);
    $body = \ob_get_clean();
    die(\json_encode(['body' => $body]));
  }

  /**
   * POST Handler for Final Registration
   */
  public function register(Request $request)
  {
    header('Content-Type: application/json');

    $session = session();
    $url = $session->get('redirect_url');
    $role = substr($url, 1);

    $model = Owner::select('session', $session->get('logged_session'));

    if (!($model && $role === 'owner')) {
      $Auth->exportJSON('error', 'Illegal activity detected!', '.status');
    }

    $secretray_number = $model->number;
    $collector = Collector::select('connect_id', $secretray_number);
    $paid_data = json_decode($collector->paid_data, true);

    $owner_number = $model->number;
    $session->put('role', $role);
    $Auth = new Login(false);
    $Admin = Admin::find(1);

    $frn = (int)$Admin->frn;
    $num_frn = $frn + 1;

    $frn = \sprintf('FRN%s', $num_frn);
    $Admin->frn = $num_frn;

    $filename = '';
    $fullname = $session->get('fullname');
    $number = $session->get('number');
    $amount = $session->get('amount');
    $gender = $session->get('gender');
    $village = $session->get('village');
    
    if (($filename = $request->putFile($session->get('image_data'), $session->get('type')))) {

      date_default_timezone_set('Asia/Kolkata');
      $date = new \DateTime();
      $date->modify('-1 month');

      $last_paid_from = $date->format('d F Y');
      $last_paid_to = date('d F Y');
      $last_date = date('d-m-Y h:i:s A');
      $monthIndex = date('n') - 1;

      // Overall collection money in Secretary
      $overall_collected = $model->collected;
      $model->collected = (int) $overall_collected + (int) $amount;
      $model->save();

      $member = new Member;
      $member->fullname = ucwords($fullname);
      $member->number = $number;
      $member->profile = $filename;
      $member->village = ucwords($village);
      $member->year = date('Y');
      $member->last_paid_from = $last_paid_from;
      $member->last_paid_to = $last_paid_to;
      $member->last_date = $last_date;
      $member->last_paid_amount = (int)$amount;
      $member->month_index = $monthIndex;
      $member->gender = $gender;
      $member->owner_id = $owner_number;
      $member->save();

      $info = new MemberDetails;
      $info->number = $number;
      $info->frn = $frn;
      $info->year = date('Y');
      $info->paid_from = $last_paid_from;
      $info->paid_to = $last_paid_to;
      $info->date = $last_date;
      $info->paid_amount = (int)$amount;
      $info->save(true);
      $Admin->save();

      array_push($paid_data, $number);
      $last_collected = $collector->collected;
      
      $collector->paid_data = json_encode($paid_data);
      $collector->collected = (int) $last_collected + (int) $amount;
      $collector->save();

      \ob_start();
      view('success')->with(
        \array_merge([], $_SESSION, ['role' => $role, 'controller' => $model->fullname])
      );
      $body = \ob_get_clean();

      die(\json_encode(['body' => $body]));
    }
  }
}
?>