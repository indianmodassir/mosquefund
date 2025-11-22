<?php

namespace Modassir\Http\Controllers;

use Modassir\Http\Request\Request;
use Modassir\Middleware\AuthGuard;
use Modassir\Http\Model\Admin;
use Modassir\Http\Model\Owner;
use Modassir\Http\Model\Collector;
use Modassir\Http\Model\RequestModal;
use Lazervel\MailSender\MailSender;

class Registration extends MailSender
{
  /**
   * GET Handler for Component loads
   */
  public function index(Request $request)
  {
    $data = $request->all();
    $Auth = new Login(false);
    $session_id = session()->get('logged_session');

    $model = Admin::select('session', $session_id);

    if (!$model) {
      $Auth->exportJSON('error', 'Illegal activity detected!', '.status');
    }

    $fullname = $data['fullname'];
    $number   = $data['number'];
    $email    = $data['email'];
    $district = $data['district'];
    $block    = $data['circle'];
    $village  = $data['village'];

    $Auth->checkEmptyField($fullname, 'Fullname', '#fullname');
    $Auth->checkEmptyField($number, 'Number', '#number');
    $Auth->checkEmptyField($email, 'Email address', '#email');
    $Auth->checkEmptyField($district, 'Distirct', '#district');
    $Auth->checkEmptyField($block, 'Block', '#block');
    $Auth->checkEmptyField($village, 'Village', '#village');
    $request->validate(['username' => $fullname], '#fullname', 'Applicant name');
    $request->validate(['number' => $number], '#number', 'Mobile number');
    $request->validate(['email' => $email], '#email', 'Email address');
    $request->validate(['scalar' => $district], '#district', 'District');
    $request->validate(['scalar' => $block], '#block', 'Block');
    $request->validate(['scalar' => $village], '#village', 'Village');

    if (!isset($data['declaration'])) {
      $Auth->exportJSON('error', 'Accept self Declaration.', '#declaration');
    }

    $Auth->checkEmptyField($data['captcha'], 'Captcha', '#captcha');
    $Auth->verifyCaptcha($data['captcha']);

    $number = \trim($number);
    $email = \strtolower(\trim($email));

    $owner = new Owner;
    $req_number_exists = RequestModal::select('number', $number);
    $req_email_exists = RequestModal::select('email', $email);

    if ($req_number_exists) {
      $req_number_exists = $req_number_exists->approval == 0 ? false : true;
    }
    
    if ($req_email_exists) {
      $req_email_exists = $req_email_exists->approval == 0 ? false : true;
    }

    if ($owner::select('number', $number) || $req_number_exists) {
      $Auth->exportJSON('error', 'Mobile number already exists.', '#number');
    }
    
    if ($owner::select('email', $email) || $req_email_exists) {
      $Auth->exportJSON('error', 'Email address already exists.', '#email');
    }

    $session_id = session()->id();
    $data['session_id'] = $session_id;
    $json = \json_encode($data);

    $session = session();
    $data['collector_id'] = \rand(11111111, 99999999);

    $session
      ->put('session_id', $session_id)
      ->put('form-data', \encrypt($json))
      ->put('fullname', $fullname)
      ->put('number', $number)
      ->put('email', $email)
      ->put('regdate', date('d/m/Y'))
      ->put('district', $district)
      ->put('circle', $block)
      ->put('village', $village)
      ->put('address', $data['address'])
      ->put('collector_id', $data['collector_id']);

    \ob_start();
    view('review')->with($data);
    $body = \ob_get_clean();
    die(\json_encode(['body' => $body]));
  }

  /**
   * 
   */
  public function sendOTP($printable = true)
  {
    $otp = \rand(111111, 999999);
    $session = \session();
    $name = $session->get('fullname');
    $email = $session->get('email');
    $session->put('otp', $otp);
    $Auth = new Login(false);

    \ob_start();
    view('mail.otp')->with($_SESSION);
    $body = \ob_get_clean();

    if ($this->mailTo($name, $email, 'OTP Verification', $body)->send()) {
      $session->put('otp', (string)\encrypt($otp));
      return $printable ? $Auth->exportJSON('success', 'OTP Sent Successfully!', '.status') : true;
    } else {
      $Auth->exportJSON('error', 'Something went wrong?', '.status');
    }
  }

  /**
   * POST Handler for Final Registration
   */
  public function register(Request $request)
  {
    header('Content-Type: application/json');

    $session = session();
    $url = $session->get('redirect_url');
    $session->put('role', substr($url, 1));
    $Auth = new Login(false);
    
    if ($this->sendOTP(false)) {
      \ob_start();
      view('layout.verify_otp');
      $body = \ob_get_clean();
      die(\json_encode(['body' => $body]));
    } else {
      $Auth->exportJSON('error', 'Something went wrong?', '.status');
    }
  }

  /**
   * OTP verification for registration
   */
  public function verifyOTP(Request $request)
  {
    $session = session();
    $fullname = ucwords($session->get('fullname'));
    $email = $session->get('email');
    $email = \strtolower(\trim($email));
    $number = \trim($session->get('number'));
    $district = ucwords(\trim($session->get('district')));
    $circle = ucwords(\trim($session->get('circle')));
    $village = ucwords(\trim($session->get('village')));
    $address = \trim($session->get('address'));
    $collector_id = $session->get('collector_id');

    $password = \strtoupper(\substr(\trim($fullname), 0, 4)).rand(1111, 9999);
    $expect_otp = \decrypt($session->get('otp'));
    $data = \decrypt($session->get('form-data'));
    $data = json_decode($data, true);
    
    $Auth = new Login(false);
    $Admin = Admin::select('session', $session->get('logged_session'));

    $url = $session->get('redirect_url');
    $role = substr($url, 1);

    if (!($Admin && $role === 'admin')) {
      $Auth->exportJSON('error', 'Illegal activity detected!', '.status');
    }

    $request = $request->all();
    $otp = $request['otp'];
    
    $Auth->checkEmptyField($request['otp'], 'OTP', '#otp');
    $Auth->checkEmptyField($request['captcha'], 'Captcha', '#captcha');
    $Auth->verifyCaptcha($request['captcha']);

    $data['collector_id'] = $collector_id;
    $data['password'] = $password;
    $data['role'] = $role;
    $data['controller'] = $Admin->fullname;

    if ($otp == $expect_otp) {

      \ob_start();
      view('mail.registration')->with($data);
      $body = \ob_get_clean();

      if ($this->mailTo($fullname, $email, 'Secretary Registration', $body)->send()) {
        $owner = new Owner;
        $owner->fullname = $fullname;
        $owner->email = $email;
        $owner->number = $number;
        $owner->district = $district;
        $owner->circle = $circle;
        $owner->village = $village;
        $owner->address = $address;
        $owner->collector_id = $collector_id;
        $owner->password = \password_hash($password, PASSWORD_DEFAULT);
        $owner->save();

        date_default_timezone_set('Asia/Kolkata');
        $collector = new Collector;
        $collector->login_code = $collector_id;
        $collector->connect_id = $number;
        $collector->collected_time = date('d-m-Y h:i:s A');
        $collector->save();

        \ob_start();
        view('success')->with($data);
        $body = \ob_get_clean();

        die(\json_encode(['body' => $body]));
      } else {
        $Auth->exportJSON('error', 'Something went wrong?', '.status');
      }
    } else {
      $Auth->exportJSON('error', 'Invalid OTP', '#otp');
    }
  }
}
?>