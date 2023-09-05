<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Helpers\Functions;


class MainController
{
  

  public function candidats() : void {
    Functions::load_view('candidats');
  }
  

  public function candidat(string $id) : void {
    
  }
}
