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
    private $typeUser;
    private $ville;

    //INITIALISATION DU CONSTRUCTEUR DE LA CLASSE

    public function user($idUser= "",$nUser= "",$pUser= "",$mUser= "",$passUser= "",$logUser= "",$adresse = "",$suspendu= "",$datedebSuspens= "",$telUser= "",$photoUser= "",$typeUser = "")
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
      $this->typeUser   = $typeUser;
    }

    //INITIALISATION DES GETTERS DE LA CLASSE

    public function get_adresse()
    {
      return $this->adresse;
    }
    public function get_typeUser()
    {
      return $this->typeUser;
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
    public function get_ville()
    {
      return $this->ville;
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
    public function set_typeUser($typeUser)
    {
      $this->typeUser = $typeUser;
    }
    public function set_preUser($pUser)
    {
      $this->preUser = $pUser;
    }
    public function set_mailUser($mUser)
    {
      $this->mailUser = $mUser;
    }
    public function set_ville($ville)
    {
      $this->ville = $ville;
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

    //INSCRIPTION USER de type MEMBRE
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
      $this -> set_typeUser($res_SQL['idTypeUser']);

      $this ->ville = new ville("","",$res_SQL['INSEE']);
      $this->ville->searchInfo($conn,$res_SQL['INSEE']);

      utilisateur::set_suspendu($res_SQL['suspendu']);
      utilisateur::set_datedebSuspens($res_SQL['datedebSuspens']);
    }
    //mise à jour des information essentiel de l'user exepté MDP
    public function updateUser($login,$nom,$prenom,$mail,$tel,$rue,$ville,$conn)
    {
      $id = $this->idUser;
      $this -> set_ville($ville);
      $INSEE = $this->ville->get_INSEE();
      $INSEE = $conn -> quote($INSEE);
      $this -> set_adresse($rue);
      $this -> set_nameUser($nom);
      $this -> set_preUser($prenom);
      $this -> set_mailUser($mail);
      $this -> set_loginUser($login);
      $this -> set_telUser($tel);
      $login = $conn -> quote($login);
      $nom = $conn -> quote($nom);
      $prenom = $conn -> quote($prenom);
      $mail = $conn -> quote($mail);
      $tel = $conn -> quote($tel);
      $rue = $conn -> quote($rue);
      $SQL_updateUser = "UPDATE user
                         SET loginUser = $login,
                             nameUser = $nom,
                             preUser = $prenom,
                             telUser = $tel,
                             mailUser = $mail,
                             rueUser = $rue,
                             INSEE = $INSEE
                          WHERE idUser = $id";
      $req_SQL = $conn -> query($SQL_updateUser);
    }
    /*
    fonction pour changer le pot de passe de l'user
    */
    public function changePass($old,$new,$confirm,$conn)
    {
      $id = $this->idUser;
      if ($new !== $confirm)
      {
        return false;
      }else
      {
        $SQL_PASS = "SELECT passUser FROM user WHERE idUser = '$id'";
        $req_PASS = $conn -> query($SQL_PASS);
        $res_Req = $req_PASS -> fetch();
        if ($old != $res_Req['passUser'])
        {
          return false;
        }else
        {
          $new = $conn -> quote($new);
          $SQL_newpass = "UPDATE user SET passUser = $new WHERE idUser = '$id'";
          $req_sql = $conn -> query($sql_User);
          return true;
        }
      }
    }
}
?>
