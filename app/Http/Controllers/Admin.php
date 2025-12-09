<?php

namespace Modassir\Http\Controllers;

use Modassir\Http\Request\Request;
use Modassir\Http\Model\RequestModal;
use Modassir\Http\Model\Owner;
use Modassir\Http\Model\Collector;
use Modassir\Http\Model\Member;
use Modassir\Http\Model\Admin as Administrator;
use Lazervel\MailSender\MailSender;

class Admin extends MailSender
{
  public $owner;
  public $collector;
  public $member;

  public function __construct()
  {
    $this->owner = Owner::all()->toArray();
    $this->collector = Collector::all()->toArray();
    $this->member = Member::all()->toArray();
    parent::__construct();
  }

  /**
   * 
   */
  public function index(Request $request)
  {
    $session = \session();
    $admin = Administrator::select('session', $session->get('logged_session'));
    if (!$admin) {
      die('<h1 class="not-found">Unauthorized Administrator!</h1>');
    }

    $request = $request->all();
    $request['owner'] = $this->owner;
    $request['collector'] = $this->collector;
    $request['member'] = $this->member;
    $component = $request['component'];

    if (!$request['editable']) session()->forget([
      'session_id',
      'form-data',
      'fullname',
      'number',
      'email',
      'district',
      'circle',
      'village',
      'address',
      'regdate',
      'collector_id'
    ]);

    $pattern = '/^(?:request|final_request|all_request|dashboard)$/';

    $isForwarded = false;
    $isFinal = false;

    $rejected = 0;
    $pending = 0;
    $all_request = 0;
    $delivered = 0;

    if (\preg_match($pattern, $component)) {
      date_default_timezone_set('Asia/Kolkata');
      $modal = RequestModal::all()->toArray();
      $request['requests'] = $modal;
      $time = time();
      $request['time'] = $time;

      foreach($modal as $data) {
        $approval_date = str_replace('/', '-', $data['approval_date']);
        $approval_timestamp = strtotime($approval_date);

        if ($data['approval'] == 0) {
          $rejected++;
        } else if ($data['approval'] == 1) {
          $delivered++;
        } else if ($approval_timestamp <= $time) {
          $pending++;
        } else {
          $all_request++;
        }

        if ($data['forwarded_time'] <= $time && $data['field_verification'] === "") {
          $isForwarded = true;
        }
        if (($data['approval_time'] &&
        ($data['approval_time'] <= $time)) && $data['approval'] === "") {
          $isFinal = true;
        }
      }

      $request['rejected'] = $rejected;
      $request['request'] = $all_request;
      $request['pending'] = $pending;
      $request['delivered'] = $delivered;

      $request['isForwarded'] = $isForwarded;
      $request['isFinal'] = $isFinal;
    }

    if ($component === 'view_profile') {
      $request = ['fullname' => $admin->fullname, 'email' => $admin->email];
    }

    view(\sprintf('layout.admin.%s', $component))->with($request);
  }

  /**
   * 
   */
  private function content(string $error)
  {
    die(\sprintf('<h1 class="not-found" style="font-size:20px;margin:22px 0;">%s</h1><button type="button" id="btnSearch" onclick="closeModel()" style="font-size:12px;height:33px;">CANCEL</button>', $error));
  }

  /**
   * 
   */
  public function manage(Request $request)
  {
    $request = $request->all();
    $session = session();
    $authorized_owner = Administrator::select('session', $session->get('logged_session'));

    if (!$authorized_owner) {
      $this->content('Session Expired Re-login');
    }

    $disabled = $request['disabled'];
    $uid = $request['uid']; // owner id
    $owner = Owner::select('number', $uid);
    $success = \json_encode(['success' => true]);

    if (!$owner) {
      $this->content(\sprintf('Owner ID [%s] Not Found!', $uid));
    }

    $expect_disabled = $owner->disabled;
    $disabled = $disabled === 'true' ? 1 : 0;

    header('Content-Type: application/json');
    if ($expect_disabled === $disabled) {
      die($success);
    }

    $owner->access = !$disabled;
    $owner->disabled = $disabled;
    $owner->save();
    die($success);
  }

  public function verifyField(Request $request)
  {
    $Auth = new Login(false);
    $admin = Administrator::select('session', session()->get('logged_session'));

    if (!$admin) {
      $Auth->exportJSON('error', 'Unauthorized Administrator!');
    }

    $req = $request->all();
    $field_verification = $req['field-verified'];
    $reason = $req['reason'];
    $number = $req['number'];
    
    if ($field_verification == 0) $field_verification = $reason;
    $field_verification = ucwords(strtolower($field_verification));
    $modal = RequestModal::select('number', $number);

    if (!$modal) {
      $Auth->exportJSON('error', 'Applicant already Verified!');
    }

    date_default_timezone_set('Asia/Kolkata');
    $time = time();

    // Set Time range current + 1 minute to current + 2 days
    $time_range = rand($time + 60, $time + ((60 * 60 * 24) * 2));

    $modal->field_verification = $field_verification;
    $modal->approval_time = $time_range;
    $modal->save();

    die(\json_encode(['success' => true]));
  }

  public function finalVerification(Request $request)
  {
    $Auth = new Login(false);
    $admin = Administrator::select('session', session()->get('logged_session'));

    if (!$admin) {
      $Auth->exportJSON('error', 'Unauthorized Administrator!');
    }

    $req = $request->all();
    $approval_status = (int)$req['final-status'];
    $number = $req['number'];
    $modal = RequestModal::select('number', $number);

    if (!$modal) {
      $Auth->exportJSON('error', 'Applicant already Finalized!');
    }

    $fullname = ucwords($modal->fullname);
    $email = $modal->email;
    $number = $modal->number;
    $district = ucwords($modal->district);
    $circle = ucwords($modal->circle);
    $village = ucwords($modal->village);
    $approved = false;

    $random_char = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
    $password = substr($random_char, 0, 8);

    // For Approved
    if ($approval_status === 1) {

      $collector_id = \rand(11111111, 99999999);
      $data = ['email' => $email, 'password' => $password];
      $approved = true;

      $owner = new Owner;
      $owner->fullname = $fullname;
      $owner->email = $email;
      $owner->number = $number;
      $owner->district = $district;
      $owner->circle = $circle;
      $owner->village = $village;
      $owner->address = \sprintf('VILLAGE: %s, POST: %s, DISTRICT: %s', $village, $circle, $district);
      $owner->collector_id = $collector_id;
      $owner->password = \password_hash($password, PASSWORD_DEFAULT);
      $owner->save();

      date_default_timezone_set('Asia/Kolkata');
      $collector = new Collector;
      $collector->login_code = $collector_id;
      $collector->connect_id = $number;
      $collector->collected_time = date('d-m-Y h:i:s A');
      $collector->save();
    }

    \ob_start();
    \view('mail.aknowledgement')->with([
      'applicant' => $fullname,
      'applyDate' => $modal->request_date,
      'appRef' => $modal->reqid,
      'dueDate' => $modal->approval_date,
      'userId' => $email,
      'password' => $password,
      'state' => $approval_status
    ]);
    $body = \ob_get_clean();

    if ($this->mailTo($fullname, $email, 'MFC Registration', $body)->send()) {
      // Update Final Status
      $modal->approval = $approval_status;
      $modal->save();
      die(\json_encode(['success' => true]));
    }
  }
}
?>