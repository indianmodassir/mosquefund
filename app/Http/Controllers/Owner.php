<?php

namespace Modassir\Http\Controllers;

use Modassir\Http\Request\Request;
use Modassir\Http\Model\Collector;
use Modassir\Http\Model\MemberModal;
use Modassir\Http\Model\Member;
use Modassir\Http\Model\MemberDetails;
use Modassir\Http\Model\Owner as OwnerModal;
use Modassir\Http\Model\Spent;

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

    if ($component === 'expense_data') {
      $expenses = Spent::findAll($this->owner->number);
      $request['expenses'] = $expenses->toArray();
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

  public function addspend(Request $request)
  {
    $request = $request->all();
    $Auth = new Login(false);

    $req_keys = ['spent_amount', 'describe', 'captcha'];
    foreach($req_keys as $key) {
      if (!isset($request[$key])) {
        $Auth->exportJSON('error', 'Bad Request');
      }
    }

    $amount = $request['spent_amount'];
    $describe = $request['describe'];
    $captcha = $request['captcha'];

    $Auth->checkEmptyField($amount, 'Spent Amount', '#spent_amount');
    $Auth->checkEmptyField($describe, 'Spent Description', '#describe');
    $Auth->checkEmptyField($captcha, 'Captcha', '#captcha');
    $Auth->verifyCaptcha($captcha);

    if ($amount < 1 || $amount > 1000000) {
      $Auth->exportJSON('error', 'Invalid Spent Amount', '#spent_amount');
    }

    $descLen = strlen($describe);
    if ($descLen < 15 || $descLen > 500) {
      $Auth->exportJSON('error', 'Description must be greater than 15 and less than 500 character.', '#describe');
    }

    $descWords = str_word_count($describe);
    if (is_numeric($describe) || $descWords < 3 || $descWords > 100) {
      $Auth->exportJSON('error', 'Invalid Description', '#describe');
    }

    $secretary = OwnerModal::select('session', session()->get('logged_session'));

    if (!$secretary) {
      die(json_encode(['message' => 'Unauthorized Secretary.']));
    }

    $collected = (int)$secretary->collected; // Overall Collection Amount
    $amount = intval($amount);

    if ($collected === 0) {
      $Auth->exportJSON('error', 'You cannot spent because your overall collection balance are (₹0).', '#spent_amount');
    }

    if ($amount > $collected) {
      $Auth->exportJSON('error', \sprintf('Entered expense (₹%d) exceeds the current available collection (₹%d).', $amount, $collected), '#spent_amount');
    }

    date_default_timezone_set('Asia/Kolkata');
    $spent = new Spent();
    $spent->number = $secretary->number;
    $spent->amount = $amount;
    $spent->describe = strtoupper($describe);
    $spent->date = date('d.m.y h:i:s P');
    $spent->save(true);

    $secretary->collected = $collected - $amount;
    $secretary->save();

    $html = '<div class="b_success">
      <h1>
        <svg width="50" height="50" viewBox="0 0 24 24" style="fill:currentColor;"><path d="m10 15.586-3.293-3.293-1.414 1.414L10 18.414l9.707-9.707-1.414-1.414z"></path></svg>
        <span>Expense record added successfully!</span>
      </h1>
      <div>
        <button data-action="/owner/dashboard" onclick="sendOptRequest(this)">Goto Dashboard</button>
        <button data-action="/owner/addspend" onclick="sendOptRequest(this)">Add New Record</button>
      </div>
    </div>';

    die(json_encode(['body' => $html]));
  }
}
?>