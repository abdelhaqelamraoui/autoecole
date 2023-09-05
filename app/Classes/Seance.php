<?php

declare(strict_types=1);

namespace App\Classes;



class Seance
{

  public int $id;
  public int $candidatId;
  public string $date;

  /* 
    because of difference between names on the database
    ant this class properties
  */
  public function __set($name, $value)
  {
    if($name == 'candidat') {
      $this->candidatId = intval($value);
    }
    elseif($name == 'date_seance')
    {
      $this->date = $value;
    }
  }

}