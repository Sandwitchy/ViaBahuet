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

     public function stage($user,$entreprise,$ifOff,$libOff,$descOff,$exigOff,$status,$idStag,$dateComm,$contentComm,$datedebStag,$datefinstag,$descStag)
     {
       offre::offre($entreprise,$ifOff,$libOff,$descOff,$exigOff,$status);
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
  }
?>
