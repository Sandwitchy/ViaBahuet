<?php


  class entreprise extends utilisateur //HERITE DE LA CLASSE UTILISATEUR
  {

    //DECLARATION DES VARIABLES DE LA CLASSE

    private $idEnt;
    private $nameEnt;
    private $descEnt;
    private $sitewebEnt;
    private $dateCreateEnt;
    private $ville;
    private $login;
    private $pass;
    private $photoEnt;
    private $typeEnt;
    private $mailEnt;
    private $telEnt;

    //INITIALISATION DU CONSTRUCTEUR DE LA CLASSE

    public function entreprise($idEnt='',$nEnt='',$dEnt='',$sitewebEnt='',$dateCreateEnt='',$idUtilisateur='',$suspendu='',$datedebSuspens='',$ville = "")
    {
      utilisateur::utilisateur($idUtilisateur,$suspendu,$datedebSuspens);
      $this->idEnt         = $idEnt;
      $this->nameEnt       = $nEnt;
      $this->descEnt       = $dEnt;
      $this->sitewebEnt    = $sitewebEnt;
      $this->dateCreateEnt = $dateCreateEnt;
      $this->ville         = $ville;
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
    public function get_villeEnt()
    {
      return $this->ville;
    }
    public function get_loginEnt()
    {
      return $this->login ;
    }
    public function get_mailEnt()
    {
      return $this->mail;
    }
    public function get_passEnt()
    {
      return $this->pass;
    }
    public function get_telEnt()
    {
      return $this->telEnt;
    }
    public function get_photoEnt()
    {
     return  $this->photoEnt;
    }
    public function get_siteweb()
    {
      return $this->sitewebEnt;
    }
    //INITIALISATION DES SETTERS DE LA CLASSE
    public function set_siteweb($web)
    {
      $this->sitewebEnt = $web;
    }
    public function set_photoEnt($photoEnt)
    {
      $this->photoEnt = $photoEnt;
    }
    public function set_telEnt($telEnt)
    {
      $this->telEnt = $telEnt;
    }
    public function set_nameEnt($nEnt)
    {
      $this->nameEnt = $nEnt;
    }
    public function set_dateCreateEnt($dateCreateEnt)
    {
      $this->dateCreateEnt = $dateCreateEnt;
    }
    public function set_vileEnt($ville)
    {
      $this->$ville = $ville;
    }
    public function set_loginEnt($login)
    {
      $this->login = $login;
    }
    public function set_mailEnt($mail)
    {
      $this->mail = $mail;
    }
    public function set_passEnt($pass)
    {
      $this->pass = $pass;
    }
    public function set_descEnt($desc)
    {
      $this->descEnt = $desc;
    }
    public function recupUser($conn)
    {
      $idUser = $this -> get_idEnt();
      $idUser = $conn -> quote($idUser);
      $sql_User = "SELECT * FROM entreprise e, concerner c,ville v WHERE e.idEntreprise = c.idEntreprise
                                                                   AND c.INSEE = v.INSEE
                                                                   AND e.idEntreprise = $idUser";
      $req_SQL = $conn -> query($sql_User);
      if ($req_SQL == false)
      {
        return 1;
      }
      $res_SQL = $req_SQL -> fetch();

      $this -> set_nameEnt($res_SQL['nameEntreprise']);
      $this -> set_mailEnt($res_SQL['mailEntreprise']);
      $this -> set_passEnt($res_SQL['passEntreprise']);
      $this -> set_loginEnt($res_SQL['loginEntreprise']);
      $this ->ville = new ville($res_SQL['libVill'],$res_SQL['CP'],$res_SQL['INSEE']);
      $this-> set_descEnt($res_SQL['descEntreprise']);
      utilisateur::set_suspendu($res_SQL['suspendu']);
      $this -> set_photoEnt($res_SQL['photoEnt']);
      return 0;
      //utilisateur::set_datedebSuspens($res_SQL['dateSuspensdeb']);
    }

    public function insertEntBDD($data,$conn)
    {
      $desc = $conn->quote($data['descEntreprise']);
      $SQL_Ent = "INSERT INTO entreprise (idEntreprise,nameEntreprise,descEntreprise) VALUES (NULL,'$data[nameEntreprise]',$desc)";
      $conn->query($SQL_Ent)or die($SQL_Ent); //INSERTION DES DONNEES DE LA NOUVELLE ENTREPRISE CRÉÉE PAR UN USER

      $SQL_Ent = "SELECT idEntreprise, INSEE FROM entreprise, ville WHERE nameEntreprise = '$data[nameEntreprise]' AND descEntreprise = $desc AND INSEE = (SELECT INSEE FROM ville WHERE libvill = '$data[INSEE]' )";
      $req = $conn->query($SQL_Ent)or die($SQL_Ent); //RECUPERATION DE L'ID DE L'ENTREPRISE QUI VIENT D'ETRE CRÉÉE
      $res = $req->fetch();

      $SQL_vilEnt = "INSERT INTO concerner VALUES ('$res[idEntreprise]','$res[INSEE]','$data[rueEntreprise]',0)";
      $conn->query($SQL_vilEnt)or die($SQL_vilEnt); //INSERTION DE L'ADRESSE DE L'ENTREPRISE QUI VIENT D'ETRE CRÉÉE AVEC SON ID
    }
    //check si l'entreprise à déja été inscrite par un user
    public function checkifexist($name,$conn)
    {
      $name = $conn -> quote("%".$name."%");
      $sql_check = "SELECT e.idEntreprise,createbyuser,nameEntreprise,rueEntreprise,libVill,descEntreprise
                    FROM entreprise e,concerner c,ville v
                    WHERE e.idEntreprise = c.idEntreprise
                    AND c.INSEE = v.INSEE
                    AND e.nameEntreprise LIKE $name";
      $req_check = $conn ->query($sql_check)or header("index.php?error=4");
      if(($req_check -> rowCount() == 0) && ($req_check == false))
      {
        return false;
      }else{
        $res = $req_check->fetchall(PDO::FETCH_ASSOC);
        return $res;
      }
    }
    //inscription d'un compte Entreprise
    public function registeruserentreprise($conn,$var_NameUser,$var_MailUser,$var_PassUser,$var_IdentifiantUser,$INSEE,$rue,$id)
    {
      $var_NameUser = $conn -> quote($var_NameUser);
      $var_MailUser = $conn -> quote($var_MailUser);
      $var_PassUser = $conn -> quote($var_PassUser);
      $var_IdentifiantUser = $conn -> quote($var_IdentifiantUser);
      $rue = $conn -> quote($rue);
      $INSEE = $conn -> quote($INSEE);
      if ($id == 'none')
      {
        $sql = "INSERT INTO entreprise (nameEntreprise,mailEntreprise,passEntreprise,loginEntreprise,createbyuser)
                    VALUES($var_NameUser,$var_MailUser,$var_PassUser,$var_IdentifiantUser,0)";
        $req_sql = $conn -> query($sql)or die($sql);
        $sqlid = "SELECT idEntreprise
                  FROM entreprise
                  WHERE nameEntreprise = $var_NameUser
                  AND mailEntreprise = $var_MailUser
                  AND passEntreprise = $var_PassUser
                  AND loginEntreprise = $var_IdentifiantUser";
        $req_sqlid = $conn -> query($sqlid)or die($sqlid);
        $res = $req_sqlid -> fetch();
        $id = $res['idEntreprise'];
        $sqlville = "INSERT INTO concerner VALUES($id,$INSEE,$rue,0)";
        $req_ville = $conn ->query($sqlville)or $error = 1;
      }else {
        $sql = "UPDATE entreprise SET nameEntreprise = $var_NameUser,
                                          mailEntreprise = $var_MailUser,
                                          passEntreprise = $var_PassUser,
                                          loginEntreprise = $var_IdentifiantUser,
                                          createbyuser = 0
                                      WHERE idEntreprise = '$id'";
        $req_sql = $conn -> query($sql)or die($sql);
        $sqlville = "UPDATE concerner SET INSEE = $INSEE , rueEntreprise = $rue WHERE idEntreprise = '$id'";
        $req_ville = $conn ->query($sqlville)or die($sqlville);
      }
    }

    public function selecttags($conn)
    {
      $id = $this->idEnt;
      $sql = "SELECT t.idTags,libTags
              FROM tags t,tagent e
              WHERE t.idTags = e.idTags
              AND e.idEntreprise = '$id'";
      $req = $conn->query($sql)or die($sql);
      $res = $req->fetchall(PDO::FETCH_ASSOC);
      if ($res == NULL)
      {
        return false;
      }else {
        return $res;
      }
    }
    public function createjointag2user($lib,$conn)
    {
      $lib = $conn -> quote($lib);
      $iduser = $this->idEnt;
        $sql = "SELECT * FROM tags WHERE libTags LIKE $lib";
        $req = $conn -> query($sql) or die($sql);
        $res = $req -> fetch();
        if ($res != "")
        {
          $idt = $res['idTags'];
          $pmk = $idt."/".$iduser;
          $sql = "INSERT INTO tagent VALUES('$pmk','$idt','$iduser')";
          $req = $conn -> query($sql) or die($sql);
          return 1;
        }else {
<<<<<<< HEAD
          $sql = "INSERT INTO tags VALUES(NULL,$lib)";
          $req1 = $conn -> query($sql) or die($sql);
=======
          $sql = "INSERT INTO tags VALUES('',$lib)";
          $req1 = $conn -> query($sql);
>>>>>>> 34c6be20f27d11201116746c179ab1193ea89bb8
          $sql2 = "SELECT * FROM tags WHERE libTags = $lib";
          $req2 = $conn->query($sql2);
          $res = $req2 -> fetch();
          $idt = $res['idTags'];
          $pmk = $idt."/".$iduser;
          $sql3 = "INSERT INTO tagent VALUES('$pmk','$idt','$iduser')";
          $req3 = $conn -> query($sql3) or die($sql);
          return 0;
        }
<<<<<<< HEAD
      }else {
        $pmk = $id."/".$iduser;
        $sql ="INSERT INTO tagent VALUES('$pmk','$id','$iduser')";
        $req = $conn -> query($sql) or die($sql);
        return 2;
      }
=======
>>>>>>> 34c6be20f27d11201116746c179ab1193ea89bb8
    }
    public function deletetags($libtags,$conn)
    {
      $sql = "SELECT idTags FROM tags WHERE libTags = '$libtags'";
      $req = $conn->query($sql);
      $res = $req -> fetch();
      $idtags = $res['idTags'];
      $iduser = $this->idEnt;
      $sqldel = "DELETE FROM tagent WHERE idtags = $idtags AND idEntreprise = $iduser";
      $req = $conn -> query($sqldel);

    }
    public function afficheAllOffres($conn)
    {
      $idEnt = $this->idEnt;
      $SQL_offre = "SELECT * FROM emploioff e,stage s WHERE e.idEntreprise = '$idEnt'AND s.idEntreprise = '$idEnt'";
      $req = $conn->query($SQL_offre) or die($SQL_offre);
      $res = $req->fetchall(PDO::FETCH_ASSOC);

      return $res;

    }
  }
?>
