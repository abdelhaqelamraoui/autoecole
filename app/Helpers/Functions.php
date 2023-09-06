<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Configs\Paths;


class Functions
{


  /**
   * loads a view to the layout
   * @param  string $view_name e.g.: 'index'
   * @param  mixed $data data to use in the view
   */
  public static function load_view(string $view_name, $data = false)
  {
    require_once(Paths::VIEWS . 'layout.php');
  }


  /**
   * Echos a variable preformatted
   * @param  mixed $val
   * @param  mixed $dump
   * @return void
   */
  public static function dump($val, $dump = false)
  {
    echo '<pre>';
    $dump ? var_dump($val) : print_r($val);
    echo '</pre>';
  }

  /**
   * @return `true` if the request method is POST, else `false`
   */
  public static function is_post()
  {
    return $_SERVER['REQUEST_METHOD'] === 'POST';
  }

  /**
   * @return `true` if the request method is GET, else `false`
   */
  public static function is_get()
  {
    return $_SERVER['REQUEST_METHOD'] === 'GET';
  }

  
  public static function echoJSONData(mixed $data) {
    ob_clean();
    header('Content-Type: application/json');
    echo json_encode($data);
  }

  
  public static function sanitize(string $str) {
    return trim($str);
  }

}