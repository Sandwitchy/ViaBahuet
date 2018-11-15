<?php

  class ville
  {

    //DECLARATION DES VARIABLES DE LA CLASSE

    private $INSEE;
    private $libVil;
    private $CP;

    //INITIALISATION DU CONSTRUCTEUR DE LA CLASSE

    public function ville($INSEE,$liVil,$CP)
    {
      $this->INSEE = $INSEE;
      $this->libVil = $libVil;
      $this->CP = $CP;
    }

    //INITIALISATION DES GETTERS DE LA CLASSE

    public function get_INSEE()
    {
      return $this->INSEE;
    }
    public function get_libVil()
    {
      return $this->libVil;
    }
    public function get_CP()
    {
      return $this->CP;
    }

    //INITIALISATION DES SETTERS DE LA CLASSE

    public function set_libVil($libVil)
    {
      $this->libVil = $libVil;
    }
    public function set_CP($CP)
    {
      $this->CP = $CP;
    }
  }

?>
