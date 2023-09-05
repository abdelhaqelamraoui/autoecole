<?php

declare(strict_types = 1);

namespace App;

require_once __DIR__ . '/../app/autoload.php';

use App\Controllers\MainController;
use App\Helpers\Functions;





if(Functions::is_get())
{

  $mainController = new MainController();


  $route = $_GET['route'] ?? null;

  if(! is_null($route)) {

    $args = explode('/', $route);
    $action = $args[0];
    $actionArg = $args[1] ?? null;
  
    if(is_null($actionArg))
    {
      /* 
        Call functions without argument
      */
      $mainController->candidats();
      // Functions::dump($_SERVER);
    }
    else
    {
      /* 
        Call functions with arguments
      */
    }
  }
  else
  {
    /* 
      No route is given
    */
    $mainController->candidats();
  }
}



if(Functions::is_post())
{

}