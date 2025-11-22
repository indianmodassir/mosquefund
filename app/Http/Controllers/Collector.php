<?php

namespace Modassir\Http\Controllers;

use Modassir\Http\Request\Request;
use Modassir\Http\Model\Collector as CollectModel;
use Modassir\Http\Model\MemberModal;
use Modassir\Http\Model\Owner;

class Collector extends MemberModal
{
  public function index(Request $request)
  {
    $session = session();
    $owner = Owner::select('session', $session->get('logged_session'));
    $model = CollectModel::select('session', $session->get('logged_session'));

    if ($owner) {
      $model = CollectModel::select('connect_id', $owner->number);
    }

    if (!$model) {
      die('<h1 class="not-found">Session Expired Re-login</h1>');
    }

    $req = $request->all();
    $members = MemberModal::findAll($model->connect_id);
    $data = [];

    $role = $req['role'];
    $component = $req['component'];

    if ($component === 'all' || $component === 'dashboard') {
      if (!sizeof($members->toArray())) {
        echo '<h1 class="not-found">Member Not Found!</h1>';
        return;
      } else {
        $paidData = \json_decode($model->paid_data, true);
        $data['paid_data'] = $paidData;
        $data['members'] = $members;
        $data['ownerAuthorized'] = !!$owner;
        $data['collected'] = $model->collected;
        $data['collected_members'] = count($paidData);
      }
    }

    if (!$owner) {
      $owner = Owner::select('number', $model->connect_id);
    }

    $data['owner_phone'] = $owner->number;
    $data['owner_email'] = $owner->email;

    $collected_time = $model->collected_time;
    date_default_timezone_set('Asia/Kolkata');
    $date = new \DateTime($collected_time);
    $date->modify('+1 month');

    $data['last_collected_date'] = $collected_time;
    $data['next_collected_date'] = $date->format('d-m-Y h:i:s A');

    $session->put('opt_request_id', encrypt($session->get('logged_session')));
    view("layout.collector.{$component}")->with($data);
  }
}
?>