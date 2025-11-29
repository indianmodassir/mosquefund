<?php

use Modassir\Http\Route;
use Modassir\Http\Controllers\RequestRegistration;
use Modassir\Http\Controllers\GeneratePDF;
use Modassir\Http\Controllers\Logout;
use Modassir\Http\Controllers\Login;
use Modassir\Http\Controllers\Captcha;
use Modassir\Http\Controllers\Forgotten;
use Modassir\Http\Controllers\SendOTP;
use Modassir\Http\Controllers\Admin;
use Modassir\Http\Controllers\Registration;
use Modassir\Http\Controllers\Collector;
use Modassir\Http\Controllers\Owner;
use Modassir\Http\Controllers\MemberRegistration;
use Modassir\Http\Controllers\FetchMember;

require __DIR__.'/../config/app.php';

Route::post('/download', [GeneratePDF::class, 'recieptInfo']);
Route::post('/reciept', [GeneratePDF::class, 'recieptInfo']);
Route::post('/generatepdf', [GeneratePDF::class, 'generate']);
Route::post('/fetchmember', [FetchMember::class, 'fetch']);
Route::post('/confirm_payment', [FetchMember::class, 'confirm']);
Route::post('/logout', [Logout::class, 'logout']);

Route::group('/collector', function() {
  Route::get('dashboard', [Collector::class, 'index']);
  Route::get('find', [Collector::class, 'index']);
  Route::get('all', [Collector::class, 'index']);
  Route::get('expense_data', [Collector::class, 'index']);
});

Route::group('/admin', function() {
  Route::get('dashboard', [Admin::class, 'index']);
  Route::get('request', [Admin::class, 'index']);
  Route::get('final_request', [Admin::class, 'index']);
  Route::get('all_request', [Admin::class, 'index']);
  Route::get('manage', [Admin::class, 'index']);
  Route::get('create', [Admin::class, 'index']);
  Route::get('members', [Admin::class, 'index']);
  Route::get('view_profile', [Admin::class, 'index']);
  Route::post('enabled_disable', [Admin::class, 'manage']);
  Route::post('verify_field', [Admin::class, 'verifyField']);
  Route::post('final_verify', [Admin::class, 'finalVerification']);
});

Route::group('/owner', function() {
  Route::get('dashboard', [Owner::class, 'index']);
  Route::get('addmember', [Owner::class, 'index']);
  Route::get('addspend', [Owner::class, 'index']);
  Route::get('manage', [Owner::class, 'index']);
  Route::get('view_profile', [Owner::class, 'index']);
  Route::get('expense_data', [Owner::class, 'index']);
  Route::post('enable_disable', [Owner::class, 'manageCollectorLogin']);
  Route::post('delete', [Owner::class, 'deleteMember']);
  Route::post('spent', [Owner::class, 'addspend']);
});

Route::post('/registration1', [Registration::class, 'index']);
Route::post('/registration', [Registration::class, 'register']);
Route::post('/resendotp', [Registration::class, 'sendOTP']);
Route::post('/verifyotp', [Registration::class, 'verifyOTP']);

Route::group('/member', function() {
  Route::post('registration1', [MemberRegistration::class, 'index']);
  Route::post('registration', [MemberRegistration::class, 'register']);
});

Route::get('/captcha', [Captcha::class, 'generate']);
Route::post('/sendotp', [SendOTP::class, 'sendotp']);

Route::group('/forgot', function() {
  Route::get('admin', [Forgotten::class, 'index']);
  Route::get('owner', [Forgotten::class, 'index']);
  Route::post('admin', [Forgotten::class, 'forgot']);
  Route::post('owner', [Forgotten::class, 'forgot']);

  Route::post('reset/admin', [Forgotten::class, 'resetPassword']);
  Route::post('reset/owner', [Forgotten::class, 'resetPassword']);

  Route::post('reset/newpassword/admin', [Forgotten::class, 'CreatePassword']);
  Route::post('reset/newpassword/owner', [Forgotten::class, 'CreatePassword']);
});

Route::group('/login', function() {
  Route::post('admin', [Login::class, 'AdminLogin']);
  Route::post('owner', [Login::class, 'OwnerLogin']);
  Route::post('collector', [Login::class, 'CollectorLogin']);
  Route::post('member', [Login::class, 'MemberLogin']);
  // Route::post('reciept', [Login::class, 'recieptInfo']);
});

Route::post('/request_registration', [RequestRegistration::class, 'index']);
Route::post('/final_request', [RequestRegistration::class, 'register']);
Route::post('/verify_email', [RequestRegistration::class, 'verifyEmail']);
Route::post('/mail_verification_box', [RequestRegistration::class, 'verifyBox']);
Route::get('/edit_registration', [RequestRegistration::class, 'edit']);
?>