<?php

namespace Modassir\Model;

class Model implements \IteratorAggregate
{
  protected $attributes = [];
  private $collection = [];
  private $updatable = false;
  private $conn;

  public function __construct()
  {
    $options = [
      \PDO::ATTR_ERRMODE,
      \PDO::ATTR_DEFAULT_FETCH_MODE,
      \PDO::ATTR_EMULATE_PREPARES
    ];

    try {
      $this->conn = new \PDO(
        \sprintf('%s:host=%s;dbname=%s', $_ENV['DB_DRIVER'], $_ENV['DB_HOST'], $_ENV['DB_DATABASE']),
        $_ENV['DB_USERNAME'],
        $_ENV['DB_PASSWORD'],
        $options
      );
    } catch(\PDOException $err) {
      die('Database Not Connected');
    }
  }

  public static function find($key) {
    try {
      $instance = new static;
      $stmt = $instance->conn->prepare("SELECT * FROM `{$instance->table}` WHERE `{$instance->primaryKey}` = :key");
      $stmt->bindParam(':key', $key);
      $stmt->execute();
      $data = $stmt->fetch(\PDO::FETCH_ASSOC);
      $instance->attributes = $data;
      return $instance;
    } catch(\Execption $err) {
      die('Database Error');
    }
  }

  public static function findAll($key) {
    try {
      $instance = new static;
      $stmt = $instance->conn->prepare("SELECT * FROM `{$instance->table}` WHERE `{$instance->primaryKey}` = :key");
      $stmt->bindParam(':key', $key);
      $stmt->execute();
      $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
      
      foreach ($rows as $key=>$row) $instance->collection[] = $row;
      return $instance;
    } catch(\Exception $err) {
      die('Database Error');
    }
  }

  public static function select($key, $value)
  {
    try {
      $instance = new static;
      $stmt = $instance->conn->prepare("SELECT * FROM `{$instance->table}` WHERE `{$key}` = :key");
      $stmt->bindParam(':key', $value);
      $stmt->execute();
      $data = $stmt->fetch(\PDO::FETCH_ASSOC);
      $instance->attributes = $data;
      return $data ? $instance : null;
    } catch(\Exception $err) {
      die('Database Error');
    }
  }

  public static function all() {
    try {
      $instance = new static;
      $stmt = $instance->conn->prepare("SELECT * FROM `{$instance->table}`");
      $stmt->execute();
      $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

      foreach ($rows as $row) $instance->collection[] = $row;
      return $instance;
    } catch(\Exception $err) {
      die('Database Error');
    }
  }

  public function getIterator(): \Traversable {
    return new \ArrayIterator($this->collection);
  }

  public function save(?bool $insertable = null)
  {
    try {
      $primaryKey = $this->attributes[$this->primaryKey] ?? null;
      if ($insertable) $primaryKey = null;

      $cols = \array_keys($this->attributes);
      $columns_updater = '`'. \join('` = ?, `', $cols).'` = ?';
      $columns_inserts = '`'.\join('`,`', $cols).'`';
      $values = \array_values($this->attributes);

      $table = $this->table;
      $key = $this->primaryKey;

      $placeholder = \str_repeat('?, ', \count($cols));
      $placeholder = \substr($placeholder, 0, -2);

      $stmt =  $this->conn->prepare(
        \is_null($primaryKey) ? "INSERT INTO `{$table}` ({$columns_inserts}) VALUES({$placeholder})"
        : "UPDATE `{$table}` SET {$columns_updater} WHERE `{$key}` = ?"
      );

      if (!\is_null($primaryKey)) $values[] = $primaryKey;
      $stmt->execute($values);
    } catch(\Exception $err) {
      die('Database Error');
    }
  }

  public function json()
  {
    return \json_encode($this->data());
  }

  public function data()
  {
    return $this->attributes;
  }

  public function delete($number)
  {
    try {
      $table = $this->table;
      $stmt = $this->conn->prepare("DELETE FROM `{$table}` WHERE `{$table}`.`number` = ?");
      $stmt->execute([$number]);
      return $stmt->rowCount() > 0;
    } catch(\Exception $err) {
      die('Database Error');
    }
  }

  public function toArray()
  {
    return $this->collection;
  }

  public function toJSON()
  {
    return \json_encode($this->toArray());
  }

  public function __get($key) {
    return $this->attributes[$key] ?? null;
  }

  public function __set($key, $value) {
    $this->attributes[$key] = $value;
  }

  public function __destruct() {
    $this->conn = null;
  }
}
?>