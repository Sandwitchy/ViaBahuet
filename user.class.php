<?php
  require("utilisateur.class.php");

  class user extends utilisateur //ENCAPSULATION DE ADRESSE DANS USER ET HERITE DE LA CLASSE UTILISATEUR
  {

    //DECLARATION DES VARIABLES DE LA CLASSE

    private $adresse;
    private $idUser;
    private $nameUser;
    private $preUser;
    private $mailUser;
    private $passUser;
    private $loginUser;
    private $telUser;
    private $photoUser;

    //INITIALISATION DU CONSTRUCTEUR DE LA CLASSE

    public function user($adresse,$idUtilisateur,$suspendu,$datedebSuspens,$idUser,$nUser,$pUser,$mUser,$passUser,$logUser,$telUser,$photoUser)
    {

      utilisateur::utilisateur($idUtilisateur,$suspendu,$datedebSuspens);
      $this->adresse    = $adresse;
      $this->idUser     = $idUser;
      $this->nameUser   = $nUser;
      $this->preUser    = $pUser;
      $this->mailUser   = $mUser;
      $this->passUser   = $passUser;
      $this->loginUser  = $logUser;
      $this->telUser    = $telUser;
      $this->photoUser  = $photoUser;
    }

    //INITIALISATION DES GETTERS DE LA CLASSE

    public function get_adresse()
    {
      return $this->adresse;
    }
    public function get_idUser()
    {
      return $this->idUser;
    }
    public function get_nameUser()
    {
      return $this->nameUser;
    }
    public function get_preUser()
    {
      return $this->preUser;
    }
    public function get_mailUser()
    {
      return $this->mailUser;
    }
    public function get_passUser()
    {
      return $this->passUser;
    }
    public function get_loginUser()
    {
      return $this->loginUser;
    }
    public function get_telUser()
    {
      return $this->telUser;
    }
    public function get_photoUser()
    {
      return $this->photoUser;
    }

    //INITIALISATION DES SETTERS DE LA CLASSE
    public function set_adresse($adresse)
    {
      $this->adresse = $adresse;
    }
    public function set_idUser($idUser)
    {
      $this->idUser = $idUser;
    }
    public function set_nameUser($nUser)
    {
      $this->nameUser = $nUser;
    }
    public function set_preUser($pUser)
    {
      $this->preUser = $pUser;
    }
    public function set_mailUser($mUser)
    {
      $this->mailUser = $mUser;
    }
    public function set_passUser($passUser)
    {
      $this->passUser = $passUser;
    }
    public function set_loginUser($logUser)
    {
      $this->loginUser = $logUser;
    }
    public function set_telUser($telUser)
    {
      $this->telUser = $telUser;
    }
    public function set_photoUser($photoUser)
    {
      $this->photoUser = $photoUser;
    }

  }

?>
