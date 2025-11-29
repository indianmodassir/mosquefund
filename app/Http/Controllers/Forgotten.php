<?php

namespace Modassir\Http\Controllers;

use Modassir\Http\Request\Request;
use Modassir\Http\Model\Admin;
use Modassir\Http\Model\Owner;

class Forgotten
{
  const Models = [
    'admin' => Admin::class,
    'owner' => Owner::class
  ];

  public function index(Request $request)
  {
    $data = $request->all();
    $data['csrf'] = $data['csrf-token'];
    view('forgot')->with($data);
  }

  public function forgot(Request $req)
  {
    $request = $req->all();
    $loginId = \strtolower(\trim($request['login-id']));
    $request['auth_id'] = $loginId;

    $model = self::Models[$request['role']];
    $model = $model::select('email', $loginId);
    $Auth = new Login();

    $Auth->checkCSRF($request['csrf']);
    $Auth->checkEmptyField($loginId, 'Login ID', '#loginId');
    $Auth->checkEmptyField($request['captcha'], 'Captcha', '#captcha');
    $Auth->verifyCaptcha($request['captcha']);

    if (!$model) $Auth->exportJSON('error', 'Not Record Found!', '#loginId');

    $Auth->verifyLoginID($loginId, $model->email);
    $mailer = new SendOTP(false);

    if ($mailer->sendotp($req, false)) {
      $request['vid'] = sha1(\random_bytes(16));
      session()->put('vid', $request['vid'])->put('auth_id', $loginId);

      \ob_start();
      view('verify_otp')->with($request);
      $body = \ob_get_clean();
      die(\json_encode(['body' => $body]));
    }
  }

  public function resetPassword(Request $request)
  {
    $request = $request->all();
    $otp = $request['otp'];
    $Auth = new Login();

    $Auth->checkCSRF($request['csrf']);
    $Auth->checkEmptyField($otp, 'OTP', '#otp');
    $Auth->checkEmptyField($request['captcha'], 'Captcha', '#captcha');
    $Auth->verifyCaptcha($request['captcha']);

    $model = self::Models[$request['role']];
    $model = $model::select('otp', $otp);

    $session = session();
    $expect_email_verification_id = $session->get('vid');
    $expect_login_id = $session->get('auth_id');

    $email_id = $request['email-verification-id'];
    $login_id = $request['login-id'];

    if (!$model) {
      $Auth->exportJSON('error', 'Incorrect OTP.', '#otp');
    }

    if (!($expect_email_verification_id === $email_id && $expect_login_id === $login_id)) {
      $Auth->exportJSON('error', 'Illegal activity detected!', '#otp');
    }

    $session->forget(['vid', 'auth_id']);

    $token = \sprintf('%s|%s|%s', $email_id, $login_id, rand(111111, 999999));
    $request['vid_token'] = encrypt($token);

    \ob_start();
    view('new_password')->with($request);
    $body = \ob_get_clean();

    session()->put('vid-token', sha1($token));
    $model->otp = '';
    $model->save();
    die(\json_encode(['body' => $body]));
  }

  public function CreatePassword(Request $request)
  {
    $request = $request->all();
    $password = $request['password'];
    $conf_pass = $request['conf-password'];
    $Auth = new Login;

    $Auth->checkCSRF($request['csrf']);
    $Auth->checkEmptyField($password, 'Password', '#password');
    $Auth->checkEmptyField($conf_pass, 'Confirm password', '#confPass');
    $Auth->checkEmptyField($request['captcha'], 'Captcha', '#captcha');
    $Auth->verifyCaptcha($request['captcha']);

    if ($conf_pass !== $password) {
      $Auth->exportJSON('error', 'Confirm password does not match', '#confPass');
    }

    // Check Strong Password
    $passLen = strlen($password);
    if ($passLen < 6 || $passLen > 30) {
      $Auth->exportJSON('error', 'Password must be greater equal 6 and less than equal 30', '#password');
    }

    $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()-+=|\\;:\'"?\/<>,\[\]{}]).{6,}$/';
    if (!preg_match($pattern, $password)) {
      $Auth->exportJSON('error', 'Choose strong password [123@Pass] combination.', '#password');
    }

    $expect_vid_token = $request['vid-token'];
    $vid_token = session()->get('vid-token');

    if ($expect_vid_token && $vid_token &&
      sha1($expect_vid_token = \decrypt($expect_vid_token)) === $vid_token) {
      list($_, $email) = \preg_split('/\|/', $expect_vid_token);

      $model = self::Models[$request['role']];
      $model = $model::select('email', $email);
      $old_password = $model->password;

      if (\password_verify($password, $old_password)) {
        $Auth->exportJSON('error', 'You can not set old password!', '#password');
      }

      $model->password = \password_hash($password, PASSWORD_DEFAULT);
      $Auth->setLoginSession($model, $request['role']);
    } else {
      $Auth->exportJSON('error', 'Illegal activity detected!', '.status');
    }
  }
}
?>