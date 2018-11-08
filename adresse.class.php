<?php

  class adresse //ENCAPSULATION DE VILLE DANS ADRESSE
  {

    //DECLARATION DES VARIABLES DE LA CLASSE

    private $ville;
    private $rueAdr;

    //INITIALISATION DU CONSTRUCTEUR DE LA CLASSE

    public function adresse($ville,$rueAdr)
    {
      $this->ville = $ville;
      $this->rueAdr = $rueAdr;
    }

    //INITIALISATION DES GETTERS DE LA CLASSE

    public function get_ville()
    {
      return $this->ville;
    }
    public function get_rueAdr()
    {
      return $this->rueAdr;
    }

    //INITIALISATION DES SETTERS DE LA CLASSE

    public function set_ville($ville)
    {
      $this->ville = $ville;
    }
    public function set_rueAdr($rueAdr)
    {
      $this->rueAdr = $rueAdr;
    }

  }

?>
