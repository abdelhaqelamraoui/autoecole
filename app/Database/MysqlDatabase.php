<?php

declare(strict_types=1);

namespace App\Database;

use App\Configs\DatabaseConfig;
use App\Exceptions\Database\ConnectionException;



class MysqlDatabase
{

  
  private \PDO $conn;



  function __construct()
  {
    try {

      $this->connect();

    } catch (\Throwable $th) {

      throw ConnectionException::connotConnect();
      
    }
  }



  function __destruct()
  {
    $this->disconnect();
  }



  function init()
  {
    $sql = <<<TXT
    TXT;

    if (!$this->isConnected())
      $this->connect();
    if ($this->isConnected())
      $this->execute($sql);
    $this->disconnect();
  }



  private function connect(): \PDO
  {

    $dsn = sprintf("mysql: host=%s; port=%d; dbname=%s",
     DatabaseConfig::HOSTNAME, DatabaseConfig::PORT, DatabaseConfig::DBNAME);

    $this->conn = new \PDO($dsn, DatabaseConfig::USERNAME, DatabaseConfig::PASSWORD);
    return $this->conn;
  }



  function isConnected(): bool
  {
    return !is_null($this->conn);
  }



  function disconnect()
  {
    unset($this->conn);
  }



  function execute(string $sql, ?array $params = null): bool
  {
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute($params);
  }



  function query(string $sql, ?array $params = null, int $mode = \PDO::FETCH_ASSOC, ?string $class = null): array|false
  {
    $stmt = $this->conn->prepare($sql);
    $stmt->execute($params);
    $res = ($class === null) ? $stmt->fetchAll($mode) : $stmt->fetchAll($mode, $class);
    $stmt->closeCursor();
    return $res;
  }



}