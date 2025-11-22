<?php
ob_start();

require __DIR__.'/vendor/autoload.php';

$time = time() + (25 * 60); // 25 Minute Session
$csrf = sha1(random_bytes(16));

$session = session();
$session->put('XRF-TOKEN', $csrf)->put('expires', $time);
$session->forget([
  'email_verified',
  'label_fullname',
  'label_number',
  'label_email_address',
  'label_district',
  'label_block',
  'label_village',
  'label_request_date',
  'label_approval_date',
  'label_forwarded_time',
  'label_csrf'
]);

$url = \sprintf('location: RegForm?csrf=%s&expires=%s', $csrf, $time);
header($url);
exit;
?>