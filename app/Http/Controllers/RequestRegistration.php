<?php

namespace Modassir\Http\Controllers;

use Modassir\Http\Request\Request;
use Modassir\Http\Model\RequestModal;
use Modassir\Http\Model\Owner;
use Lazervel\MailSender\MailSender;

header('Content-Type: application/json');

class RequestRegistration extends MailSender
{
  /**
   * 
   */
  public function index(Request $request)
  {
    date_default_timezone_set('Asia/Kolkata');
    $session = \session();
    $req = $request->all();
    $Auth = new Login(false);
    $expires = $session->get('expires');
    $time = time();

    $form_keys = ['fullname', 'number', 'email', 'district', 'circle', 'village', 'captcha'];
    foreach($form_keys as $key) {
      if (!isset($req[$key])) die(json_encode(['error'=> true, 'message' => 'Bad Request']));
    }

    $fullname = $req['fullname'];
    $number = $req['number'];
    $email = \trim($req['email']);
    $expect_email = $session->get('email_verified');
    $district = $req['district'];
    $circle = $req['circle'];
    $village = $req['village'];
    $csrf = $req['csrf'];

    // CSRF Validation
    $request->validate(['csrf' => $csrf], null);

    $data = [
      'Fullname' => $fullname,
      'Number' => $number,
      'Email address' => $email,
      'District' => $district,
      'Block' => $circle,
      'Village' => $village
    ];

    foreach($data as $label => $value) {
      $id = explode(' ', $label);
      $id = strtolower($id[0]);
      $Auth->checkEmptyField($value, $label, '#'.$id);
    }

    $request->validate(['username' => $fullname], '#fullname', 'Applicant name');
    $request->validate(['number' => $number], '#number', 'Mobile number');
    $request->validate(['email' => $email], '#email', 'Email address');
    $request->validate(['scalar' => $district], '#district', 'District');
    $request->validate(['scalar' => $circle], '#block', 'Block');
    $request->validate(['scalar' => $village], '#village', 'Village');

    if ($email && $email !== $expect_email) {
      $Auth->exportJSON('error', 'Email address not verified!', '#email');
    }
    
    if (!isset($req['declaration'])) {
      $Auth->exportJSON('error', 'Accept self Declaration.', '#declaration');
    }

    $Auth->checkEmptyField($req['captcha'], 'Captcha', '#captcha');
    $Auth->verifyCaptcha($req['captcha']);
    $this->checkExistsSecretary($Auth, $email, $number);

    // Check Session Expires
    if ($expires <= $time) {
      $Auth->exportJSON('error', 'Session Expired Re-Login!');
    }

    // Set Time rage current + 1 minute to current + 5 Hour
    $forward_time_range = rand($time + 60, $time + (60 * 60 * 5));

    $approval_date = date('d/m/Y');
    $working_date = 5;
    $day_index = 0;
    $day = 0;

    while($day <= $working_date) {
      $approval_date = date('d/m/Y D', strtotime(\sprintf('+%s days', $day_index)));
      $date_day = explode(' ', $approval_date); // 12/11/2020 Fri
      $approval_date = $date_day[0];
      if ($date_day[1] !== 'Fri') {
        $day++;
      }
      $day_index++;
    }

    $data['working_date'] = $working_date;
    $data['request_date'] = date('d/m/Y');
    $data['approval_date'] = $approval_date;
    $data['forwarded_time'] = $forward_time_range;
    $data['csrf'] = $csrf;
    $vars = [];

    foreach($data as $label => $value) {
      $label = \strtolower(str_replace(' ', '_', $label));
      $session->put('request_'.$label, \trim($value));
      $vars[$label] = \trim($value);
    }

    \ob_start();
    \view('RequestReview')->with($vars);
    $body = \ob_get_clean();
    die(\json_encode(['body' => $body]));
  }

  /**
   * 
   */
  public function edit(Request $request)
  {
    $session = \session();
    $vars = [
      'fullname' => '',
      'number' => '',
      'email_address' => '',
      'district' => '',
      'block' => '',
      'village' => '',
      'request_date' => '',
      'approval_date' => '',
      'forwarded_time' => '',
      'csrf' => ''
    ];

    foreach($vars as $label => $value) {
      $vars[$label] = $session->get('request_'.$label);
    }

    \ob_start();
    \view('RegForm')->with(['vars' => $vars]);
    $body = \ob_get_clean();

    die(\json_encode(['body' => $body]));
  }

  /**
   * 
   */
  public function verifyBox(Request $request)
  {
    $req = $request->all();
    $name = $req['name'];
    $email = \trim($req['email']);
    $request->validate(['email' => $email], '#email', 'Email address');
    $Auth = new Login(false);
    $session = \session();
    $verified_email = $session->get('email_verified');

    $this->checkExistsSecretary($Auth, $email);
    if ($verified_email && $verified_email === $email) $Auth->exportJSON('success', 'Already Verified');

    $otp = \rand(111111, 999999);
    \ob_start();
    view('mail.otp')->with(['role' => 'Secretary', 'otp' => $otp]);
    $body = \ob_get_clean();

    if ($this->mailTo($name, $email, 'OTP Verification', $body)->send()) {

      date_default_timezone_set('Asia/Kolkata');

      $session
        ->put('email_verification_code', \password_hash($otp, PASSWORD_BCRYPT))
        ->put('otp_validity', time() + (15 * 60)) // OTP Validity 15 minutes
        ->put('verification_email', $email);

      if ($req['printable']) {
        $req['message'] = 'OTP sent Successfully!';
      }

      // Convert Original email to Masked Email (e.g., indi**********@gmail.com)
      $explode_email = explode('@', $email);
      $name = $explode_email[0];
      $visible = substr($name, 0, 4);
      $masked = str_repeat('*', strlen($name) - 4);
      $explode_email[0] = $visible.$masked;
      $req['masked_email'] = implode('@', $explode_email);

      \ob_start();
      view('verifyBox')->with($req);
      $body = \ob_get_clean();
      die(\json_encode(['body' => $body]));
    } else {
      $Auth->exportJSON('error', 'Connection issue, Something went wrong!', '#email');
    }
  }

  public function verifyEmail(Request $request)
  {
    $session = session();
    $expect_otp = $session->get('email_verification_code');
    $otp_validity = $session->get('otp_validity');
    $email = $session->get('verification_email');

    $request = $request->all();
    $otp = $request['otp'];
    $Auth = new Login(false);
    
    date_default_timezone_set('Asia/Kolkata');
    $time = time();

    if ($otp_validity >= $time) {
      if ($expect_otp && \password_verify($otp, $expect_otp)) {
        $session->forget(['otp_validity', 'email_verification_code', 'verification_email']);
        $session->put('email_verified', $email);
        die(\json_encode(['success'=> true]));
      } else {
        $Auth->exportJSON('error', 'Invalid OTP!', '#verification_code');
      }
    } else {
      $session->forget(['verification_email']);
      $Auth->exportJSON('error', 'OTP Verification Expired!', '#verification_code');
    }
  }

  private function generateRequestID()
  {
    $random = rand(1111111,9999999);
    $year = date('Y');
    $uid = \sprintf('REF%s%s', $year, $random);
    $data = RequestModal::select('reqid', $uid);
    if ($data) {
      return $this->generateRequestID();
    }
    return $uid;
  }

  public function register(Request $request)
  {
    $Auth = new Login(false);
    $session = session();
    $data = ['uid' => $this->generateRequestID()];
    $expect_email = $session->get('email_verified');
    $keys = [];
    $vars = [
      'fullname',
      'number',
      'email_address',
      'district',
      'block',
      'village',
      'request_date',
      'approval_date',
      'forwarded_time',
      'csrf'
    ];

    foreach($vars as $label) {
      $key = 'request_'.$label;
      $keys[] = $key;
      $value = $session->get($key);
      $data[$label] = $value;
      if (!$value) {
        $Auth->exportJSON('error', 'Bad Request.');
      }
    }

    extract($data);

    // CSRF Validation
    $request->validate(['csrf' => $csrf], null);

    if ($expect_email !== $email_address) {
      $Auth->exportJSON('error', 'Bad Request.');
    }

    $this->checkExistsSecretary($Auth, $email_address, $number);

    // Extra security Dual Verification
    $reqModal = RequestModal::select('email', $email_address);
    $ownerData = Owner::select('email', $email_address);

    if ($reqModal || $ownerData) {
      $Auth->exportJSON('error', 'Email address aleady exists.', '#declaration');
    }
    // End

    $reqModal = new RequestModal();
    $reqModal->fullname = $fullname;
    $reqModal->number = $number;
    $reqModal->email = $email_address;
    $reqModal->district = $district;
    $reqModal->circle = $block;
    $reqModal->village = $village;
    $reqModal->reqid = $uid;
    $reqModal->request_date = $request_date;
    $reqModal->approval_date = $approval_date;
    $reqModal->forwarded_time = $forwarded_time;
    $reqModal->save(true);

    // forget form data from session
    $session->forget($keys);

    \ob_start();
    \view('mail.aknowledgement')->with([
      'applicant' => $fullname,
      'applyDate' => $request_date,
      'appRef' => $uid,
      'dueDate' => $approval_date,
      'state' => 2
    ]);
    $body = \ob_get_clean();
    $data['json'] = json_encode($data);
    
    if ($this->mailTo($fullname, $email_address, 'MFC Application Submission', $body)->send()) {
      \ob_start();
      \view('aknowledgement')->with($data);
      $body = \ob_get_clean();
      die(\json_encode(['body' => $body]));
    }
  }

  /**
   * @param string $email
   * @param string $number
   */
  private function checkExistsSecretary($Auth, string $email, ?string $number = null)
  {
    if ($number) {
      $req_number_exists = RequestModal::select('number', $number);
      if ($req_number_exists) $req_number_exists = $req_number_exists->approval == 0 ? false : true;
      if (Owner::select('number', $number) || $req_number_exists) {
        $Auth->exportJSON('error', 'Mobile number already exists.', '#number');
      }
    }

    $req_email_exists = RequestModal::select('email', $email);
    if ($req_email_exists) $req_email_exists = $req_email_exists->approval == 0 ? false : true;
    
    if (Owner::select('email', $email) || $req_email_exists) {
      $Auth->exportJSON('error', 'Email address already exists.', '#email');
    }
  }
}
?>