<?php


namespace App\Tests;



use App\Providers\MysqlDataProvider;

use App\Helpers\Functions;



class TestDb
{


  public static function testCandidat() {
    
    $mdp = new MysqlDataProvider();
    // Functions::dump($mdp);

    // Functions::dump(
    //   $mdp->addCandidat(
    //     'Hind',
    //     'Saaidi',
    //     strtoupper('U' .substr(uniqid(), -5)),
    //     '0578963214',
    //     'C',
    //     2000,
    //     '2023/01/28'
    //   )
    // );

    // Functions::dump($mdp->getAllCandidats(), true);
    // Functions::dump($mdp->getCandidatById(3), true);
    // Functions::dump($mdp->deleteCandidat(3), true);

    // Functions::dump($mdp->getAllCandidatsInfos());
    // Functions::dump($mdp->getCandidatInformations(2));

    // test marquer sance
    // // Functions::dump($mdp->getCandidatInformations(2));
    // Functions::dump($mdp->marquerSeancePratique(2));
    // Functions::dump($mdp->getCandidatInformations(2));

    // search
    // Functions::echoJSONData($mdp->getCandidatsInformationByPattern('U77'));


  }



  public static function testCategorie()
  {
    $mdp = new MysqlDataProvider();
    // Functions::dump($mdp->addCategorie('B', 3500, 10));
    // Functions::dump($mdp->getAllCategories());
    // Functions::dump($mdp->getCategorieById(1));
    // Functions::dump($mdp->getCategorieByLibelle('C'));
    // Functions::dump($mdp->getCategorieByLibelle('C'));
    
    // Functions::dump($mdp->deleteCategorie('1'));
    // Functions::dump($mdp->getAllCategories());
  }



  public static function testSeance() 
  {

    $mdp = new MysqlDataProvider();

    // Functions::dump($mdp->addSeance(7, '2023/08/30'), true);
    // Functions::dump($mdp->getAllSeances());
    // Functions::dump($mdp->getSeance(2));
    // Functions::dump($mdp->getAllSeancesByCandidatId(4));
  }



}



