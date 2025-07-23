<?php
namespace App\Core\Abstract;

abstract class AbstractController 
{
   /**
     * Journalise les requêtes HTTP
     * @param string $method
     * @param string $endpoint
     * @param string $statut
     */
    protected function jsonSuccess($data = [], $message = 'Succès', $statusCode = 200) 
    {
        return [
            'data' => $data,
            'statut' => 'success',
            'code' => $statusCode,
            'message' => $message,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }
    
    /**
     * Gère les erreurs JSON
     * @param string $message
     * @param array $errors
     * @param int $statusCode
     * @return array
     */
    protected function jsonError($message = 'Erreur', $errors = [], $statusCode = 400) 
    {
        return [
            'data' => null,
            'statut' => 'error',
            'code' => $statusCode,
            'message' => $message,
            'errors' => $errors,
            'timestamp' => date('Y-m-d H:i:s')
        ];
    }
    
   
    /**
     * Récupère les données JSON de la requête
     * @return array
     */
    protected function getJsonInput() 
    {
        $input = file_get_contents('php://input');
        return json_decode($input, true) ?? [];
    }

   /**
     * Rendu JSON avec en-tête approprié
     * @param array $data
     * @param int $statusCode
     * @return string
     */
    protected function renderJson($data, $statusCode = 200) 
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        // return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        echo(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }
}