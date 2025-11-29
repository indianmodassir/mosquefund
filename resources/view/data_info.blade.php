@php
use Modassir\Http\Model\RequestModal;

$refno = \trim($_POST['reference-number']);
$captcha = \trim($_POST['captcha']);

$session = session();
$refPattern = '/MFCSR\/[0-9]{4}\/[0-9]{7}/';
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

$status = [
  [
    'task' => 'Application Submission',
    'details' => 'Form Details',
    'issued' => 'Aknowledgement and Application Form',
    'status' => 'Completed',
    'remarks' => 'N/A'
  ],
  [
    'task' => 'Print Online Form Details',
    'details' => 'N/A',
    'issued' => 'Print Form Details',
    'status' => 'Forwarded',
    'remarks' => 'N/A'
  ]
];

date_default_timezone_set('Asia/Kolkata');
$forwarded_time = $modal->forwarded_time;
$approval_time = $modal->approval_time;
$time = time();

$forwarded_verification = $forwarded_time <= $time;
$forwarded_approval = $approval_time && $approval_time <= $time;
$field_verification = $modal->field_verification;
$approval = $modal->approval;

$field_verified = $field_verification == 1;
$field_rejected = !($field_verified || $field_verification == "");

if ($forwarded_verification) {
  \array_push($status, [
    'task' => 'Field Verification for Secretary Registration',
    'details' => 'N/A',
    'issued' => $field_verification == "" ? 'Under Process' : 'Nil',
    'status' => 'Forwarded',
    'remarks' => $field_rejected ? '<a popovertarget="infoBox" onclick="showReason()">View</a>' : 'N/A'
  ]);
}

if ($field_verification) {
  \array_push($status, [
    'task' => $field_rejected ? 'Approval of Rejected False Application' : 'Approval of Verified True Application',
    'details' => 'N/A',
    'issued' => $approval === '' ? 'Under Process' : ($field_rejected || $approval == 0 ? '<a onclick="showReason(true)">Rejected Details</a>' : 'Nil'),
    'status' => $approval === '' ? 'N/A' : ($field_rejected || $approval == 0 ? 'Rejected' : 'Delivered'),
    'remarks' => 'N/A'
  ]);
}
@endphp
<div id="infoBox" style="outline:none;border:1px solid #a5a5a5ff;" popover>
  <div style="background:#eee;padding:4px 11px;text-align:end;color:#595757;">
    <svg style="cursor:pointer;" onclick="$('#infoBox')[0].hidePopover()" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
  </div>
  <div style="padding:11px;max-width:300px;">
    <div id="rejected">{{$field_verification}}</div>
  </div>
</div>
<table class="final-info details tracker" style="margin-top:22px;">
  <tr>
    <td>Application Reference Number :</td>
    <td>{{$modal->reqid}}</td>
  </tr>
  <tr>
    <td>Name of the Service :</td>
    <td>Secretary Registration at Administrator level</td>
  </tr>
  <tr>
    <td>Administrator Name :</td>
    <td>Indian Modassir</td>
  </tr>
  <tr>
    <td>Applicant Name :</td>
    <td>{{$modal->fullname}}</td>
  </tr>
  <tr>
    <td>Application due Date :</td>
    <td>{{$modal->approval_date}}</td>
  </tr>
  <tr>
</table>
<div style="margin-top:22px;font-weight:500;font-size:15px;">Status Application Details / स्थिति आवेदन विवरण</div>
<table class="final-info" style="margin-top:8px;">
  <tr>
    <th>S.No.</th>
    <th>Task Name</th>
    <th>Form Details</th>
    <th>Issued Service</th>
    <th>Status</th>
    <th>Remarks</th>
  </tr>
  @foreach($status as $i => $data)
  <tr>
    <td>{{$i + 1}}</td>
    <td>{{$data['task']}}</td>
    <td>{{$data['details']}}</td>
    <td>{{$data['issued']}}</td>
    <td>{{$data['status']}}</td>
    <td>{{$data['remarks']}}</td>
  </tr>
  @endforeach
</table>
<div style="font-size:15px;margin-top:11px;">Showing 1 to {{count($status)}} of 4 entries</div>
<script>
  let textBackup;
  function showReason(rejected) {
    if (rejected) {
      if (!textBackup) textBackup = $('#rejected').text();
      $('#rejected').text('ADMINISTRATOR (INDIAN MODASSIR) DVARA AAPKA REGISTRATION REQUEST REJECT KIYA JA CHUKA HAI. AAVEDAK DUBARA REGISTRATION KAR SAKTA HAI.');
    } else if (textBackup) {
      $('#rejected').text(textBackup);
    }
    $('#infoBox')[0].showPopover();
  }
</script>