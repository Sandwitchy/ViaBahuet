<?php

  class travail //ENCAPSULATION DE USER DANS TRAVAIL
  {

    //DECLARATION DES VARIABLES DE LA CLASSE

    private $user;
    private $idTrav;
    private $commTrav;
    private $datedebTrav;
    private $actualTrav;

    //INITIALISATION DU CONSTRUCTEUR DE LA CLASSE

    public function travail($user,$idTrav,$commTrav,$datedebTrav,$actualTrav)
    {
      $this->user = $user;
      $this->idTrav = $idTrav;
      $this->commTrav = $commTrav;
      $this->datedebTrav = $datedebTrav;
      $this->actualTrav = $actualTrav;
    }

    //INITIALISATION DES GETTERS DE LA CLASSE

    public function get_user()
    {
      return $this->user;
    }
    public function get_idTrav()
    {
      return $this->idTrav;
    }
    public function get_commTrav()
    {
      return $this->commTrav;
    }
    public function get_datedebTrav()
    {
      return $this->datedebTrav;
    }
    public function get_actualTrav()
    {
      return $this->actualTrav;
    }

    //INITIALISATION DES SETTERS DE LA CLASSE

    public function set_user($user)
    {
      $this->user = $user;
    }
    public function set_commTrav($commTrav)
    {
      $this->commTrav = $commTrav;
    }
    public function set_datedebTrav($datedebTrav)
    {
      $this->datedebTrav = $datedebTrav;
    }
    public function set_actualTrav($actualTrav)
    {
      $this->actualTrav = $actualTrav;
    }

  }

?>
