<?php

namespace Modassir\Http\Request;

use Modassir\Validation\Validation;
use Modassir\Session\Session;
use Lazervel\Path\Path;

class Request extends Validation
{
  private $upload_base_dir = __DIR__.'/../../../storage/';
  private $custom_filename;
  private $fileIndex = 0;
  private $request;
  private $file;

  public function __construct()
  {
    $this->request = \array_merge($_REQUEST, $_FILES);
  }

  public function verifyCaptcha(string $captcha)
  {
    return verify_encryption($captcha, $this->session()->get('captcha'));
  }

  /**
   * Request Forwarding
   */
  public function all() {
    return $this->request;
  }

  /**
   * Session Handling
   */
  public function session() {
    return new Session;
  }

  /**
   * @return string
   */
  public function getClientOriginalExtension()
  {
    return \pathinfo($this->file['name'], \PATHINFO_EXTENSION);
  }

  public function putFile(string $content, string $type, string $dir = 'upload')
  {
    $base_path = $this->upload_base_dir;
    if (!is_dir($base_path)) {
      die(json_encode([
        'error' => true,
        'message' => 'Base Directory Not Found!'
      ]));
    }

    $dir = \sprintf('%s%s', $base_path, $dir);
    if (!\is_dir($dir)) mkdir($dir);

    $filename = Path::resolve($dir.'/'.time().$type);
    if (\file_exists($filename)) return false;
    \file_put_contents($filename, $content);
    return $filename;
  }

  /**
   * @param string $fileKey
   * @return self
   */
  public function file(string $fileKey)
  {
    $this->file = $this->request[$fileKey];
    return $this;
  }

  /**
   * @param string $dir
   * @return string|bool
   */
  public function store(string $dir)
  {
    $temp = $this->file['tmp_name'] ?? null;
    $dir = \sprintf('%s%s', $this->upload_base_dir, $dir);

    if (!\is_dir($dir)) mkdir($dir);

    $filename = \sprintf('%s.%s', \time(), $this->getClientOriginalExtension());
    $filename = $this->custom_filename ?? $filename;
    $this->fileIndex++;

    $path = Path::resolve(\sprintf('%s/%s', $dir, $filename));

    if (\file_exists($path)) {
      return false;
    }

    if (\is_uploaded_file($temp) && \move_uploaded_file($temp, $path)) {
      return $path;
    }

    return false;
  }

  /**
   * @param string $destination
   * @param string $custom_filename
   * @return string|bool
   */
  public function storeAs(string $destination, string $custom_filename)
  {
    $this->custom_filename = $custom_filename;
    return $this->store($destination);
  }
}
?>