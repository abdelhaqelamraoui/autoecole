<?php

declare(strict_types=1);

namespace App;

include __DIR__ . '/autoload.php';

use App\Helpers\Functions;
use App\Models\CandidatModel;
use App\Models\CategorieModel;
use App\Providers\MysqlDataProvider;


if (Functions::is_get()) {

  // paramFunctions::dump(parse_url($_SERVER['PATH_INFO'] ?? ''));
  $path = parse_url($_SERVER['PATH_INFO'] ?? '')["path"];
  $args = explode('/', $path);
  $ressourse = $args[1] ?? ''; // beacause the path starts with / then the first is empty string
   
  
  $queryString = $_SERVER['QUERY_STRING'];
  parse_str($queryString, $params);
  
  $model = new CandidatModel(new MysqlDataProvider());
  
  $paramFunctions = null;

  $defaultFunction = 'getAllCandidatsInfos';


  switch ($ressourse) {

    case 'candidats':

      $paramFunctions = [
        'id' => 'getCandidatById',
        'cin' => 'getCandidatByCIN',
        'nom' => 'getCandidatsByNomPrenom',
        'categorie' => 'getCandidatsByCategorie',
        'pattern' => 'getCandidatsInformationByPattern'
      ];

      break;
    
    case 'candidat':

      $paramFunctions = [
        'id' => 'getCandidatInformations', // the one that returs seances array too
      ];
      break;

    case 'categories':
      $model = new CategorieModel(new MysqlDataProvider());
      $defaultFunction = 'getAllCategories';

      $paramFunctions = [
        'id' => 'getCategorieById', // the one that returs seances array too
        'libelle' => 'getCategorieByLibelle', // the one that returs seances array too
      ];
      break;
      
    default:
      Functions::echoJSONData('Specify a ressource in the URL!');
      exit;
  }

  if (empty($params)) {
    // var_dump($model->$defaultFunction());
    Functions::echoJSONData($model->$defaultFunction());
    exit;
  }

  $firstKey = array_keys($params)[0];
  $function = $paramFunctions[$firstKey] ?? null;
  if (isset($function)) {
    $data = $model->$function($params[$firstKey]);
    Functions::echoJSONData($data);
  } else {

  }



}