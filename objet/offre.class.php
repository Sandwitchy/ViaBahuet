<?php

  class offre extends Controller
  {

    //DECLARATION DES VARIABLES DE LA CLASSE

    private $entreprise;
    private $idOff;
    private $libOff;
    private $descOff;
    private $exigOff;
    private $status;

    //INITIALISATION DU CONSTRUCTEUR DE LA CLASSE

    public function offre($entreprise,$idOff,$libOff,$descOff,$exigOff,$status)
    {
      $this->$entreprise = $entreprise;
      $this->idOff = $idOff;
      $this->libOff = $libOff;
      $this->descOff = $descOff;
      $this->exigOff = $exigOff;
      $this->status = $status;
    }

    //INITIALISATION DES GETTERS DE LA CLASSE

    public function get_entreprise()
    {
      return $this->entreprise;
    }
    public function get_idOff()
    {
      return $this->idOff;
    }
    public function get_libOff()
    {
      return $this->libOff;
    }
    public function get_exigOff()
    {
      return $this->exigOff;
    }
    public function get_status()
    {
      return $this->status;
    }

    //INITIALISATION DES SETTERS DE LA CLASSE

    public function set_entreprise($entreprise)
    {
      $this->entreprise = $entreprise;
    }
    public function set_idOff($idOff)
    {
      $this->ifOff = $idOff;
    }
    public function set_libOff($libOff)
    {
      $this->libOff = $libOff;
    }
    public function set_exigOff($exigOff)
    {
      $this->exigOff = $exigOff;
    }
    public function set_status($status)
    {
      $this->status = $status;
    }
  }

?>
