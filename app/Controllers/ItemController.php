<?php

namespace App\Controllers;

class ItemController {
  public function item($id) {
      if ($id < 1 || $id > 10) {
          echo "Numero " . $id;
          exit;
      }
  }

  
}

