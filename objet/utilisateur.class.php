<?php

  abstract class utilisateur
  {

    //DECLARATION DES VARIABLES DE LA CLASSE

    private $idUtilisateur;
    private $suspendu;
    private $datedebSuspens;

    //INITIALISATION DU CONSTRUCTEUR DE LA CLASSE


    public function utilisateur($id="",$suspens="",$date="")
    {

      $this->idUtilisateur = $id;
      $this->suspendu = $suspens;
      $this->datedebSuspens = $date;

    }

    //INITIALISATION DES GETTERS DE LA CLASSE

    public function get_idUtilisateur()
    {
      return $this->idUtilisateur;
    }
    public function get_suspendu()
    {
      return $this->suspendu;
    }
    public function get_datedebSuspens()
    {
      return $this->datedebSuspens;
    }
    //INITIALISATION DES SETTERS DE LA CLASSE

    public function set_suspendu($suspens)
    {
      $this->suspendu = $suspens;
    }
    public function set_datedebSuspens($date)
    {
      $this->datedebSuspens = $date;
    }
    abstract public function recupUser($conn);
    abstract public function deletetags($libtags,$conn);
  }
?>
