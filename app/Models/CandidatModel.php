<?php

// no strict types


namespace App\Models;

use App\Providers\DataProvider;


class CandidatModel
{

  private ?DataProvider $dataProvider = null;



  public function __construct(DataProvider $dataProvider)
  {
    $this->dataProvider = $dataProvider;
  }


  public function getAllCandidatsInfos(): array
  {
    return $this->dataProvider->getAllCandidatsInfos();
  }



  public function getCandidatById($id)
  {
    return $this->dataProvider->getCandidatById((int)$id);
  }

  

  public function getCandidatByCIN($cin)
  {
    return $this->dataProvider->getCandidatByCIN($cin);
  }

  

  public function getCandidatsByNomPrenom($nomPrenom)
  {
    return $this->dataProvider->getCandidatsByNomPrenom($nomPrenom);
  }
  


  public function getCandidatsByCategorie($categorie)
  {
    return $this->dataProvider->getCandidatsByCategorie($categorie);
  }



  public function getCandidatsByPattern($pattern)
  {
    return $this->dataProvider->getCandidatsByPattern($pattern);
  }



  public function getCandidatsInformationByPattern($pattern)
  {
    return $this->dataProvider->getCandidatsInformationByPattern($pattern);
  }



  public function getCandidatInformations($id)
  {
    return $this->dataProvider->getCandidatInformations((int)$id);
  }

  

  public function marquerSeance(int $id)
  {
    return $this->dataProvider->marquerSeancePratique($id);
  }

  
  public function deleteCandidat($id)
  {
    return $this->dataProvider->deleteCandidat((int)$id);
  }

  

  
  public function ajouterAvance($id, $montant)
  {
    return $this->dataProvider->ajouterAvance((int)$id, (int) $montant);
  }

  

  

  
  public function addCandidat($nom, $prenom, $cin, $telephone, $categorie, $avance, $dateInscription)
  {
    $nom = strtoupper($nom);
    $prenom = lcfirst($prenom);
    return $this->dataProvider->addCandidat($nom, $prenom, $cin, $telephone, $categorie, $avance, $dateInscription);
  }




}