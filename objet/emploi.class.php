<?php


  class emploi extends offre //HERITE DE LA CLASSE OFFRE
  {

    //DECLARATION DES VARIABLES DE LA CLASSE

    private $salaireMoisBrut;

    //INITIALISATION DU CONSTRUCTEUR DE LA CLASSE

    public function emploi($entreprise,$ifOff,$libOff,$descOff,$exigOff,$status,$salaireMoisBrut)
    {
      offre::offre($entreprise,$ifOff,$libOff,$descOff,$exigOff,$status);
      $this->salaireMoisBrut = $salaireMoisBrut;
    }

    //INITIALISATION DES GETTERS DE LA CLASSE

    public function get_salaireMoisBrut()
    {
      return $this->salaireMoisBrut;
    }

    //INITIALISATION DES SETTERS DE LA CLASSE

    public function set_salaireMoisBrut($salaireMoisBrut)
    {
      $this->salaireMoisBrut = $salaireMoisBrut;
    }

  }

?>
