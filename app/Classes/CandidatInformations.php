<?php

declare(strict_types=1);

namespace App\Classes;

use App\Helpers\Encryption;



class CandidatInformations
{

  public int $id;
  public string $nom;
  public string $prenom;
  public string $cin;
  public string $telephone;
  public string $categorie;
  public int $avance;
  public string $dateInscription;
  public array $seancesPratiques;

  public function getCin(): string
  {
    return Encryption::deccrypt($this->cin);
  }

  public function getTelephone(): string
  {
    return Encryption::deccrypt($this->telephone);
  }

  public static function newCandidatInformation(Candidat $candidat): self
  {
    $candidatInformations = new self();

    $candidatInformations->id = $candidat->id;
    $candidatInformations->nom = $candidat->nom;
    $candidatInformations->prenom = $candidat->prenom;
    $candidatInformations->cin = $candidat->cin;
    $candidatInformations->telephone = $candidat->telephone;
    $candidatInformations->avance = $candidat->avance;
    $candidatInformations->categorie = $candidat->categorie;
    $candidatInformations->dateInscription = $candidat->dateInscription;
    
    return $candidatInformations;
  }


}