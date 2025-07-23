<?php
namespace App\Controllers;

use App\Core\Abstract\AbstractController;
use App\Services\CitoyensService;
use App\Entities\CitoyensEntity;
class CitoyensController extends AbstractController
{
    private CitoyensService $citoyensService;
    private CitoyensEntity $citoyens;
  
    public function __construct()
    {
       
        $this->citoyensService = CitoyensService::getInstance();
        $this->citoyens = new CitoyensEntity();
    }

    
    public function index() {
        $this->logRequest('GET', '/', 'success');
        
        // Ajouter cette ligne pour récupérer tous les citoyens
        $allCitoyens = $this->citoyensService->getAllCitoyens();
        
        return $this->renderJson([
            'data' => $allCitoyens ? array_map(fn($citoyen) => $citoyen->toArray($citoyen), $allCitoyens) : [],
            'statut' => 'success',
            'code' => 200,
            'message' => 'Liste des citoyens récupérée avec succès'
        ]);
       
    }

    public function findByNci($params) {  
        $nci = $params['nci'] ?? null;

        if (!$nci) {
            return $this->renderJson([
                'data' => null,
                'statut' => 'error',
                'code' => 400,
                'message' => 'Le paramètre NCI est requis'
            ], 400); // Assurez-vous que le code est un entier
        }

        try {
            $citoyen = $this->citoyensService->getCitoyenByNumCni($nci);
            
            if ($citoyen) {
                return $this->renderJson([
                    'data' => $citoyen->toArray($citoyen),
                    'statut' => 'success',
                    'code' => 200,
                    'message' => 'Le numéro de carte d\'identité a été retrouvé'
                ], 200); // Code HTTP entier
            }

            return $this->renderJson([
                'data' => null,
                'statut' => 'error',
                'code' => 404,
                'message' => 'Le numéro de carte d\'identité non retrouvé'
            ], 404); // Code HTTP entier
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return $this->renderJson([
                'data' => null,
                'statut' => 'error',
                'code' => 500,
                'message' => 'Erreur serveur'
            ], 500);
        }
    }

    /**
     * Journalise les demandes de recherche
     * Critère d'acceptation: Toutes les demandes sont journalisées
     */
    private function logRequest($method, $endpoint, $statut) 
    {
        $logData = [
            'date' => date('Y-m-d'),
            'heure' => date('H:i:s'),
            'method' => $method,
            'endpoint' => $endpoint,
            'statut' => ucfirst($statut), // Success|Échec
            'timestamp' => date('Y-m-d H:i:s')
        ];

        // Simulation de l'écriture en log (en production, écrire dans un fichier ou BD)
        error_log("AppDAF Log: " . json_encode($logData, JSON_UNESCAPED_UNICODE));
    }


}
