<?php

declare(strict_types=1);

namespace App\Helpers;

class Encryption {


  public static function encrypt(string $str)
  {
    return base64_encode($str);
  }


  public static function deccrypt(string $str)
  {
    return base64_encode($str);
  }
  

  public static function encryptID(int $id) : string
  {
    return base64_encode(((string)$id));
  }


  public static function deccryptID(string $str) : int
  {
    return (int) base64_encode($str);
  }
  
}