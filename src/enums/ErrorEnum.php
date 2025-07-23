<?php 

namespace App\Src\Enums;

enum ErrorEnum:string {

    case ECHEC_CONNEXION = 'Connexion au serveur PostgreSQL échouée :';
    case ECHEC_CREATE_DATABASE = 'Erreur lors de la création de la base :';
    case ECHEC_CONNEXION_BASE = 'Connexion à la base échouée :';
    case ECHEC_CREATION_TABLE = 'Erreur lors de la création de la table :';
    case ECHEC_INSERTION = 'Erreur lors de l\'insertion des données :';

}