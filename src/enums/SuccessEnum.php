<?php 

namespace App\Src\Enums;

enum SuccessEnum:string {
    case MIGRATION_SUCCESS = 'Les migrations ont été exécutées avec succès dans la base';
    case SUCCESS_CREATE_DATABASE = 'Base de données créée avec succès';
    case SUCCESS_CONNECTION = 'Connexion réussie à la base de données';
}
