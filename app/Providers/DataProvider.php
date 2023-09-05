<?php

declare(strict_types = 1);


namespace App\Providers;

use App\Classes\Candidat;
use App\Classes\CandidatInformations;
use App\Classes\Categorie;
use App\Classes\Seance;


abstract class DataProvider
{

  

  abstract function __construct();


  /************************************************************************************/
  /********************************* Candidat management ******************************/
  /************************************************************************************/

  public abstract function addCandidat(string $nom, string $prenom, string $cin, string $telephone, string $categorie, int $avance, string $dateInscription): bool;

  public abstract function updateCandidat(int $id, string $nom, string $prenom, string $cin, string $telephone, string $categorie, int $avance, string $dateInscription): bool;

  public abstract function deleteCandidat(int $id): bool;

  public abstract function getCandidatById(int $id): ?Candidat;

  public abstract function getCandidatByCIN(string $cin): ?Candidat;

  public abstract function getCandidatsByNomPrenom(string $nomPrenom): array;

  public abstract function getCandidatsByCategorie(string $categorie): array;
  
  public abstract function getCandidatsByPattern(string $pattern): array;

  public abstract function getCandidatsInformationByPattern(string $pattern): array;

  public abstract function getAllCandidats(): array;

  public abstract function getCandidatInformations(int $id): ?CandidatInformations;

  public abstract function getAllCandidatsInfos(): array;

  public abstract function getCandidatSeances(int $id): array;
  
  public abstract function ajouterAvance(int $id, int $monatant): bool;
  


  /**
   * Add a seance for a candidat with the given id
   */
  public abstract function marquerSeancePratique(string $id): bool;


  /************************************************************************************/
  /********************************* Categorie management *****************************/
  /************************************************************************************/

  public abstract function addCategorie(string $libelle, int $prix, $nombreSeancesPratiques): bool;

  public abstract function updateCategorie(int $id, string $libelle, int $prix, $nombreSeancesPratiques): bool;

  public abstract function deleteCategorie(int $id): bool;

  public abstract function getCategorieById(int $id): ?Categorie;

  public abstract function getCategorieByLibelle(string $libelle): ?Categorie;

  public abstract function getAllCategories(): array;


  /************************************************************************************/
  /*********************************** Seance management ******************************/
  /************************************************************************************/

  public abstract function addSeance(int $candidatId, string $dateSeance): bool;

  public abstract function getSeance(int $id): ?Seance;

  public abstract function getAllSeances(): array;

  public abstract function getAllSeancesByCandidatId(int $candidatId): array;
}