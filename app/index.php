<?php

declare(strict_types = 1);

namespace App;
use App\Helpers\Functions;
use App\Models\CandidatModel;
use App\Providers\MysqlDataProvider;


require_once __DIR__ . '/../app/router.php';


/****************************************************************************** 

  This is where post requests are handled

*******************************************************************************/



if(Functions::is_post())
{

  /****************************************************************
  *****************************************************************/
  
  $candidatModel = new CandidatModel(new MysqlDataProvider());


  if(isset($_POST['marquer']))
  {
    $candidatId = intval($_POST['id']);

    $candidatModel->marquerSeance($candidatId);

  }



  if(isset($_POST['delete']))
  {
    $id = $_POST['id'];
    $candidatModel->deleteCandidat($id);
  }



  if(isset($_POST['add']))
  {
    $nom = Functions::sanitize($_POST['nom']);
    $prenom = Functions::sanitize($_POST['prenom']);
    $cin = Functions::sanitize($_POST['cin']);
    $telephone = Functions::sanitize($_POST['telephone']);
    $categorie = Functions::sanitize($_POST['categorie']);
    $avance = Functions::sanitize($_POST['avance']);
    // $nombreSancesPratiques = Functions::sanitize($_POST['nombre-seances']);
    $dateInscription = Functions::sanitize($_POST['date-inscription']);

    $candidatModel->addCandidat(
      $nom,
      $prenom,
      $cin,
      $telephone,
      $categorie,
      $avance,
      // $nombreSancesPratiques,
      $dateInscription
    );

  }



  if(isset($_POST['update']))
  {

  }


  if(isset($_POST['ajouter-avance']))
  {
    $id = $_POST['id'];
    $montant = $_POST['montant'];

    $candidatModel->ajouterAvance($id, $montant);
  }

}