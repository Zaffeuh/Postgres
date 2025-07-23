<?php
namespace App\Repositories;
use App\Core\abstract;
use App\Entities;

class JournalRepository extends AbstractRepository {

    private string $table='journal';
    private static ?JournalRepository $instance = null ;
    public static function getInstance(): JournalRepository
    {
        if (is_null(self::$instance)) {
            self::$instance = new JournalRepository();
        }
        return self::$instance;
    }
    
    private function __construct()
    {
        parent::construct();
    }

    

    public function insertJournal(JournalEntity $journal): int
    {
        try{
        $query = "Insert INTO $this->table (nci_recherche, ip, localisation,  statut, date_recherche) 
                     VALUES  (:nci_recherche, :ip, :localisation, :statut, :date_recherche)";    
        $statement = $this->pdo->prepare($query);
         $statement->execute([
            'nci_recherche' => $journal->getNci_recherche(),
            'date' => $journal->getDate_recherche()->format('Y-m-d H:i:s'),
            'ip' => $journal->getIp(),
            'statut' => $journal->getStatut()->value,
           
        ]);
        return $this->pdo->lastInsertId();
        
        } catch (\PDOException $e) {
            throw new \Exception("Erreur lors de l'insertion du journal: " . $e->getMessage());
        }

    }
        


}

