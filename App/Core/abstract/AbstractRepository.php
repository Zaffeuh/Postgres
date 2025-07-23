<?php

namespace App\Core\Abstract;

use App\Core\DataBase;
use PDO;
abstract class AbstractRepository{

    protected PDO $pdo;

   public function __construct(){

        $this->pdo = DataBase::getInstance()->getConnection();
    }
}


