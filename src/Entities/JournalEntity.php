<?php

namespace App\Entities;

class JournalEntity extends AbstractEntity {
    
    private int $id;
    private string $nci_recherche;
    private string $ip;
    private string $localisation;
    private StatutType $statut;
    private string $date_recherche;
    
    

    public function __construct($id = 0, $nci_recherche = '', $ip = '' , $localisation = '', StatutType $statut , $date_recherche = ''){
 
        $this->id = $id;
        $this->nci_recherche = $nci_recherche;
        $this->ip = $ip;
        $this->localisation = $localisation;
        $this->statut = $statut;
        $this->date_recherche = $date_recherche;

    }


    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nci_recherche
     */ 
    public function getNci_recherche()
    {
        return $this->nci_recherche;
    }

    /**
     * Set the value of nci_recherche
     *
     * @return  self
     */ 
    public function setNci_recherche($nci_recherche)
    {
        $this->nci_recherche = $nci_recherche;

        return $this;
    }

    /**
     * Get the value of ip
     */ 
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set the value of ip
     *
     * @return  self
     */ 
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get the value of localisation
     */ 
    public function getLocalisation()
    {
        return $this->localisation;
    }

    /**
     * Set the value of localisation
     *
     * @return  self
     */ 
    public function setLocalisation($localisation)
    {
        $this->localisation = $localisation;

        return $this;
    }

    /**
     * Get the value of statut
     */ 
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set the value of statut
     *
     * @return  self
     */ 
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get the value of date_recherche
     */ 
    public function getDate_recherche()
    {
        return $this->date_recherche;
    }

    /**
     * Set the value of date_recherche
     *
     * @return  self
     */ 
    public function setDate_recherche($date_recherche)
    {
        $this->date_recherche = $date_recherche;

        return $this;
    
    }


     public static function toObject(array $data):static{
        return new self(
            $data['id'],
            $data['nci_recherche'],
            $data['ip'],
            $data['localisation'],
            $data['statut'],
            $date['date_recherche']
        );
    }

     public function toArray(){
        return [
            'id' => $this->id,
            'nci_recherche' => $this->nci_recherche,
            'ip' => $this-> ip,
            'localisation' => $this -> localisation,
            'statut' => $this -> statut,
            'date_recherche' => $this -> date_recherche
        ];
    }





}