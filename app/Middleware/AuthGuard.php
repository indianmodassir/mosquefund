<?php

namespace Modassir\Middleware;

use Modassir\Http\Model\Admin;
use Modassir\Http\Model\Owner;
use Modassir\Http\Model\Collector;
use Modassir\Http\Model\Member;

class AuthGuard
{
  public $info;
  public $isAuthorized;
  private $isLogged = false;
  private $session;
  private $route;
  private $loginInfo;
  public $secretries;
  public $members;

  private $loggings = ['/admin', '/owner', '/collector'];
  
  public function __construct()
  {
    $session = session();
    $this->session = $session->get('logged_session');
    $this->admin();
    $this->owner();
    $this->collector();
    $this->secretries = Owner::all();
    $this->members = Member::all();
  }

  private function checkLogged($isLogged, string $route)
  {
    if ($isLogged && !$this->isAuthorized) {
      $this->isAuthorized = !!$route;
      $this->loginInfo = $isLogged;
      $this->info = $isLogged->data();
      $this->route = $route;
    }
  }

  public function admin()
  {
    $this->checkLogged(Admin::select('session', $this->session), '/admin');
  }

  public function owner()
  {
    $this->checkLogged(Owner::select('session', $this->session), '/owner');
  }

  public function collector()
  {
    $this->checkLogged(Collector::select('session', $this->session), '/collector');
  }

  public function optRender()
  {
    if ($this->isAuthorized) {
      $json = $this->loginInfo->json();
      echo "<input type='hidden' id='info' name='info' value='{$json}' autocomplete='off'>";
      view(\sprintf('layout.opt_%s', \preg_replace('/^\//', '', $this->route)))->with($this->info);
    } else {
      view('layout.opt_default');
    }
  }

  public function __destruct()
  {
    $method = $_SERVER['REQUEST_METHOD'];
    $req_uri = \preg_replace('/\.\w+$/', '', $_SERVER['PHP_SELF']);

    if ($this->isAuthorized) {
      if ($method === 'POST') {
        return \json_encode(['authorized' => true]);
      } else if ($req_uri !== $this->route) {
        header('location:'.$this->route);
        exit;
      } else if (!\in_array($req_uri, $this->loggings)) {
        header('location:'.$this->route);
        exit;
      }
    }
    else if ($method === 'POST') {
      return \json_encode(['authorized' => false]);
    }
    else if (\in_array($req_uri, $this->loggings)) {
      header('location:/');
      exit;
    }
  }
}
?>