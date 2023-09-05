<?php

declare(strict_types=1);

namespace App\Classes;

use App\Helpers\Encryption;



class Candidat
{

  public int $id;
  public string $nom;
  public string $prenom;
  public string $cin;
  public string $telephone;
  public int $avance;
  public string $categorie;
  public string $dateInscription;
  

  public function getCin(): string
  {
    return Encryption::deccrypt($this->cin);
  }

  public function getTelephone(): string
  {
    return Encryption::deccrypt($this->telephone);
  }


  
  /*
   * Note here that the database column name is with '_'
   * while the class property is in camel case.
   * This is to resolve the problem.
   */
  public function __set(string $name, mixed $value): void {
    
    if($name == 'date_inscription')
    {
      $this->dateInscription = strval($value);
    }
  }



}