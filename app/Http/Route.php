<?php

namespace Modassir\Http;

use Modassir\Http\Request\Request;
use Clouser;

class Route
{
  private string $request = '';
  private static $group = '';
  private $routes = [];
  private $route;

  public function __construct($route, $routeInfo, $req)
  {
    $this->request = $req;
    $this->routes[$route] = $routeInfo;
    $this->route = $route;
  }

  /**
   * Handle get Request
   * 
   * @param string $path
   * @param array|callable $callback
   * @return self
   */
  public static function get(string $path, $callback)
  {
    return self::store($path, $callback, 'get');
  }

  /**
   * Handle post Request
   * 
   * @param string $path
   * @param array|callable $callback
   * @return self
   */
  public static function post(string $path, $callback)
  {
    return self::store($path, $callback, 'post');
  }

  /**
   * @param string $route
   * @param callable|array $callback
   * @param string $method
   * @return self
   */
  private static function store(string $route, $callback, string $method)
  {
    $route = \preg_replace('/^\//', '', $route);
    $route = \sprintf('%s/%s', self::$group, $route);

    $routeInfo = [
      'method' => \strtoupper($method),
      'callback' => $callback
    ];

    return new static($route, $routeInfo, $_SERVER['HTTP_REQUEST']);
  }

  /**
   * @param string $prefix
   * @param callable $callback
   */
  public static function group($prefix, callable $callback)
  {
    self::$group = $prefix;
    $callback();
    self::$group = '';
  }

  public function __destruct()
  {
    $req = \parse_url($this->request)['path'];
    $method = $_SERVER['REQUEST_METHOD'];
    $route = $this->routes[$req] ?? null;

    if ($route && $route['method'] === $method) {
      $callback = $route['callback'];
      if (!\is_callable($callback)) $callback[0] = new $callback[0];

      $request = new Request;
      $callback($request);
    }
  }
}
?>