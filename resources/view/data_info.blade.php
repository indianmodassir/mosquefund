@php
use Modassir\Http\Model\RequestModal;

$refno = \trim($_POST['reference-number']);
$captcha = \trim($_POST['captcha']);

$session = session();
$refPattern = '/^(?:(REF[0-9]{11})|(MFCSR\/[0-9]{4}\/[0-9]{7}))/';
$expect_captcha = $session->get('captcha');
$error = false;

$session->put('ref-no', $refno);

if (empty($refno)) {
  $session->put('ref-error', 'Application Reference is Required!');
  header('location:/track?stage=data_input');
  exit;
}
if (!preg_match($refPattern, $refno)) {
  $session->put('ref-error', 'Invalid Reference Number');
  header('location:/track?stage=data_input');
  exit;
}

if (empty($captcha)) {
  $session->put('captcha-error', 'Captcha Field is Required!');
  header('location:/track?stage=data_input');
  exit;
}

if (decrypt($expect_captcha) !== $captcha) {
  $session->put('captcha-error', 'Invalid Captcha Code!');
  header('location:/track?stage=data_input');
  exit;
}

$modal = RequestModal::select('reqid', $refno);
if (!$modal) {
  $session->put('ref-error', 'Application Reference Not Found!');
  header('location:/track?stage=data_input');
  exit;
}

$error = null;
$message = 'Your secretary registration request has been sent to HOA Administrator.';
$verification = null;
$validation = null;
$completed = null;

date_default_timezone_set('Asia/Kolkata');
$forwarded_time = $modal->forwarded_time;
$approval_time = $modal->approval_time;
$time = time();

$forwarded_verification = $forwarded_time <= $time;
$forwarded_approval = $approval_time && $approval_time <= $time;
$field_verification = $modal->field_verification;
$approval = $modal->approval;

if ($forwarded_verification) {
  $verification = 1;
  $validation = $field_verification == "" ? "" : intval($field_verification != "");
  $message = 'Your registration request has been forwarded to field verification.';
  $error = $validation;

  if ($validation != "") {
    $message = 'Field verification has been completed, Forwarded to final approval.';
  }
}

if ($field_verification && $forwarded_approval) {
  $completed = $approval;
  $message = 'Final registration approval request is under process, Please check after few days.';
  $error = $completed;
  
  if ($approval != "") {
    if ($field_verification == 1 && $approval == 0) {
      $field_verification = 'Your secretary registration request has been rejected, Contact to administrator.';
      $error = 0;
    }
    $message = $approval == 1 ? 'Your secretary registration request has been approved. We delivered Login ID and Password in your mailbox.' : $field_verification;
  }
}
@endphp
<div class="status-output">
  <div class="stages">
    <div class="stage">
      <div class="round">
        <svg focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="CreateIcon"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34a.9959.9959 0 0 0-1.41 0l-1.83 1.83 3.75 3.75z"></path></svg>
      </div>
      <div class="tlabel">Draft</div>
    </div>
    <div class="stage s{{$verification}}">
      <div class="round">
        <svg viewBox="0 0 15 11" class="xpath" style="width:15px;height:11px;"><path class="a" d="M12,0,4,8ZM0,4,4,8Z" transform="translate(1.5 1.5)"></path></svg>
      </div>
      <div class="tlabel">Verification</div>
    </div>
    <div class="stage s{{$validation}}">
      <div class="round">
        <svg focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="SearchIcon"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14"></path></svg>
      </div>
      <div class="tlabel">Validation</div>
    </div>
    <div class="stage s{{$completed}}">
      <div class="round completed">
        <svg focusable="false" aria-hidden="true" viewBox="0 0 24 24" data-testid="ReplayIcon"><path d="M12 5V1L7 6l5 5V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8"></path></svg>
      </div>
      <div class="tlabel">Completed</div>
    </div>
  </div>
  <div class="response-text">
    <p class="err{{$error}}">{{$message}}</p>
  </div>
</div>