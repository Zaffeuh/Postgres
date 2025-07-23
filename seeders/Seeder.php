<?php 

namespace App\Seeders;
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\DataBase;
use App\Src\Enums\ErrorEnum;
use App\Src\Enums\SuccessEnum;
use App\Src\Enums\TextEnum;

class Seeder
{
    private \PDO $pdo;
    private DataBase $database;

    public function __construct()
    {
        $this->database = DataBase::getInstance();
    }

    public function run(): bool
    {
        
        if (!$this->checkDatabaseExists()) {
            echo ErrorEnum::ECHEC_CONNEXION->value . " La base de données n'existe pas. Veuillez d'abord exécuter les migrations.\n";
            return false;
        }

        try {
            $this->pdo = $this->database->getConnection();
            $this->pdo->beginTransaction(); 

            $this->seedCitoyens();
            $this->seedJournal();

            $this->pdo->commit();
            echo SuccessEnum::MIGRATION_SUCCESS->value . " Données insérées avec succès.\n";
            return true;

        } catch (\PDOException $e) 
        {
            if (isset($this->pdo)) {
                $this->pdo->rollBack();
            }
            error_log("Erreur lors du seeding: " . $e->getMessage());
            echo ErrorEnum::ECHEC_CREATION_TABLE->value . " Erreur : " . $e->getMessage() . "\n";
            return false;
        }
    }

    private function checkDatabaseExists(): bool
    {
        try {
            // Essayer de se connecter à la base de données
            $this->pdo = $this->database->getConnection();
            
            // Vérifier si les tables existent
            $tables = ['citoyens', 'journal'];
            foreach ($tables as $table) {
                $result = $this->pdo->query("SELECT to_regclass('public.$table')");
                if ($result->fetchColumn() === null) {
                    echo "La table '$table' n'existe pas. Veuillez d'abord exécuter les migrations.\n";
                    return false;
                }
            }
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    private function seedCitoyens(): void
    {
        // Vérifier si des données existent déjà
        

        echo "Insertion des données dans la table 'citoyens'...\n";

        $citoyens = [
            [
                'nci' => '1234567890123',
                'nom' => 'DIOP',
                'prenom' => 'Mamadou',
                'date_naissance' => '1990-01-01',
                'lieu_naissance' => 'Dakar',
                'url_recto' => 'storage/images/1234567890123_recto.jpg',
                'url_verso' => 'storage/images/1234567890123_verso.jpg'
            ],
            [
                'nci' => '9876543210987',
                'nom' => 'FALL',
                'prenom' => 'Fatou',
                'date_naissance' => '1995-05-15',
                'lieu_naissance' => 'Saint-Louis',
                'url_recto' => 'storage/images/9876543210987_recto.jpg',
                'url_verso' => 'storage/images/9876543210987_verso.jpg'
            ],
            [
                'nci' => '5555666677778',
                'nom' => 'NDIAYE',
                'prenom' => 'Aminata',
                'date_naissance' => '1988-12-25',
                'lieu_naissance' => 'Thiès',
                'url_recto' => 'storage/images/5555666677778_recto.jpg',
                'url_verso' => 'storage/images/5555666677778_verso.jpg'
            ]
        ];

        $stmt = $this->pdo->prepare("
            INSERT INTO citoyens (nci, nom, prenom, date_naissance, lieu_naissance, url_recto, url_verso)
            VALUES (:nci, :nom, :prenom, :date_naissance, :lieu_naissance, :url_recto, :url_verso)
        ");

        foreach ($citoyens as $citoyen) {
            $stmt->execute($citoyen);
        }

        echo count($citoyens) . " citoyens insérés avec succès.\n";
    }

    private function seedJournal(): void
    {
        echo "Insertion des données dans la table 'journal'...\n";

        $journaux = [
            [
                'nci_recherche' => '1234567890123',
                'ip' => '192.168.1.1',
                'localisation' => 'Dakar, Sénégal',
                'statut' => 'success',
                'message' => 'Recherche réussie'
            ],
            [
                'nci_recherche' => '9999999999999',
                'ip' => '192.168.1.2',
                'localisation' => 'Thiès, Sénégal',
                'statut' => 'error',
                'message' => 'NCI non trouvé'
            ],
            [
                'nci_recherche' => '2191020123456',
                'ip' => '192.168.1.3',
                'localisation' => 'Mbour, Sénégal',
                'statut' => 'success',
                'message' => 'Recherche réussie'
            ],
            [
                'nci_recherche' => '9876543210987',
                'ip' => '10.0.0.1',
                'localisation' => 'Saint-Louis, Sénégal',
                'statut' => 'success',
                'message' => 'Consultation réussie'
            ]
        ];

        $stmt = $this->pdo->prepare("
            INSERT INTO journal (nci_recherche, ip, localisation, statut, message)
            VALUES (:nci_recherche, :ip, :localisation, :statut, :message)
        ");

        foreach ($journaux as $journal) {
            $stmt->execute($journal);
        }

        echo count($journaux) . " entrées de journal insérées avec succès.\n";
    }
}

// Point d'entrée
(new Seeder())->run();