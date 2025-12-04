<?php

namespace Modassir\Http\Controllers;

use Modassir\Http\Request\Request;
use Modassir\Http\Model\MemberDetails;
use Modassir\Http\Model\Member;
use Modassir\Http\Model\Owner;

class GeneratePDF
{
  public function recieptInfo(Request $request)
  {
    $data = $request->all();
    $response_type = $data['response_type'];
    $frn = $data['frn'];
    $captcha = $data['captcha'];
    $Auth = new Login(false);

    $Auth->checkEmptyField($frn, 'FRN', '#frn');
    $Auth->checkEmptyField($captcha, 'Captcha', '#captcha');
    $Auth->verifyCaptcha($captcha);

    $reciept = MemberDetails::select('frn', $frn);

    if (!$reciept) {
      $Auth->exportJSON('error', 'FRN Not Found!', '#frn');
    }

    $number = $reciept->number;
    $member = Member::select('number', $number);
    $owner = Owner::select('number', $member->owner_id);

    $last_date = $member->last_date;

    $date = new \DateTime($last_date);
    $timezone = new \DateTimeZone('Asia/Kolkata');
    $date->setTimezone($timezone);
    $offset = $date->format('P'); // Output: +05:30

    $timestamp = \preg_replace('/-/', '.', $last_date).' '.$offset;
    $last_date = explode(' ', $last_date);
    $last_date = \preg_replace('/-/', '/', $last_date[0]);

    $profile_url = $member->profile;
    $imageData = file_get_contents($profile_url);
    $info = getimagesize($profile_url);
    $fileType = $info['mime'];
    $base64 = 'data:' . $fileType . ';base64,' . \base64_encode($imageData);

    $date = new \DateTime($member->last_date);
    $month = $date->format('n');
    $calculate_year = date('Y') - $member->year;
    $calculate_month = date('n') - $month;
    $year_of_month = 12;

    $total_month = (int) ($calculate_month + ($year_of_month * $calculate_year));
    $dues = $total_month * 100;
    
    $recieptInfo = [
      'frn' => \strtoupper($frn),
      'profile' => $base64,
      'fullname' => $member->fullname,
      'from' => $reciept->paid_from,
      'to' => $reciept->paid_to,
      'dues' => $dues,
      'paid' => $member->last_paid_amount,
      'number' => $number,
      'district' => $owner->district,
      'circle' => $owner->circle,
      'village' => $owner->village,
      'signature' => $owner->fullname,
      'contact' => $owner->number,
      'place' => $member->village,
      'date' => $last_date,
      'timestamp' => $timestamp,
      'domain' => sprintf('https://%s', $_SERVER['HTTP_HOST']),
      'preview' => !!$response_type,
      'download' => true
    ];

    if ($response_type) {
      $recieptInfo['html'] = '<div id="content" style="margin:33px auto;max-width:1120px;"><div class="header"><button type="button" class="close" onclick="closeModel()"><span aria-hidden="true">×</span></button><h4>RECIEPT DETAILS</h4></div><div class="form-container" style="background:#eee;padding:33px;text-align:center;"><img id="reciept_preview" alt="Reciept Preview" draggable="false" style="width:100%;max-width:980px;"></div></div>';
    }

    die(\json_encode($recieptInfo));
  }

  public function generate(Request $request)
  {
    $data = $request->all();
    $base64 = preg_replace('#^data:image/\w+;base64,#i', '', $data['image']);
    $imageData = base64_decode($base64);

    // PNG size lena (without saving)
    // $img = imagecreatefromstring($imageData);
    // $width = imagesx($img);
    // $height = imagesy($img);
    // imagedestroy($img);

    // Width/height from JS
    $width = (int)$data['width'];
    $height = (int)$data['height'];

    // Convert pixels → points
    $widthPt  = $width * 0.75;
    $heightPt = $height * 0.75;

    // PDF banana (raw syntax)
    $pdfContent = "%PDF-1.3
    1 0 obj <</Type /Catalog /Pages 2 0 R>> endobj
    2 0 obj <</Type /Pages /Kids [3 0 R] /Count 1>> endobj
    3 0 obj <</Type /Page /Parent 2 0 R /Resources <</XObject <</Im0 4 0 R>>>> /MediaBox [0 0 $widthPt $heightPt] /Contents 5 0 R>> endobj
    4 0 obj <</Type /XObject /Subtype /Image /Width $width /Height $height /ColorSpace /DeviceRGB /BitsPerComponent 8 /Filter /DCTDecode /Length ".strlen($imageData).">> stream
    ".$imageData."
    endstream endobj
    5 0 obj <</Length 50>> stream
    q
    $widthPt 0 0 $heightPt 0 0 cm
    /Im0 Do
    Q
    endstream endobj
    xref
    0 6
    0000000000 65535 f 
    0000000010 00000 n 
    0000000070 00000 n 
    0000000136 00000 n 
    0000000283 00000 n 
    0000000".(283 + strlen($imageData) + 100)." 00000 n 
    trailer <</Root 1 0 R /Size 6>>
    startxref
    ".(283 + strlen($imageData) + 250)."
    %%EOF";

    // Send as downloadable PDF
    $filename = $data['frn'];
    header("Content-Type: application/pdf");
    header("Content-Disposition: attachment; filename=\"{$filename}\"");
    echo $pdfContent;
  }
}
?>