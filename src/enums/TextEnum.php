<?php

namespace App\Src\Enums;



enum TextEnum:string {
    case QUESTION_BASE_EXISTANTE = 'Avez-vous une base de données existante ? (O/N) : ';
    case QUESTION_NOM_BASE = 'Entrez le nom de la base de données : ';
    case READLINE_NOM_NEW_BASE = 'Entrez le nom de la nouvelle base à créer : ';
}