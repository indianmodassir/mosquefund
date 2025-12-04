<?php

namespace Modassir\Validation;

class Validation
{
  /**
   * 
   */
  private function export(string $message, ?string $selector = null)
  {
    die(\json_encode([
      'error' => true,
      'message' => $message,
      'selector' => $selector
    ]));
  }

  public function checkRequest(array $keys)
  {
    $request = $this->all();
    foreach($keys as $key) {
      if (!isset($request[$key])) $this->export('Bad Request');
      return $request;
    }
  }

  private function csrf(string $value, $selector, $field)
  {
    $session = \session();
    $expect_csrf = $session->get('XRF-TOKEN');
    if ($value !== $expect_csrf) {
      $this->export('Page Expired!');
    }
  }

  /**
   * @param string $value
   * @param string|null $selector
   * @param string|null $field
   */
  private function gender(string $value, $selector, $field)
  {
    $genders = ['Male', 'Female', 'Other'];
    if (!in_array($value, $genders)) {
      $this->export(\sprintf('Invalid %s.', $field), $selector);
    }
  }

  /**
   * @param string $value
   * @param string|null $selector
   * @param string|null $field
   */
  private function amount(string $value, $selector, $field)
  {
    $val = (int) $value;
    if ($val <= 0 || $val > 2400) {
      $this->export(\sprintf('Invalid %s.', $field), $selector);
    }
  }

  /**
   * @param string $value
   * @param string|null $selector
   * @param string|null $field
   */
  private function scalar(string $value, $selector, $field)
  {
    $value = trim($value);
    $pattern = '/^(?:([a-z\x{0900}-\x{097F}]+)(\s[a-z\x{0900}-\x{097F}])?)+$/ui';
    $length = strlen($value);
    if (($length < 4 || $length > 80) || !preg_match($pattern, $value)) {
      $this->export(\sprintf('Invalid %s.', $field), $selector);
    }
  }

  /**
   * @param string $value
   * @param string|null $selector
   * @param string|null $field
   */
  private function username(string $value, $selector, $field)
  {
    $value = trim($value);
    $pattern = '/^(?:(?:([a-z\x{0900}-\x{097F}]+)(\d+)?)(\s[a-z\x{0900}-\x{097F}])?)+$/ui';
    $length = strlen($value);
    if (($length < 3 || $length > 80) || !preg_match($pattern, $value)) {
      $this->export(\sprintf('Invalid %s.', $field), $selector);
    }
  }

  /**
   * @param string $value
   * @param string|null $selector
   * @param string|null $field
   */
  private function number(string $value, $selector, $field)
  {
    if (!preg_match('/^[6-9]{1}[0-9]{9}$/', $value)) {
      $this->export(\sprintf('Invalid %s.', $field), $selector);
    }
  }

  /**
   * @param string $value
   * @param string|null $selector
   * @param string|null $field
   */
  private function loginCode(string $value, $selector, $field)
  {
    if (!preg_match('/^[0-9]{8}$/', $value)) {
      $this->export(\sprintf('Invalid %s.', $field), $selector);
    }
  }

  /**
   * @param string $value
   * @param string|null $selector
   * @param string|null $field
   */
  private function email(string $value, $selector, $field)
  {
    if (!filter_var($value, \FILTER_VALIDATE_EMAIL)) {
      $this->export(\sprintf('Invalid %s.', $field ?? 'Email address'), $selector);
    };
  }

  /**
   * @param array $data [required]
   * @param string|null $selector [required]
   * @param string|null $field [optional]
   */
  public function validate(array $data, ?string $selector, ?string $field = null)
  {
    foreach($data as $method => $value) {
      $this->$method($value, $selector, $field);
    }
  }
}
?>