<?php
namespace App\Services;
use App\Entities\CitoyensEntity;
use App\Repositories\CitoyensRepository;
class CitoyensService
 {
    private static ?CitoyensService $citoyenService = null;

    private CitoyensRepository $citoyensRepository;

     public  static function getInstance()
    {
        if(is_null(self:: $citoyenService))
         {
            self::$citoyenService=new CitoyensService(); 
         }
        
        return self::$citoyenService;
    }
    private function __construct()

    {
        $this->citoyensRepository=CitoyensRepository::getInstance();
    }

    public function getCitoyenByNumCni(string $numcni): ?CitoyensEntity
    {
        return $this->citoyensRepository->findByNum($numcni);
    }
    public function getAllCitoyens(): array
{
    return $this->citoyensRepository->findAll();
}


}