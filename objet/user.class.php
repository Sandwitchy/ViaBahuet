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
    private $descUser;
    private $tags;

    //INITIALISATION DU CONSTRUCTEUR DE LA CLASSE

    public function user($idUser= "",$nUser= "",$pUser= "",$mUser= "",$passUser= "",$logUser= "",$adresse = "",$suspendu= "",$datedebSuspens= "",$telUser= "",$photoUser= "",$typeUser = "",$descUser= "")
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
      $this->descUser   = $descUser;
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

    public function get_descUser()
    {
      return $this->descUser;
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
    public function set_descUser($descUser)
    {
      $this->descUser = $descUser;
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
      $this -> set_typeUser($res_SQL['idTypeUser']);
      $this ->ville = new ville("","",$res_SQL['INSEE']);
      $this->ville->searchInfo($conn,$res_SQL['INSEE']);
      $this-> set_descUser($res_SQL['descUser']);
      utilisateur::set_suspendu($res_SQL['suspendu']);
      utilisateur::set_datedebSuspens($res_SQL['datedebSuspens']);
    }
    //mise à jour des information essentiel de l'user exepté MDP
    public function updateUser($login,$nom,$prenom,$mail,$tel,$rue,$ville,$conn)
    {
      $id = $this->idUser;
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
      $INSEE = $ville->get_INSEE();
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
      return true;
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
      }
      else
      {
        $SQL_PASS = "SELECT passUser FROM user WHERE idUser = '$id'";
        $req_PASS = $conn -> query($SQL_PASS);
        $res_Req = $req_PASS -> fetch();
        if ($old != $res_Req['passUser'])
        {
          return false;
        }
        else
        {
          $new = $conn -> quote($new);
          $SQL_newpass = "UPDATE user SET passUser = $new WHERE idUser = '$id'";
          $req_sql = $conn -> query($SQL_newpass);
          return true;
        }
      }
    }

    public function selecttags($conn)
    {
      $id = $this->idUser;
      $sql = "SELECT t.idTags,libTags
              FROM tags t,taguser u
              WHERE t.idTags = u.idTags
              AND u.idUser = '$id'";
      $req = $conn->query($sql)or die($sql);
      $res = $req->fetchall(PDO::FETCH_ASSOC);
      if ($res == NULL)
      {
        return false;
      }
      else
      {
        return $res;
      }
    }
    public function createjointag2user($lib,$conn)
    {
      $lib = $conn -> quote($lib);
      $iduser = $this->idUser;
      $sql = "SELECT * FROM tags WHERE libTags LIKE $lib";
      $req = $conn -> query($sql)or die($sql);
      $res = $req -> fetch();
      if ($res != "")
      {
        $idt = $res['idTags'];
        $pmk = $idt."/".$iduser;
        $sql = "INSERT INTO taguser VALUES('$pmk','$idt','$iduser')";
        $req = $conn -> query($sql)or die($sql);
        return 1;
      }else {

        $sql = "INSERT INTO tags(libTags) VALUES($lib)";
        $req1 = $conn -> query($sql)or die($sql);
        $sql2 = "SELECT * FROM tags WHERE libTags = $lib";
        $req2 = $conn->query($sql2)or die($sql2);
        $res = $req2 -> fetch();
        $idt = $res['idTags'];
        $pmk = $idt."/".$iduser;
        $sql3 = "INSERT INTO taguser VALUES('$pmk','$idt','$iduser')";
        $req3 = $conn -> query($sql3)or die($sql3);
        return 0;
      }
    }

    public function checkFriend($myfriend,$conn)
    {
      $myId = $this->idUser;
      $SQL = "SELECT * FROM amis WHERE idUser1 = $myId AND idUser2 = $myfriend";
      $req = $conn->query($SQL);
      while($res = $req ->fetch())
      {
        if($res['idUser1'] == $myId AND $res['idUser2'] == $myfriend)
        {
          return true;
        }
        else {
          return false;
        }
      }
    }
    public function deletetags($libtags,$conn)
    {
      $sql = "SELECT idTags FROM tags WHERE libTags = '$libtags'";
      $req = $conn->query($sql);
      $res = $req -> fetch();
      $idtags = $res['idTags'];
      $iduser = $this->idUser;
      $sqldel = "DELETE FROM taguser WHERE idtags = $idtags AND iduser = $iduser";
      $req = $conn -> query($sqldel);
    }
    public function addavis($txt,$entreprise,$conn)
    {
      $identre = $entreprise->get_idEnt();
      $iduser = $this->idUser;
      if (strlen($txt) > 300)
      {
        return 1;
      }
      $txt = $conn -> quote($txt);
      $sql = "INSERT INTO avisentre VALUES($identre,$iduser,DATE( NOW() ),$txt);";
      $req = $conn ->query($sql);
      if($conn->errorCode() == 23000)//code erreur pmk existe déja
      {
        return 2;
      }
      return 0;
    }
    public function modavis($txt,$entreprise,$conn)
    {
      $identre = $entreprise->get_idEnt();
      $iduser = $this->idUser;
      if (strlen($txt) > 300)
      {
        return 1;
      }
      $txt = $conn -> quote($txt);
      $sql = "UPDATE avisentre SET avistxt = $txt,
                                   dateavis = DATE( NOW() )
                               WHERE idEntreprise = $identre
                               AND idUser = $iduser";
      $req = $conn ->query($sql);
      return 0;
    }
    public function delavis($oentre,$conn)
    {
      $identre = $oentre->get_idEnt();
      $iduser = $this->idUser;
      $sql = "DELETE FROM avisentre WHERE idEntreprise = $identre AND idUser = $iduser";
      $req = $conn -> query($sql);
      if ($conn->errorCode() != 0)
      {
        return 1;
      }else {
        return 0;
      }
    }

    /**
     * Fonction qui retourne le nombre de candidature de l'user
     */
    public function nbrCandidature($conn){
      $id = $this->idUser;

      $sql = "SELECT COUNT(idUser) FROM candidature WHERE idUser = $id";
      $req = $conn -> query($sql);
      $nbr =  $req -> fetch();
      return  $nbr[0];
    }
    /**
     * Check si l'user à déja postuler à l'offre
     * type = 0 -> stage
     *       = 1 -> emploi
     */
    public function checkIfStupid($conn,$idOffre,$type){
      $id = $this->idUser;

      if($type == 0){
        $sql = "SELECT idUser FROM candidature
                WHERE idStage = $idOffre ";
      }
      elseif($type == 1){
        $sql = "SELECT idUser FROM candidature
                WHERE idEmpOff = $idOffre ";
      }
      $req = $conn -> query($sql)or die($sql);
      $res = $req -> fetch();

      if(empty($res)){
        return false;
      }else{
        return true;
      }
    }
    /**
     * Procedure d'affichage des candidatures pour l'user
     */
    public function getCandidature($conn){
      $id = $this->idUser;

      $sql = "SELECT c.idCandidature, c.createdAt, s.libStage, c.status , ent.photoEnt , ent.nameEntreprise
              FROM candidature c
              INNER JOIN stage s ON s.idStage = c.idStage
              INNER JOIN entreprise ent ON ent.idEntreprise = s.idEntreprise
              WHERE c.idUser = $id
              ORDER BY c.createdAt DESC";

      $req = $conn -> query($sql)or die($sql);
      $stage = $req ->fetchAll(PDO::FETCH_ASSOC);

      $sql = "SELECT c.idCandidature, c.createdAt, e.libEmpOff, c.status , ent.photoEnt , ent.nameEntreprise  
              FROM candidature c
              INNER JOIN emploiOff e ON e.idEmpOff = c.idEmpOff
              INNER JOIN entreprise ent ON ent.idEntreprise = e.idEntreprise
              WHERE c.idUser = $id
              ORDER BY c.createdAt DESC";

      $req = $conn -> query($sql)or die($sql);
      $emploi = $req ->fetchAll(PDO::FETCH_ASSOC);

      /**
       * Affichage Stage
       */
      echo "<h2>Demande de stage</h2>";
      if(!empty($stage)){
      foreach($stage as $oneStage){
        ?>
        <div class='container-flex border border-secondary' style='padding:5px;margin:10px'>
            <div class='row'>
                <!-- IMAGE ENTREPRISE -->
                <div class='col-md-1' style='padding-right:5px;'>
                  <div class='vb-profilepic img-thumbnail' 
                  style=" background-image:url('../image/<?php echo $oneStage['photoEnt']?>');
                          width : 100%;
                          height:87px;">
                  </div>
                </div>
                <!-- COntenu -->
                <div class='col-md-11'>
                    <div class='row' style='margin-left:10px;'>
                      <div class='col-md-4'>
                        <p><u><b><?php echo $oneStage['nameEntreprise']; ?></u></b></p>
                      </div><div class='col-md-4'>
                        <p>Postulé le: <?php echo datetimeFr($oneStage['createdAt']); ?></p>
                      </div><div class='col-md-4'>
                        <p>Offre de stage</p>
                      </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-8'>
                            <p><i><b>Intitulé du Stage : </i></b><?php echo $oneStage['libStage'] ?></p>
                        </div>
                        <div class='col-md-1'>
                            <?php 
                              switch($oneStage['status']){
                                case 0 :
                                ?>
                                <span class="badge badge-warning">En attente</span>
                                <?php
                                break;
                                case 1 :
                                ?>
                                <span class="badge badge-danger">Refusé</span>
                                <?php
                                break;
                                case 3 :
                                ?>
                                <span class="badge badge-success">Accepté</span>
                                <?php
                                break;
                              }
                            ?>
                        </div>
                        <div class='col-md-3'>
                          <form method='post' action='../Back/postul.trait.php'>
                              <input type='hidden' value="<?php echo $oneStage['idCandidature']; ?>" name='candidature'>
                              <?php 
                              switch($oneStage['status']){
                                case 0 :
                                ?>
                                  <button type='submit'  name='delete' id='delete' class='btn btn-danger'>Annuler</button>
                                <?php
                                break;
                                case 1 :
                                ?>
                                  <button type='submit'  name='delete' id='delete' class='btn btn-danger'>Supprimer</button>
                                <?php
                                break;
                                case 3 :
                                ?>
                                  <button type='submit'  name='addStage' id='addStage' class='btn btn-success'>Ajouter à mon profil</button>
                                <?php
                                break;
                              }
                            ?>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
      }}
      /**
       * Affichage Offre d'emploi
       */
      echo "<h2>Offre d'emploi</h2>";
      if(!empty($emploi)){
      foreach($emploi as $oneEmp){
        ?>
        <div class='container-flex border border-secondary' style='padding:5px;margin:10px'>
            <div class='row'>
                <!-- IMAGE ENTREPRISE -->
                <div class='col-md-1' style='padding-right:5px;'>
                  <div class='vb-profilepic img-thumbnail' 
                  style=" background-image:url('../image/<?php echo $oneEmp['photoEnt']?>');
                          width : 100%;
                          height:87px;">
                  </div>
                </div>
                <!-- COntenu -->
                <div class='col-md-11'>
                    <div class='row' style='margin-left:10px;'>
                      <div class='col-md-4'>
                        <p><u><b><?php echo $oneEmp['nameEntreprise']; ?></u></b></p>
                      </div><div class='col-md-4'>
                        <p>Postulé le: <?php echo datetimeFr($oneEmp['createdAt']); ?></p>
                      </div><div class='col-md-4'>
                        <p>Offre d'emploi</p>
                      </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-8'>
                            <p><i><b>Intitulé du Stage : </i></b><?php echo $oneEmp['libEmpOff'] ?></p>
                        </div>
                        <div class='col-md-1'>
                            <?php 
                              switch($oneEmp['status']){
                                case 0 :
                                ?>
                                <span class="badge badge-warning">En attente</span>
                                <?php
                                break;
                                case 1 :
                                ?>
                                <span class="badge badge-danger">Refusé</span>
                                <?php
                                break;
                                case 3 :
                                ?>
                                <span class="badge badge-success">Accepté</span>
                                <?php
                                break;
                              }
                            ?>
                        </div>
                        <div class='col-md-3'>
                          <form method='post' action='../Back/postul.trait.php'>
                              <input type='hidden' value="<?php echo $oneEmp['idCandidature']; ?>" name='candidature'>
                              <?php 
                              switch($oneEmp['status']){
                                case 0 :
                                ?>
                                  <button type='submit'  name='delete' id='delete' class='btn btn-danger'>Annuler</button>
                                <?php
                                break;
                                case 1 :
                                ?>
                                  <button type='submit' name='delete' id='delete' class='btn btn-danger'>Supprimer</button>
                                <?php
                                break;
                                case 3 :
                                ?>
                                  <button type='submit' name='addEmp' id='addEmp' class='btn btn-success'>Ajouter à mon profil</button>
                                <?php
                                break;
                              }
                            ?>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
      }
    }
    }
}

?>
