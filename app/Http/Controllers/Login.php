<?php

namespace Modassir\Http\Controllers;

use Modassir\Http\Controllers\FetchMember;
use Modassir\Http\Request\Request;
use Modassir\Http\Controllers\Captcha;
use Modassir\Http\Model\Admin;
use Modassir\Http\Model\Owner;
use Modassir\Http\Model\Collector;
use Modassir\Http\Model\Member;
use Modassir\Http\Model\MemberDetails;
use Modassir\Middleware\AuthGuard;

class Login extends Captcha
{
  private $exports = [];
  private $request;

  /**
   * Developer Login
   */
  public function AdminLogin(Request $request)
  {
    $validation = $request;
    $request = $request->all();
    $this->checkData(['login-id', 'password', 'captcha'], $request);
    $loginId = \strtolower(\trim($request['login-id']));
    $admin = Admin::find(1);

    $this->checkCSRF($request['csrf'] ?? $request['csrf-token']);
    $this->checkEmptyField($request['login-id'], 'Login ID', '#loginId');
    $validation->validate(['email' => $request['login-id']], '#loginId', 'Login ID');
    $this->checkEmptyField($request['password'], 'Password', '[name=password]');
    $this->checkEmptyField($request['captcha'], 'Captcha', '#captcha');
    $this->verifyCaptcha($request['captcha']);
    $this->verifyLoginID($loginId, $admin->email);
    
    if ($request['password'] == $admin->otp) {
      $admin->otp = '';
    } else {
      $this->verifyPassword($request['password'], $admin->password);
    }
    
    $this->setLoginSession($admin, 'admin');
  }

  /**
   * 
   */
  public function setLoginSession($model, $role)
  {
    $pool = sha1(\sprintf('%s|%s', $model->email, sha1(\random_bytes(16))));
    session()->put('logged_session', $pool)->put('redirect_url', '/'.strtolower($role));
    $model->session = $pool;
    $model->save();
    $this->exportJSON('success', 'Logged in Successful');
  }

  /**
   * Owner Login
   */
  public function OwnerLogin(Request $request)
  {
    $validation = $request;
    $request = $request->all();
    $this->checkData(['login-id', 'password', 'captcha'], $request);
    $loginId = \strtolower(\trim($request['login-id']));
    $owner = Owner::select('email', $loginId);

    $this->checkCSRF($request['csrf'] ?? $request['csrf-token']);
    $this->checkEmptyField($request['login-id'], 'Login ID', '#loginId');
    $validation->validate(['email' => $request['login-id']], '#loginId', 'Login ID');
    $this->checkEmptyField($request['password'], 'Password', '[name=password]');
    $this->checkEmptyField($request['captcha'], 'Captcha', '#captcha');
    $this->verifyCaptcha($request['captcha']);

    if (!$owner) {
      $this->exportJSON('error', 'Login ID doesn not exists.', '#loginId');
    }

    $this->verifyLoginID($loginId, $owner->email);
    
    if ($request['password'] == $owner->otp) {
      $owner->otp = '';
    } else {
      $this->verifyPassword($request['password'], $owner->password);
    }

    if ($owner->disabled) {
      $this->exportJSON('error', 'Your account has been disabled. Contact head Administrator.', '#loginId');
    }
    
    $this->setLoginSession($owner, 'owner');
  }

  /**
   * Collector Login
   */
  public function CollectorLogin(Request $request)
  {
    $validation = $request;
    $request = $request->all();
    $this->checkData(['login-code', 'captcha'], $request);
    $loginCode = \strtolower(\trim($request['login-code']));
    $collector = Collector::select('login_code', $loginCode);
    $owner = Owner::select('collector_id', $loginCode);

    $this->checkCSRF($request['csrf'] ?? $request['csrf-token']);
    $this->checkEmptyField($loginCode, 'Login Code', '#loginCode');
    $validation->validate(['loginCode' => $loginCode], '#loginCode', 'Login Code');
    $this->checkEmptyField($request['captcha'], 'Captcha', '#captcha');
    $this->verifyCaptcha($request['captcha']);

    if (!($collector && $owner)) {
      $this->exportJSON('error', 'Login Code doesn\'t exists.', '#loginCode');
    }

    if (!$owner->access) {
      $this->exportJSON('error', 'Your login has been disabled by the Secretary.', '#loginCode');
    }

    $pool = sha1(\sprintf('%s|%s', \session()->id(), sha1(\random_bytes(16))));
    session()->put('logged_session', $pool)->put('redirect_url', '/collector');
    $collector->session = $pool;
    $collector->save();
    $this->exportJSON('success', 'Logged in Successful');
  }

  /**
   * Member Login
   */
  public function MemberLogin(Request $request)
  {
    $req = $request->all();
    $this->checkData(['captcha'], $req);
    $isReceipt = $req['reciept'] ?? null;
    $memberId = $req['member-id'] ?? $req['frn'];
    
    $this->checkCSRF($req['csrf'] ?? $req['csrf-token']);
    $this->checkEmptyField($memberId, $isReceipt ? 'FRN' : 'Member ID', $isReceipt ? '#frn' : '#memberId');
    $this->checkEmptyField($req['captcha'], 'Captcha', '#captcha');
    $this->verifyCaptcha($req['captcha']);

    if (!$isReceipt) {
      $request->validate(['number' => $memberId], '#memberId', 'Member ID');
    }

    $fetchMember = new FetchMember();
    $member = MemberDetails::select('frn', $memberId);

    if (!$member && $isReceipt) {
      $this->exportJSON('error', 'FRN Not Found!', '#frn');
    }

    \ob_start();
    $fetchMember->fetch($request, $isReceipt, $member);
    $body = \ob_get_clean();

    die(\json_encode(['body' => $body, 'notCaptcha' => true]));
  }

  /**
   * @param string $password
   * @param string $hash
   */
  public function verifyPassword(string $password, $hash)
  {
    if (!\password_verify($password, $hash)) {
      $this->exports['reset'] = true;
      $this->exportJSON('error', 'Incorrect Password!', '[name=password]');
    }
  }

  /**
   * @param string $captcha
   */
  public function verifyCaptcha(string $captcha)
  {
    if (!verify_captcha($captcha)) {
      $this->exportJSON('error', 'Invalid Captcha', '#captcha');
    }
  }

  /**
   * @param string $value
   * @param string $name
   * @param string $selector
   */
  public function checkEmptyField($value, $name, $selector)
  {
    if (empty($value)) {
      $this->exportJSON('error', \sprintf('%s Field is Required!', $name), $selector);
    }
  }

  /**
   * @param array $keys
   * @param \Modassir\Http\Request $request
   */
  private function checkData(array $keys, $request)
  {
    foreach($keys as $key) {
      if (!isset($request[$key])) die(json_encode(['error' => true, 'message' => 'Bad Request']));
    }
  }

  /**
   * @param string $status
   * @param string $message
   * @param string $selector
   */
  public function exportJSON(string $status, string $message, ?string $selector = null)
  {
    header('Content-Type: application/json');
    $this->exports[$status] = true;
    $this->exports['message'] = $message;
    $this->exports['selector'] = $selector;
    die(json_encode($this->exports));
  }

  /**
   * @param string $id
   * @param string $expect_id
   */
  public function verifyLoginID($id, $expect_id)
  {
    if ($id !== $expect_id) {
      $this->exportJSON('error', 'Login ID doesn\'t exists.', '#loginId');
    }
  }

  public function checkCSRF(string $csrf, string $matches = '')
  {
    $expect_csrf = session()->get('CSRF-TOKEN');
    if ($matches) {
      if ($csrf !== $matches) {
        $this->exportJSON('error', 'Page Expired!');
      }
    }
    else if ($expect_csrf !== $csrf) {
      $this->exportJSON('error', 'Page Expired!');
    }
  }
}
?>