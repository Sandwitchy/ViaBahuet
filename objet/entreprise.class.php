<?php


  class entreprise extends utilisateur //HERITE DE LA CLASSE UTILISATEUR
  {

    //DECLARATION DES VARIABLES DE LA CLASSE

    private $idEnt;
    private $nameEnt;
    private $descEnt;
    private $sitewebEnt;
    private $dateCreateEnt;

    //INITIALISATION DU CONSTRUCTEUR DE LA CLASSE

    public function entreprise($idUtilisateur,$suspendu,$datedebSuspens,$idEnt,$nEnt,$dEnt,$sitewebEnt,$dateCreateEnt)
    {
      utilisateur::utilisateur($idUtilisateur,$suspendu,$datedebSuspens);
      $this->idEnt         = $idEnt;
      $this->nameEnt       = $nEnt;
      $this->descEnt       = $dEnt;
      $this->sitewebEnt    = $sitewebEnt;
      $this->dateCreateEnt = $dateCreateEnt;
    }

    //INITIALISATION DES GETTERS DE LA CLASSE

    public function get_idEnt()
    {
      return $this->idEnt;
    }
    public function get_nameEnt()
    {
      return $this->nameEnt;
    }
    public function get_descEnt()
    {
      return $this->descEnt;
    }
    public function get_dateCreateEnt()
    {
      return $this->dateCreateEnt;
    }

    //INITIALISATION DES SETTERS DE LA CLASSE

    public function set_nameEnt($nEnt)
    {
      $this->nameEnt = $nEnt;
    }
    public function set_descEnt($dEnt)
    {
      $this->descEnt = $dEnt;
    }
    public function set_dateCreateEnt($dateCreateEnt)
    {
      $this->dateCreateEnt = $dateCreateEnt;
    }

  }
?>
