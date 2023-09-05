<?php

declare(strict_types = 1);

namespace App;

spl_autoload_register(function($class) {
  $classPath = __DIR__ . '/../' . str_replace('\\', '/', lcfirst($class)) . '.php';
  if(file_exists($classPath)) {
    require_once $classPath;
  }
});