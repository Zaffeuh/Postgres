<?php

namespace App\Entities;
use App\Core\Abstract\AbstractEntity;

class CitoyensEntity extends AbstractEntity {

    private int $id;
    private string $nci;
    private string $nom;
    private string $prenom;
    private string $date_naissance;
    private string $lieu_naissance;
    private string $url_recto;
    private string $url_verso;
    

    public function  __construct($id = 0, $nci='',  $nom = '', $prenom = '', $date_naissance = '', $lieu_naissance = '', $url_recto = '', $url_verso = ''){

        $this->id = $id;
        $this->nci = $nci;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->date_naissance = $date_naissance;
        $this->lieu_naissance = $lieu_naissance;
        $this->url_recto = $url_recto;
        $this->url_verso = $url_verso;


    }


    /**
     * Get the value of id
     */ 
    public function getId(){return $this->id;}

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id){$this->id = $id;return $this;}

    /**
     * Get the value of nci
     */ 
    public function getNci(){return $this->nci;}

    /**
     * Set the value of nci
     *
     * @return  self
     */ 
    public function setNci($nci){$this->nci = $nci;return $this;}

    /**
     * Get the value of nom
     */ 
    public function getNom(){return $this->nom;}

    /**
     * Set the value of nom
     *
     * @return  self
     */ 
    public function setNom($nom){$this->nom = $nom;return $this;}

    /**
     * Get the value of prenom
     */ 
    public function getPrenom(){return $this->prenom;}

    /**
     * Set the value of prenom
     *
     * @return  self
     */ 
    public function setPrenom($prenom){$this->prenom = $prenom;return $this;}

    /**
     * Get the value of date_naissance
     */ 
    public function getDate_naissance(){return $this->date_naissance;}

    /**
     * Set the value of date_naissance
     *
     * @return  self
     */ 
    public function setDate_naissance($date_naissance){$this->date_naissance = $date_naissance;return $this;}

    /**
     * Get the value of lieu_naissance
     */ 
    public function getLieu_naissance(){return $this->lieu_naissance; }

    /**
     * Set the value of lieu_naissance
     *
     * @return  self
     */ 
    public function setLieu_naissance($lieu_naissance){$this->lieu_naissance = $lieu_naissance; return $this;}

    /**
     * Get the value of url_recto
     */ 
    public function getUrl_recto(){return $this->url_recto;}

    /**
     * Set the value of url_recto
     *
     * @return  self
     */ 
    public function setUrl_recto($url_recto){$this->url_recto = $url_recto;return $this;}

    /**
     * Get the value of url_verso
     */ 
    public function getUrl_verso(){return $this->url_verso;}

    /**
     * Set the value of url_verso
     *
     * @return  self
     */ 
    public function setUrl_verso($url_verso){$this->url_verso = $url_verso;return $this;}

    public static function toObject(array $data):static{
        return new static(
            $data['id'],
            $data['nci'],
            $data['nom'],
            $data['prenom'],
            $data['date_naissance'],
            $data['lieu_naissance'],
            $data['url_recto'],
            $data['url_verso']
        );
    }

     public function toArray(object $data): array{
       
         return [
            'id' => $data->getId(),
            'nci' => $data->getNci(),
            'nom' => $data->getNom(),
            'prenom' => $data->getPrenom(),
            'date_naissance' => $data->getDate_naissance(),
            'lieu_naissance' => $data->getLieu_naissance(),
            'url_recto' => $data->getUrl_recto(),
            'url_verso' => $data->getUrl_verso()
        ];
    }





}