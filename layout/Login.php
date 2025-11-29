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
    return '<div class="icon">
      <svg width="22" height="22" viewBox="0 0 24 24" style="fill:currentColor;transform: ;msFilter:;"><path d="M12 2a5 5 0 1 0 5 5 5 5 0 0 0-5-5zm0 8a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm9 11v-1a7 7 0 0 0-7-7h-4a7 7 0 0 0-7 7v1h2v-1a5 5 0 0 1 5-5h4a5 5 0 0 1 5 5v1z"></path></svg>
    </div>';
  }

  protected static function KeyIcon()
  {
    return '<div class="icon">
      <svg width="22" height="22" viewBox="0 0 24 24" style="fill:currentColor;transform: ;msFilter:;"><path d="M7 17a5.007 5.007 0 0 0 4.898-4H14v2h2v-2h2v3h2v-3h1v-2h-9.102A5.007 5.007 0 0 0 7 7c-2.757 0-5 2.243-5 5s2.243 5 5 5zm0-8c1.654 0 3 1.346 3 3s-1.346 3-3 3-3-1.346-3-3 1.346-3 3-3z"></path></svg>
    </div>';
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
    return '<div class="icon">
      <svg width="22" height="22" viewBox="0 0 24 24" style="fill:currentColor;transform: ;msFilter:;"><path d="M20 8H8l1.212-3.03a2 2 0 0 0-1.225-2.641l-.34-.113a.998.998 0 0 0-1.084.309L2.231 7.722a1.001 1.001 0 0 0-.231.64V19a2 2 0 0 0 2 2h7.21a2 2 0 0 0 1.987-1.779L14 12h6a2 2 0 0 0 0-4z"></path></svg>
    </div>';
  }

  protected static function RecieptIcon()
  {
    return '<div class="icon">
      <svg width="22px" height="22px" viewBox="0 0 24 24" fill="none"><path fill="currentColor" fill-rule="evenodd" d="M3 5a3 3 0 0 1 3-3h12a3 3 0 0 1 3 3v16a1 1 0 0 1-1.625.78l-1.929-1.542-2.391 1.594a1 1 0 0 1-1.18-.051L12 20.28l-1.875 1.5a1 1 0 0 1-1.18.051l-2.391-1.594-1.93 1.543A1 1 0 0 1 3 21V5zm5 1a1 1 0 0 0 0 2h8a1 1 0 1 0 0-2H8zm0 4a1 1 0 1 0 0 2h8a1 1 0 1 0 0-2H8zm0 4a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2H8z" clip-rule="evenodd"/></svg>
    </div>';
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
              <svg class="preloader" viewBox="0 0 19 19" fill="none"><path d="M9.5 2.9375V5.5625M9.5 13.4375V16.0625M2.9375 9.5H5.5625M13.4375 9.5H16.0625" stroke="currentColor" stroke-width="1.875" stroke-linecap="square"></path><path d="M4.86011 4.85961L6.71627 6.71577M12.2847 12.2842L14.1409 14.1404M4.86011 14.1404L6.71627 12.2842M12.2847 6.71577L14.1409 4.85961" stroke="currentColor" stroke-width="1.875" stroke-linecap="square"></path></svg>
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
          <button type="button" id="otpSender" onclick="sendOTP()" style="display:flex;align-items:center;justify-content:center;column-gap:6px;">
            <svg class="preloader" viewBox="0 0 19 19" fill="none"><path d="M9.5 2.9375V5.5625M9.5 13.4375V16.0625M2.9375 9.5H5.5625M13.4375 9.5H16.0625" stroke="currentColor" stroke-width="1.875" stroke-linecap="square"></path><path d="M4.86011 4.85961L6.71627 6.71577M12.2847 12.2842L14.1409 14.1404M4.86011 14.1404L6.71627 12.2842M12.2847 6.71577L14.1409 4.85961" stroke="currentColor" stroke-width="1.875" stroke-linecap="square"></path></svg>
          <span>Get OTP</span>
          </button>
          <div class="status"></div>
        </div>
      </div>',
      '<svg width="18" height="18" viewBox="0 0 24 24" style="fill:currentColor;transform: ;msFilter:;"><path d="m13 16 5-4-5-4v3H4v2h9z"></path><path d="M20 3h-9c-1.103 0-2 .897-2 2v4h2V5h9v14h-9v-4H9v4c0 1.103.897 2 2 2h9c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2z"></path></svg>
      <span>LOG IN</span>',
      '<div class="field" style="justify-content:center;flex-direction:row;">
        <a data-action="/forgot/'.\strtolower($role).'" onclick="forgotPassword(this)">Forgot Password?</a>
      </div>'
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
      '<svg width="18" height="18" viewBox="0 0 24 24" style="fill:currentColor;transform: ;msFilter:;"><path d="m13 16 5-4-5-4v3H4v2h9z"></path><path d="M20 3h-9c-1.103 0-2 .897-2 2v4h2V5h9v14h-9v-4H9v4c0 1.103.897 2 2 2h9c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2z"></path></svg>
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
      '<svg width="20px" height="20px" viewBox="0 0 24 24" fill="currentColor" style="transform:rotateY(180deg)">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M3.3572 3.23397C3.66645 2.97447 4.1014 2.92638 4.45988 3.11204L20.7851 11.567C21.1426 11.7522 21.3542 12.1337 21.322 12.5351C21.2898 12.9364 21.02 13.2793 20.6375 13.405L13.7827 15.6586L10.373 22.0179C10.1828 22.3728 9.79826 22.5789 9.39743 22.541C8.9966 22.503 8.65762 22.2284 8.53735 21.8441L3.04564 4.29872C2.92505 3.91345 3.04794 3.49346 3.3572 3.23397ZM5.67123 5.99173L9.73507 18.9752L12.2091 14.361C12.3304 14.1347 12.5341 13.9637 12.7781 13.8835L17.7518 12.2484L5.67123 5.99173Z" fill="currentColor"/>
      </svg>
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
      '<svg width="20px" height="20px" viewBox="0 0 24 24" fill="currentColor" style="transform:rotateY(180deg)">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M3.3572 3.23397C3.66645 2.97447 4.1014 2.92638 4.45988 3.11204L20.7851 11.567C21.1426 11.7522 21.3542 12.1337 21.322 12.5351C21.2898 12.9364 21.02 13.2793 20.6375 13.405L13.7827 15.6586L10.373 22.0179C10.1828 22.3728 9.79826 22.5789 9.39743 22.541C8.9966 22.503 8.65762 22.2284 8.53735 21.8441L3.04564 4.29872C2.92505 3.91345 3.04794 3.49346 3.3572 3.23397ZM5.67123 5.99173L9.73507 18.9752L12.2091 14.361C12.3304 14.1347 12.5341 13.9637 12.7781 13.8835L17.7518 12.2484L5.67123 5.99173Z" fill="currentColor"/>
      </svg>
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
      '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
      <span>DOWNLOAD</span>'
    );
  }
}

echo $role::Form();
?>