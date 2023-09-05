<?php

declare(strict_types=1);

namespace App\Models;
use App\Providers\DataProvider;

class CategorieModel
{
  private ?DataProvider $dataProvider = null;



  public function __construct(DataProvider $dataProvider)
  {
    $this->dataProvider = $dataProvider;
  }


  public function getCategorieById($id)
  {
    return $this->dataProvider->getCategorieById((int) $id);
  }


  public function getCategorieByLibelle($libelle)
  {
    return $this->dataProvider->getCategorieByLibelle($libelle);
  }


  public function getAllCategories()
  {
    return $this->dataProvider->getAllCategories();
  }


}
