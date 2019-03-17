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
    private $taille;

    //INITIALISATION DU CONSTRUCTEUR DE LA CLASSE

    public function entreprise($idEnt='',$nEnt='',$dEnt='',$sitewebEnt='',$dateCreateEnt='',$idUtilisateur='',$suspendu='',$taille = "",$datedebSuspens='',$ville = "")
    {
      utilisateur::utilisateur($idUtilisateur,$suspendu,$datedebSuspens);
      $this->idEnt         = $idEnt;
      $this->nameEnt       = $nEnt;
      $this->descEnt       = $dEnt;
      $this->sitewebEnt    = $sitewebEnt;
      $this->dateCreateEnt = $dateCreateEnt;
      $this->ville         = $ville;
      $this->taille        = $taille;
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
    public function get_taille()
    {
      return $this->taille;
    }
    //INITIALISATION DES SETTERS DE LA CLASSE
    public function set_taille($taille)
    {
      $this->taille = $taille;
    }
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
        /*
    fonction pour changer le pot de passe de l'user
    */
    public function changePass($old,$new,$confirm,$conn)
    {
      $id = $this->idEnt;
      if ($new !== $confirm)
      {
        return false;
      }
      else
      {
        $SQL_PASS = "SELECT passEntreprise FROM entreprise WHERE idEntreprise = '$id'";
        $req_PASS = $conn -> query($SQL_PASS);
        $res_Req = $req_PASS -> fetch();
        if ($old != $res_Req['passEntreprise'])
        {
          return false;
        }
        else
        {
          $new = $conn -> quote($new);
          $SQL_newpass = "UPDATE entreprise SET passEntreprise = $new WHERE idEntreprise = '$id'";
          $req_sql = $conn -> query($SQL_newpass);
          return true;
        }
      }
    }
    //mise à jour des information essentiel de l'user exepté MDP
    public function updateEntreprise($login,$nom,$mail,$taille,$site,$conn)
    {
      $id = $this->idEnt;
      $this -> set_taille($taille);
      $this -> set_nameEnt($nom);
      $this -> set_mailEnt($mail);
      $this -> set_loginEnt($login);
      $this-> set_siteweb($site);
      $site = $conn->quote($site);
      $taille = $conn->quote($taille);
      $login = $conn -> quote($login);
      $nom = $conn -> quote($nom);
      $mail = $conn -> quote($mail);
      $SQL_updateUser = "UPDATE entreprise
                         SET loginEntreprise = $login,
                             nameEntreprise = $nom,
                             mailEntreprise = $mail,
                             idTailleEntreprise = $taille,
                             siteWebEntreprise = $site
                          WHERE idEntreprise = $id";
      $req_SQL = $conn -> query($SQL_updateUser)or die($SQL_updateUser);
      return true;
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
        }
        else
        {
          $sql = "INSERT INTO tags VALUES(NULL,$lib)";
          $req1 = $conn -> query($sql) or die($sql);

          $sql2 = "SELECT * FROM tags WHERE libTags = $lib";
          $req2 = $conn->query($sql2);
          $res = $req2 -> fetch();
          $idt = $res['idTags'];
          $pmk = $idt."/".$iduser;
          $sql3 = "INSERT INTO tagent VALUES('$pmk','$idt','$iduser')";
          $req3 = $conn -> query($sql3) or die($sql);
          return 0;
        }
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
    /**
     * Procédure qui Met à jour une candidature à "refus"
     */
    public function refuseCandidature($idc,$conn){
      $sql = "UPDATE candidature SET status = 1 WHERE idCandidature = $idc";
      $req = $conn->query($sql);

    }
    /**
     * Procédure d'acceptation de candidature
     * Refuse automatiquement les autres candidature affilié à l'offre
     */
    public function acceptCandidature($idc,$conn){
      // accept la candidature
      $sql = "UPDATE candidature SET status = 3 WHERE idCandidature = $idc";
      $req = $conn->query($sql)or die($sql);

      // refuse les autres candidature associé à la même offre
      // récupère info offre
      $sql = "SELECT typeOffre, idStage , idEmpOff FROM candidature WHERE idCandidature = $idc";
      $req = $conn -> query($sql)or die($sql);
      $res = $req -> fetch(PDO::FETCH_ASSOC);
      var_dump($res);
      if($res['typeOffre'] == 0){
        // offre est un stage
        $ids = $res['idStage'];
        $sql = "UPDATE candidature SET status = 1
                WHERE idStage = $ids
                AND idCandidature <> $idc";
      }else{
        //offre est un emploi
        $ide = $res['idEmpOff'];
        $sql = "UPDATE candidature SET status = 1
        WHERE idEmpOff = $ide
        AND idCandidature <> $idc";
      }
      $req = $conn -> query($sql)or die($sql);
      // archive l'offre 
      if($res['typeOffre'] == 0){
        //offre est stage
        $sql = "UPDATE stage SET status = 1 WHERE idStage = $ids";
      }else{
        $sql = "UPDATE emploidff SET statusEmpOff = 1 WHERE idEmpOff = $ide";
      }
      $req = $conn -> query($sql)or die($sql);

    }
     /**
     * Procedure d'affichage des candidatures pour l'entreprise
     */
    public function getCandidature($conn){
      $id = $this->idEnt;

      $sql = "SELECT c.idCandidature,u.idUser, c.createdAt, s.libStage, c.status , u.photoUser , u.nameUser, u.preUser
              FROM candidature c
              INNER JOIN stage s ON s.idStage = c.idStage
              INNER JOIN user u ON u.idUser = c.idUser
              WHERE s.idEntreprise = $id
              AND c.status = 0
              ORDER BY c.createdAt DESC";

      $req = $conn -> query($sql)or die($sql);
      $stage = $req ->fetchAll(PDO::FETCH_ASSOC);

      $sql = "SELECT c.idCandidature,u.idUser, c.createdAt, e.libEmpOff, c.status , u.photoUser , u.nameUser, u.preUser  
              FROM candidature c
              INNER JOIN emploiOff e ON e.idEmpOff = c.idEmpOff
              INNER JOIN user u ON u.idUser = c.idUser
              WHERE e.idEntreprise = $id
              AND c.status = 0
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
                  style=" background-image:url('../image/<?php echo $oneStage['photoUser']?>');
                          width : 100%;
                          height:87px;">
                  </div>
                </div>
                <!-- COntenu -->
                <div class='col-md-11'>
                    <div class='row' style='margin-left:10px;'>
                      <div class='col-md-4'>
                        <p><u><b><?php echo $oneStage['nameUser']." ".$oneStage['preUser']; ?></u></b></p>
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
                             
                             <button type='submit'  name='refuse' id='refuse' class='btn btn-danger'>Refuser</button>
                             <button type='submit'  name='accept' id='accept' class='btn btn-success'>Accepter</button>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
      }
    }else{
      echo "Aucune réponse à vos candidatures";
    }
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
                  style=" background-image:url('../image/<?php echo $oneEmp['photoUser']?>');
                          width : 100%;
                          height:87px;">
                  </div>
                </div>
                <!-- COntenu -->
                <div class='col-md-11'>
                    <div class='row' style='margin-left:10px;'>
                      <div class='col-md-4'>
                        <a href="#profileOther.php?user=<?php echo $oneStage['idUser']; ?>"> 
                          <p><u><b><?php echo $oneEmp['nameUser']." ".$oneEmp['preUser']; ?></u></b></p>
                        </a>
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
                             
                                  <button type='submit'  name='refuse' id='refuse' class='btn btn-danger'>Refuser</button>
                                  <button type='submit'  name='accept' id='accept' class='btn btn-success'>Accepter</button>
                          </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
      }
    }else{
      echo "Aucune réponse à vos candidatures";
    }
    }
  }
?>
