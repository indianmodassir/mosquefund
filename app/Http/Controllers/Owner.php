<?php

namespace Modassir\Http\Controllers;

use Modassir\Http\Request\Request;
use Modassir\Http\Model\Collector;
use Modassir\Http\Model\MemberModal;
use Modassir\Http\Model\Member;
use Modassir\Http\Model\MemberDetails;
use Modassir\Http\Model\Owner as OwnerModal;

class Owner
{
  public $collector;
  public $member;
  private $owner;

  public function __construct()
  {
    $owner = OwnerModal::select('session', session()->get('logged_session'));
    $number = $owner->number;
    $this->owner = $owner;
    $this->collector = Collector::select('connect_id', $number);
    $this->member = MemberModal::findAll($number)->toArray();
  }

  public function index(Request $request)
  {
    $request = $request->all();
    $request['collector'] = $this->collector;
    $request['member'] = $this->member;
    $component = $request['component'];

    if (!$request['editable']) session()->forget([
      'session_id',
      'form-data',
      'fullname',
      'number',
      'image_data',
      'amount',
      'type',
      'village',
      'gender',
      'regdate',
      'profile'
    ]);

    $collected_time = $this->collector->collected_time;
    date_default_timezone_set('Asia/Kolkata');
    $date = new \DateTime($collected_time);
    $date->modify('+1 month');

    $request['last_collected_date'] = $collected_time;
    $request['next_collected_date'] = $date->format('d-m-Y h:i:s A');

    $paid_data = $this->collector->paid_data;
    $collected_memebrs = json_decode($paid_data, true);

    $request['overall_collection'] = $this->owner->collected;
    $request['collector_id'] = $this->owner->collector_id;
    $request['login_status'] = $this->owner->access ? 'checked' : '';
    $request['collected_members'] = count($collected_memebrs);
    $request['collected'] = $this->collector->collected;

    if ($component === 'view_profile') {
      $owner = $this->owner;
      $request = [
        'fullname' => $owner->fullname,
        'number' => $owner->number,
        'email' => $owner->email,
        'district' => $owner->district,
        'circle' => $owner->circle,
        'village' => $owner->village,
        'address' => $owner->address
      ];
    }

    view(\sprintf('layout.owner.%s', $component))->with($request);
  }

  public function manageCollectorLogin(Request $request)
  {
    $Auth = new Login(false);
    $secretary = OwnerModal::select('session', session()->get('logged_session'));
    $disabled = $request->all()['disabled'];

    if (!$secretary) {
      die(json_encode(['error' => 'Unauthorized Secretary.']));
    }

    if (!($disabled == 0 || $disabled == 1)) {
      die(json_encode(['error' => 'Bad Request']));
    }

    $number = $secretary->number;
    $collector = Collector::select('connect_id', $number);
    
    try {
      if ($disabled == 0) {
        $collector->session = '';
        $collector->paid_data = '[]';
        $collector->collected = 0;
        $collector->save();
      }
      
      $secretary->access = $disabled == 0 ? 1 : 0;
      $secretary->save();
      die(json_encode(['checked' => $disabled == 0 ? true : false]));
    } catch(\Execption $err) {
      die(json_encode(['error' => 'Server not Respond!']));
    }
  }

  public function deleteMember(Request $request)
  {
    $request = $request->all();
    $number = $request['uid'] ?? null;
    $Auth = new Login(false);
    $secretary = OwnerModal::select('session', session()->get('logged_session'));
    
    if (!$number) {
      die(json_encode(['message' => 'Bad Request.']));
    }

    if (!$secretary) {
      die(json_encode(['message' => 'Unauthorized Secretary.']));
    }

    $expect_secretary_id = $secretary->number;
    $member = Member::select('number', $number);
    $secretary_id = $member->owner_id;
    $profile = $member->profile;

    $member_details = new MemberDetails;

    if ($expect_secretary_id != $secretary_id) {
      die(json_encode(['message' => 'Unauthorized Secretary.']));
    }

    if ($member->delete($number) && $member_details->delete($number)) {
      unlink($profile);
      die(json_encode(['success' => true]));
    } else {
      die(json_encode(['message' => 'Cannot delete member, Server error!']));
    }
  }
}
?>