<?php

namespace Modassir\Http\Controllers;

use Lazervel\MailSender\MailSender;
use Modassir\Http\Model\Admin;
use Modassir\Http\Model\Owner;

header('Content-Type: application/json');

class SendOTP extends MailSender
{
  private $groups = [
    'admin' => Admin::class,
    'owner' => Owner::class
  ];

  public function sendotp($request, bool $printable = true)
  {
    $request = $request->all();
    $loginId = $request['login-id'];
    $role = $request['role'];

    $type = $this->groups[\strtolower($role)];
    $data = $type::select('email', $loginId);

    if (empty($loginId)) {
      $this->exports('error', 'Login ID is required!', '#loginId');
    }

    if ($data && $data->email === $loginId) {
      $otp = \rand(111111, 999999);
      $request['otp'] = $otp;

      \ob_start();
      view('mail.otp')->with($request);
      $body = \ob_get_clean();

      if ($this->mailTo($data->fullname, $data->email, 'OTP Verification', $body)->send()) {

        $data->otp = $otp;
        $data->save();

        return $printable ? $this->exports('success', 'OTP Sent Successfully!', '.status') : true;
      } else {
        $this->exports('error', 'Something went wrong?', '.status');
      }
    } else {
      $this->exports('error', 'Invalid Login ID', '#loginId');
    }
  }

  private function exports($status, $responseText, ?string $field = null)
  {
    die(\json_encode([
      'status' => $status,
      'response' => $responseText,
      'field' => $field
    ]));
  }
}
?>