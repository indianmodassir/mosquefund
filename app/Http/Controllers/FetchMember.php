<?php

namespace Modassir\Http\Controllers;

use Modassir\Http\Request\Request;
use Modassir\Http\Model\Admin;
use Modassir\Http\Model\Collector;
use Modassir\Http\Model\Member;
use Modassir\Http\Model\Owner;
use Modassir\Http\Model\MemberDetails;

class FetchMember
{
  public function fetch(Request $request, ?bool $isReciept = false, ?MemberDetails $member_details = null)
  {
    $req = $request->all();
    $fetch_type = $req['fetch_type'];
    $number = $req['uid'] ?? $req['member-id'] ?? null;

    $session = session();
    $optReqId = $session->get('opt_request_id');
    $optReqId = $optReqId ? \decrypt($optReqId) : '';

    $collector = Collector::select('session', $optReqId);
    $member = Member::select('number', $number);

    if (!$member) {
      $member = Member::select('number', $member_details->number);
    }

    if (!$member) {
      die(\json_encode([
        'error' => true,
        'message' => $isReciept ? 'FRN Not Found!' : 'Member Not Found!',
        'selector' => $isReciept ? '#frn' : '#memberId'
      ]));
    }

    $owner = Owner::select('number', $member->owner_id);
    $owner_email = $owner->email;
    $owner_number = $owner->number;

    if ($collector && $optReqId) {
      $owner = Owner::select('number', $collector->connect_id);
      $owner_email = $owner->email;
      $owner_number = $owner->number;

      // Member verification
      $owner_id = $owner->number;
      $connect_id = $collector->connect_id;
      $member_id = $member->owner_id ?? null;

      if (!(($owner_id == $connect_id) === ($connect_id == $member_id))) {
        return \view('layout.collector.MemberNotFound')->with(['uid'=>$number]);
      }
    } else {
      $optReqId = null;
    }

    if (!$member) {
      die(\json_encode([
        'error' => true,
        'message' => 'Member ID does not exists.',
        'selector' => '#memberId'
      ]));
    }

    $imageInfo = pathinfo($member->profile);
    $fileType = \sprintf('image/%s', $imageInfo['extension']);
    $imageData = file_get_contents($member->profile);
    $base64 = 'data:' . $fileType . ';base64,' . \base64_encode($imageData);
    $member->profile = $base64;

    if (!$member_details) {
      $member_details = MemberDetails::findAll($number)->toArray();
    } else {
      $member_details = [[
        'id' => $member_details->id,
        'number' => $member_details->number,
        'frn' => $member_details->frn,
        'year' => $member_details->year,
        'paid_from' => $member_details->paid_from,
        'paid_to' => $member_details->paid_to,
        'date' => $member_details->date,
        'paid_amount' => $member_details->paid_amount
      ]];
    }
    
    if ($fetch_type !== 'all') {
      $member_details = [\end($member_details)];
    }

    date_default_timezone_set('Asia/Kolkata');
    $month = $member->month_index + 1;

    $calculate_year = date('Y') - $member->year;
    $calculate_month = date('n') - $month;
    $year_of_month = 12;

    $isNextMonth = 0;

    if ($calculate_month === 0 && $calculate_year === 0) {
      $calculate_month++;
      $isNextMonth++;
    }

    $total_month = (int) ($calculate_month + ($year_of_month * $calculate_year));

    $date = new \DateTime($member->last_date);
    $date->modify(\sprintf('+%s month', $total_month));
    
    $data = [
      'accurate_due_month' => $total_month - $isNextMonth,
      'request_number' => $number,
      'authorized' => !!$optReqId,
      'owner_email' => $owner_email,
      'owner_number' => $owner_number,
      'member' => $member,
      'payments' => $member_details,
      'last_payment' => end($member_details),
      'nextDate' => $date,
      'dueMonth' => $total_month,
      'searchFn' => $optReqId ? 'closeModel' : 'login'
    ];

    // adm - Accurate Due Month
    $adm = $data['accurate_due_month'];
    $data['accurate_due_month'] = $adm <= 9 ? '0'.$adm : $adm;
    $data['dues'] = $adm * 100;

    // Do not show paid button if user already paid
    if (!$adm) $data['authorized'] = false;

    define('csrf', session()->get('CSRF-TOKEN'));
    \view('status')->with($data);
  }

  /**
   * 
   */
  public function confirm(Request $request)
  {
    $Auth = new Login(false);
    $req = $request->all();
    $req_keys = ['uid', 'csrf', 'due-month', 'due-fee', 'declaration'];
    
    foreach($req_keys as $key) {
      if (!isset($req[$key])) {
        $Auth->exportJSON('error', 'Bad Request.');
      }
    }

    $dueMonth = (int)$req['due-month'];
    $dueFee = (int)$req['due-fee'];
    $number = $req['uid'];
    $declaration = $req['declaration'] === 'on';

    if (!$declaration) {
      $Auth->exportJSON('error', 'Accept Terms & Conditions.', '#declaration');
    }

    if (!($dueMonth && $dueFee)) {
      $Auth->exportJSON('error', 'Invalid due Month or Fee!', '#declaration');
    }

    $collector = Collector::select('session', \session()->get('logged_session'));
    $member = Member::select('number', $number);

    if (!($member && $number && $collector)) {
      $Auth->exportJSON('error', 'Unauthorized Collector');
    }

    $date = new \DateTime($member->last_date);
    $prev_year = $member->year;
    $prev_last_paid_to = $member->last_paid_to;
    $date->modify(\sprintf('+%s month', $dueMonth));
    $year = $date->format('Y');

    $paid_data = json_decode($collector->paid_data, true);
    $last_collected = $collector->collected;
    $last_collected = (int)$last_collected + $dueFee;
    if (!in_array($number, $paid_data)) array_push($paid_data, $number);

    $owner_id_from_member = $member->owner_id;
    $secretray = Owner::select('number', $collector->connect_id);

    // Main Secretray and Collector relation verification
    if (!$secretray) {
      $Auth->exportJSON('error', 'Unauthorized Collector');
    }

    $secretray_number = $secretray->number;
    $all_collected = $secretray->collected;
    $all_collected = (int)$all_collected + $dueFee;

    // Main Secretray and Member relation verification
    if ($secretray_number != $owner_id_from_member) {
      $Auth->exportJSON('error', 'Unauthorized Collector');
    }

    date_default_timezone_set('Asia/Kolkata');
    $Admin = Admin::find(1);
    $frn = (int)$Admin->frn;

    // Update Secretary Details
    $secretray->collected = $all_collected;
    $secretray->save();

    // Update Collector Details
    $collector->collected = $last_collected;
    $collector->paid_data = json_encode($paid_data);
    $collector->collected_time = date('d-m-Y h:i:s A');
    $collector->save();

    $last_date = $date->format('d-m-Y h:i:s A');
    $last_paid_to = $date->format('d F Y');
    
    // Update Member Info
    $member->year = $year;
    $member->last_paid_from = $prev_last_paid_to;
    $member->last_paid_to = $last_paid_to;
    $member->last_date = $last_date;
    $member->last_paid_amount = $dueFee;
    $member->month_index = $date->format('n') - 1;
    $member->save();

    // Add Member Details
    $member_details = new MemberDetails;
    $frn++;
    $member_details->number = $number;
    $member_details->frn = 'FRN'.$frn;
    $member_details->year = $year;
    $member_details->paid_from = $prev_last_paid_to;
    $member_details->paid_to = $last_paid_to;
    $member_details->date = $last_date;
    $member_details->paid_amount = $dueFee;
    $member_details->save(true);
    
    // Update FRN Last Number
    $Admin->frn = $frn;
    $Admin->save();
    die(json_encode(['success'=> true]));
  }
}
?>