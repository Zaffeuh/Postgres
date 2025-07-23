<?php
namespace App\Migrations;
require_once __DIR__ . '/../vendor/autoload.php';
use PDO;
use App\Core\DataBase;
use App\Src\Enums\ErrorEnum;
use App\Src\Enums\TextEnum;
use App\Src\Enums\SuccessEnum;

class Migration
{
    private string $dbName;
    private DataBase $database;

    public function __construct()
    {
        $this->database = DataBase::getInstance();
    }

    public function run(): void
    {
        echo "--- Lancement de la migration ---\n\n";
        
        $this->handleDatabaseCreation();
        $this->migrateTables();
        
        echo "\n--- Migration terminée avec succès ---\n";
        echo "Vous pouvez maintenant exécuter le seeder avec : php seeders/Seeder.php\n\n";
    }

    private function handleDatabaseCreation(): void
    {
        $reponse = strtolower(trim(readline(TextEnum::QUESTION_BASE_EXISTANTE->value)));

        if ($reponse === 'oui' || $reponse === 'o') {
            $this->dbName = trim(readline(TextEnum::QUESTION_NOM_BASE->value));
            $this->checkDatabaseExists();
        } else {
            $this->dbName = trim(readline(TextEnum::READLINE_NOM_NEW_BASE->value));
            $this->createDatabase();
        }

        $this->database->setDatabaseName($this->dbName);
    }

    private function checkDatabaseExists(): void
    {
        $pdo = $this->database->getServerConnection();
        
        try {
            $stmt = $pdo->prepare("SELECT 1 FROM pg_database WHERE datname = ?");
            $stmt->execute([$this->dbName]);
            
            if (!$stmt->fetch()) {
                echo "La base de données '{$this->dbName}' n'existe pas.\n";
                $create = strtolower(trim(readline("Voulez-vous la créer ? (oui/non): ")));
                
                if ($create === 'oui' || $create === 'o') {
                    $this->createDatabase();
                } else {
                    exit("Migration annulée.\n");
                }
            } else {
                echo "Base de données '{$this->dbName}' trouvée.\n";
            }
        } catch (\PDOException $e) {
            exit(ErrorEnum::ECHEC_CONNEXION->value . $e->getMessage() . "\n");
        }
    }

    private function createDatabase(): void
    {
        $pdo = $this->database->getServerConnection();
        
        try {
            $pdo->exec("CREATE DATABASE \"{$this->dbName}\"");
            echo SuccessEnum::SUCCESS_CREATE_DATABASE->value . " '{$this->dbName}'.\n";
        } catch (\PDOException $e) {
            exit(ErrorEnum::ECHEC_CREATE_DATABASE->value . $e->getMessage() . "\n");
        }
    }

    private function migrateTables(): void
    {
        $pdo = $this->database->getConnection();
        
        try {
            echo "Création des tables...\n";
            $this->createCitoyensTable($pdo);
            $this->createJournalTable($pdo);
            echo SuccessEnum::MIGRATION_SUCCESS->value . " dans '{$this->dbName}'.\n\n";
        } catch (\PDOException $e) {
            exit(ErrorEnum::ECHEC_CREATION_TABLE->value . $e->getMessage() . "\n");
        }
    }

    private function createCitoyensTable(PDO $pdo): void
    {
        try {
            $pdo->exec("
                CREATE TABLE IF NOT EXISTS citoyens (
                    id SERIAL PRIMARY KEY,
                    nci VARCHAR(20) UNIQUE NOT NULL,
                    nom VARCHAR(100) NOT NULL,
                    prenom VARCHAR(100) NOT NULL,
                    date_naissance DATE NOT NULL,
                    lieu_naissance VARCHAR(255) NOT NULL,
                    url_recto TEXT NOT NULL,
                    url_verso TEXT NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                );
            ");
            
            echo "✓ Table 'citoyens' créée avec succès.\n";
           
        } catch (\Throwable $th) {
            throw new \Exception("Erreur lors de la création de la table citoyens: " . $th->getMessage());
        }
    }

    private function createJournalTable(PDO $pdo): void
    {
        try {
            $pdo->exec("
                CREATE TABLE IF NOT EXISTS journal (
                    id SERIAL PRIMARY KEY,
                    nci_recherche VARCHAR(20) NOT NULL,
                    ip VARCHAR(45) NOT NULL,
                    localisation VARCHAR(255),
                    statut VARCHAR(20) NOT NULL CHECK (statut IN ('success', 'error')),
                    message TEXT,
                    date_recherche TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                );
            ");
            
            echo "✓ Table 'journal' créée avec succès.\n";
           
        } catch (\Throwable $th) {
            throw new \Exception("Erreur lors de la création de la table journal: " . $th->getMessage());
        }
    }
}

// Point d'entrée
(new Migration())->run();
