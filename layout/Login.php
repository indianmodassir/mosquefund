<?php
session_start();

$expect_csrf = $_SESSION['CSRF-TOKEN'] ?? '';

$roles = [
  'admin' => Admin::class,
  'owner' => Owner::class,
  'collector' => Collector::class,
  'member' => Member::class,
  'reciept' => Reciept::class,
  'download' => Download::class
];

if (!(isset($_SESSION['CSRF-TOKEN'], $_GET['csrf'], $_GET['role'], $roles[$_GET['role']]) && hash_equals($expect_csrf, $_GET['csrf']))) {
  die('Bad Request');
}

$role = $roles[$_GET['role']];

define('csrf', $expect_csrf);

class Form
{
  protected static function UserIcon()
  {
    return '<div class="icon"><i class="fa fa-user-o"></i></div>';
  }

  protected static function KeyIcon()
  {
    return '<div class="icon"><i class="fa fa-key"></i></div>';
  }

  protected static function EyeIcon()
  {
    return '<div class="icon icon-eye" style="right:0;left:unset;" onclick="togglePassword(this)">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye-off"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
    </div>';
  }

  protected static function PointerIcon()
  {
    return '<div class="icon"><i class="fa fa-hand-o-right"></i></div>';
  }

  protected static function RecieptIcon()
  {
    return '<div class="icon"><i class="fa fa-receipt"></i></div>';
  }

  protected static function Create(string $url, string $role, string $data, string $btnText, ?string $forgetLink = null)
  {
    $header = $role === 'RECIEPT DETAILS' || $role === 'DOWNLOAD RECIEPT' ? '%s' : '%s Login';
    return sprintf('<div id="content">
      <div class="header">
        <button type="button" class="close" onclick="closeModel()" style="box-shadow:none!important;">
          <span aria-hidden="true">×</span>
        </button>
        <h4>'.$header.'</h4>
      </div>
      <div class="form-container">
        <form action="%s" onsubmit="submitLoginForm(event)">
          <input type="hidden" name="role" id="role" value="'.($role === "secretary" ? "owner" : $role).'" autocomplete="off">
          <input type="hidden" name="csrf-token" id="csrfToken" value="'.@csrf.'" autocomplete="off">
          %s
          <div class="group" style="align-items:center;">
            <div class="captcha">
              <span>
                <canvas height="40" width="170"></canvas>
                <img src="resources/assets/refresh_icon.png" draggable="false" alt="Refresh" style="cursor:pointer" onclick="generateCaptcha()">
              </span>
            </div>
            <div class="captcha-input" style="position:relative;">
              <input type="text" name="captcha" id="captcha" placeholder="Enter Captcha" autocomplete="off">
              '.self::PointerIcon().'
              <div class="error"></div>
            </div>
          </div>
          <div class="field last-field" style="flex-direction:row;">
            <button style="display:flex;justify-content:center;align-items:center;column-gap:8px;">
              <img class="preloader" src="/resources/assets/loader.gif" draggable="false" alt="loader" width="17px">
              %s
            </button>
          </div>
          %s
        </form>
      </div>
    </div>', $role, $url, $data, $btnText, $forgetLink);
  }
}

class AdminOwner extends Form
{
  static function Component(string $role)
  {
    return self::Create(
      \sprintf('/login/%s', \strtolower($role)),
      $role === 'Owner' ? 'secretary' : $role,
      '<div class="field">
        <input type="text" name="login-id" id="loginId" placeholder="Login ID" autocomplete="on">
        '.self::UserIcon().'
        <div class="error"></div>
      </div>
      <div class="group" style="align-items:center;justify-content:start;">
        <div class="field" style="max-width:240px;">
          <input type="password" data-type="password" name="password" placeholder="OTP/Password" autocomplete="off">
          '.self::KeyIcon().'
          '.self::EyeIcon().'
          <div class="error"></div>
        </div>
        <div class="field" style="column-gap:0;width:auto;min-width:120px;">
          <button type="button" id="otpSender" onclick="sendOTP()" style="display:flex;align-items:center;justify-content:center;column-gap:6px;width:fit-content;padding:0 15px;">
            <img class="preloader" src="/resources/assets/loader.gif" draggable="false" alt="loader" width="17px">
            <i class="fa fa-arrow-rotate-right"></i>
            <span>Get OTP</span>
          </button>
          <div class="status"></div>
        </div>
      </div>',
      '<i class="fa fa-sign-in" style="font-size:15px;"></i>
      <span>LOG IN</span>',
      '<div class="field" style="justify-content:center;flex-direction:row;">
        <a data-action="/forgot/'.\strtolower($role).'" onclick="forgotPassword(this)">Forgot Password?</a>
      </div>'
      .($role === 'Owner' ?
        '<div class="field" style="justify-content:center;flex-direction:row;">
        <a href="/Reg8Yecd" target="_blank">Create Secretary Account</a>
      </div>' : '')
    );
  }
}

class Admin extends AdminOwner
{
  static function Form()
  {
    return self::Component('Admin');
  }
}

class Owner extends AdminOwner
{
  static function Form()
  {
    return self::Component('Owner');
  }
}

class Collector extends Form
{
  static function Form()
  {
    return self::Create(
      '/login/collector',
      'Collector',
      '<div class="field">
        <input type="text" name="login-code" id="loginCode" placeholder="Login Code" autocomplete="off">
        '.self::UserIcon().'
        <div class="error"></div>
      </div>',
      '<i class="fa fa-arrow-right-to-bracket" style="font-size:15px;"></i>
      <span>LOG IN</span>'
    );
  }
}

class Member extends Form
{
  static function Form()
  {
    return self::Create(
      '/login/member',
      'Member',
      '<div class="field">
        <input type="hidden" name="fetch_type" value="all" autocomplete="off" />
        <input type="text" name="member-id" id="memberId" placeholder="Member ID/Mobile Number" autocomplete="off">
        '.self::UserIcon().'
        <div class="error"></div>
      </div>',
      '<i class="fa fa-floppy-o" style="font-size:15px;"></i>
      <span>GET DETAILS</span>'
    );
  }
}

class Reciept extends Form
{
  static function Form()
  {
    return self::Create(
      '/reciept',
      'RECIEPT DETAILS',
      '<div class="field">
        <input type="hidden" name="reciept" value="1" autocomplete="off" />
        <input type="hidden" name="fetch_type" value="self" autocomplete="off" />
        <input type="hidden" name="response_type" value="1" autocomplete="off" />
        <input type="text" name="frn" id="frn" placeholder="FRN100310180359017" autocomplete="off">
        '.self::RecieptIcon().'
        <div class="error"></div>
      </div>',
      '<i class="fa fa-location-arrow"></i>
      <span>GET DETAILS</span>'
    );
  }
}

class Download extends Form
{
  static function Form()
  {
    return self::Create(
      '/download',
      'DOWNLOAD RECIEPT',
      '<div class="field">
        <input type="hidden" name="reciept" value="1" autocomplete="off" />
        <input type="hidden" name="fetch_type" value="self" autocomplete="off" />
        <input type="hidden" name="response_type" value="0" autocomplete="off" />
        <input type="text" name="frn" id="frn" placeholder="FRN100310180359017" autocomplete="off">
        '.self::RecieptIcon().'
        <div class="error"></div>
      </div>',
      '<i class="fa fa-download"></i>
      <span>DOWNLOAD</span>'
    );
  }
}

echo $role::Form();
?>