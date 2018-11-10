<?php
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

    public function user($idUser= "",$nUser= "",$pUser= "",$mUser= "",$passUser= "",$logUser= "",$adresse = "",$suspendu= "",$datedebSuspens= "",$telUser= "",$photoUser= "")
    {
      utilisateur::utilisateur($suspendu,$datedebSuspens);
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

    //INSCRIPTION USER MEMBRE
    public function registeruser($conn,$nUser,$pUser,$mUser,$passUser,$logUser)
    {
      //sécurise les variable contre InjectionSQL
      $nUser = $conn -> quote($nUser);
      $pUser = $conn -> quote($pUser);
      $mUser = $conn -> quote($mUser);
      $passUser = $conn -> quote($passUser);
      $logUser = $conn -> quote($logUser);
      //Insert du nouveau membre
      $sql_InsertUser = "INSERT INTO user (nameUser,preUser,mailUser,passUser,loginUser,idTypeUser)
                         VALUES($nUser,$pUser,$mUser,$passUser,$logUser,'1')";
      $req_SQL = $conn->query($sql_InsertUser)or die($sql_InsertUser);
    }
    //récuperation des infos user
    public function recupUser($conn)
    {
      $idUser = $this -> get_idUser();
      $idUser = $conn -> quote($idUser);
      $sql_User = "SELECT * FROM user WHERE idUser = $idUser";
      $req_SQL = $conn -> query($sql_User);
      $res_SQL = $req_SQL -> fetch();

      $this -> set_adresse($res_SQL['rueUser']);
      $this -> set_nameUser($res_SQL['nameUser']);
      $this -> set_preUser($res_SQL['preUser']);
      $this -> set_mailUser($res_SQL['mailUser']);
      $this -> set_passUser($res_SQL['passUser']);
      $this -> set_loginUser($res_SQL['loginUser']);
      $this -> set_telUser($res_SQL['telUser']);
      $this -> set_photoUser($res_SQL['photoUser']);
      utilisateur::set_suspendu($res_SQL['suspendu']);
      utilisateur::set_datedebSuspens($res_SQL['datedebSuspens']);
    }
  }

?>
