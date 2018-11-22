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

    public function entreprise($idEnt='',$nEnt='',$dEnt='',$sitewebEnt='',$dateCreateEnt='',$idUtilisateur='',$suspendu='',$datedebSuspens='')
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

    public function insertEntBDD($data,$conn)
    {

      $SQL_Ent = "INSERT INTO entreprise (idEntreprise,nameEntreprise,descEntreprise) VALUES (NULL,'$data[nameEntreprise]','$data[descEntreprise]')";
      $conn->query($SQL_Ent); //INSERTION DES DONNEES DE LA NOUVELLE ENTREPRISE CRÉÉE PAR UN USER

      $SQL_Ent = "SELECT idEntreprise, INSEE FROM entreprise, ville WHERE nameEntreprise = '$data[nameEntreprise]' AND descEntreprise = '$data[descEntreprise]' AND INSEE = (SELECT INSEE FROM ville WHERE libvill = '$data[INSEE]' )";
      $req = $conn->query($SQL_Ent); //RECUPERATION DE L'ID DE L'ENTREPRISE QUI VIENT D'ETRE CRÉÉE
      $res = $req->fetch();

      $SQL_vilEnt = "INSERT INTO concerner VALUES ('$res[idEntreprise]','$res[INSEE]','$data[rueEntreprise]',0)";
      $conn->query($SQL_vilEnt); //INSERTION DE L'ADRESSE DE L'ENTREPRISE QUI VIENT D'ETRE CRÉÉE AVEC SON ID



    }
  }
?>
