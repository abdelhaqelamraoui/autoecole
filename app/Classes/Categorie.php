<?php

declare(strict_types = 1);

namespace App\Classes;

class Categorie
{

  public int $id;
  public string $libelle;
  public int $prix;
  public int $nombreSeancesPratiques;

  /* 
    Because the database column is named nombre_seances_pratiques
  */
  public function __set($name, $value)
  {
    if($name == 'nombre_seances_pratiques') {
      $this->nombreSeancesPratiques = intval($value);
    }
  }
}

