<?php


  class stage extends offre //HERITE DE LA CLASSE OFFRE ET ENCAPSULATION DE LA CLASSE USER
  {

     //DECLARATION DES VARIABLES DE LA CLASSE

     private $user;
     private $idStag;
     private $dateComm;
     private $contentComm;
     private $datedebStag;
     private $datefinstag;
     private $descStag;

     //INITIALISATION DU CONSTRUCTEUR DE LA CLASSE

     public function stage($user="",$entreprise="",$descStag="",$datedebStag="",$datefinstag="",$libOff="",$descOff="",$exigOff="",$status="",$idStag="",$dateComm="",$contentComm="",$idOff="")
     {
       offre::offre($entreprise,$idOff,$libOff,$descOff,$exigOff,$status);
       $this->user = $user;
       $this->idStag = $idStag;
       $this->dateComm = $dateComm;
       $this->contentComm = $contentComm;
       $this->datedebStag = $datedebStag;
       $this->datefinStag = $datefinstag;
       $this->descStag = $descStag;
     }

      //INITIALISATION DES GETTERS DE LA CLASSE

      public function get_user()
      {
        return $this->user;
      }
      public function get_idStag()
      {
        return $this->idStag;
      }
      public function get_dateComm()
      {
        return $this->dateComm;
      }
      public function get_contentComm()
      {
        return $this->contentComm;
      }
      public function get_datedebStag()
      {
        return $this->datedebStag;
      }
      public function get_datefinStag()
      {
        return $this->datefinStag;
      }
      public function get_descStag()
      {
        return $this->descStag;
      }

      //INITIALISATION DES GETTERS DE LA CLASSE
      public function set_user($user)
      {
        $this->user = $user;
      }
      public function set_dateComm($dateComm)
      {
        $this->dateComm = $dateComm;
      }
      public function set_contentComm($contentComm)
      {
        $this->contentComm = $contentComm;
      }
      public function set_datedebStag($datedebStag)
      {
        $this->datedebStag = $datedebStag;
      }
      public function set_datefinStag($datefinStag)
      {
        $this->datefinStag = $datefinStage;
      }
      public function set_descStag($descStag)
      {
        $this->descStag = $descStage;
      }
      //création d'un stage sans passer par offre
      public function creastage($conn)
      {
        $user = $this->user;
        $user = $conn -> quote($user);
        $entreprise = offre::get_entreprise();
        $entreprise = $conn -> quote($entreprise);
        $descStag = $this->descStag;
        $descStag = $conn -> quote($descStag);
        $datedeb= $this->datedebStag;
        $datedeb = $conn -> quote($datedeb);
        $datefin = $this->datefinStag;
        $datefin = $conn -> quote($datefin);
        $libOff = offre::get_libOff();
        $libOff = $conn -> quote($libOff);

        $sql = "INSERT INTO stage (idUser,idEntreprise,datedebStage,datefinStage,descStage,libStage) VALUES($user,$entreprise,$datedeb,$datefin,$descStag,$libOff)";
        $req = $conn -> query($sql)or die($sql);
      }

      //création d'un offre de stage par une ENTREPRISE
      public function StageEnt($lib,$desc,$DD,$DF,$idEnt,$exig,$conn)
      {
        $SQL = "INSERT INTO stage (idStage,libstage,descstage,datedebStage,datefinStage,status,idEntreprise,exiStage)
                VALUES (NULL,'$lib','$desc','$DD','$DF',0,'$idEnt','$exig')";
        $conn->query($SQL) or die($SQL);
      }
  }
?>
