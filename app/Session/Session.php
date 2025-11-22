<?php

namespace Modassir\Session;

class Session
{
  public function __construct()
  {
    if (!isset($_SESSION)) \session_start();
  }

  public function put(string $key, string $value)
  {
    $_SESSION[$key] = $value;

    // For Instant Save
    // \session_write_close();
    return $this;
  }

  public function get(string $key) {
    return $_SESSION[$key] ?? null;
  }

  public function flush() {
    \session_destroy();
    return $this;
  }

  public function id()
  {
    return \session_create_id();
  }

  public function has(string $key) {
    return \in_array($key, \array_keys($_SESSION ?? []));
  }

  public function forget($keys) {
    $keys = (array) $keys;
    foreach($keys as $key) {
      if ($this->has($key)) {
        unset($_SESSION[$key]);
      }
    }
  }
}
?>