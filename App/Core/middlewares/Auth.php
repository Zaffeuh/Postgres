<?php

namespace App\Core\Middlewares;
use App\Core\Session;

class Auth {

    public function __invoke(){

        $session = Session::getInstance(); 

        $user = $session->get('user');


        try {
             if ($user === null) {

        }
        } catch (\Throwable $e) {
            
            
        }

    }


    
   

}