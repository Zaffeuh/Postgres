<?php

namespace APP\Services;
 use App\Repositories\JournalRepository;
class JournalService 
{
    private static ?JournalService $journalService = null;

    private JournalRepository $JournalRepository;
        public  static function getInstance()
    {
        if(is_null(self::$journalService))
         {
            self::$instance= new JournalService(); 
         }
        
        return self::$journalService;

    }
    private function __construct()

    {
        $this->JournalRepository=JournalRepository::getInstance();

    }
    public function create(JournalEntity $journalEntity )
    {
        return $this->JournalRepository->insertJournal($journalEntity);   
    }
}


