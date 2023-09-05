<?php

declare(strict_types=1);


namespace App\Exceptions\Database;


class ConnectionException extends \Exception
{

  public static function connotConnect() : static
  {
    return new static('Cannot connect to the database');
  }

}
