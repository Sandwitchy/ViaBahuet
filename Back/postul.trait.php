<?php
  include('../tools/bdd.inc.php');
  include('../objet/callClass.php');

  if(session_id() == '' || !isset($_SESSION)) {
    // session isn't started
    session_start();
  }
  if (!isset($_SESSION['user_info'])) //verifie si un user c'est correctement connecté sinon revoie vers la page de connexion
  {
      echo "<script type='text/javascript'>document.location.replace('../publique/index.php');</script>";
  }else {
      $_SESSION['user_info'] ->recupUser($conn);
      $GLOBAL_ouser = $_SESSION['user_info']; // définition de la variable global de l'user connecter
  }

  // AJOUT CANDIDATURE STAGE
  if(isset($_POST['offreStage'])){
    $id = $GLOBAL_ouser->get_idUser();
    $idStage = $_POST['offreStage'];

    $sql = "INSERT INTO candidature(createdAt,idUser,idStage,typeOffre)
            VALUES(NOW(),$id,$idStage,0)";

    $req = $conn -> query($sql)or die($sql);

    $_SESSION['success'] = 10;
    header("location:../publique/lesOffres.php");
  }
  
   // AJOUT CANDIDATURE EMPLOI
   if(isset($_POST['offreEmploi'])){
    $id = $GLOBAL_ouser->get_idUser();
    $idEmp = $_POST['offreEmploi'];

    $sql = "INSERT INTO candidature(createdAt,idUser,idEmpOff,typeOffre)
            VALUES(NOW(),$id,$idEmp,1)";

    $req = $conn -> query($sql)or die($sql);

    $_SESSION['success'] = 10;
    header("location:../publique/lesOffres.php");
  }
  // DELETE CANDIDATURE
  if(isset($_POST['delete'])){
    $id = $_POST['candidature'];

    $sql = "DELETE FROM candidature WHERE idCandidature = $id";

    $req = $conn -> query($sql)or die($sql);

    header("location:../publique/home.php");
  }
  // AJOUT A PROFIL STAGE CANDIDATURE ACCEPTE 
  if(isset($_POST['addStage'])){

    $id = $_POST['candidature'];

    $sql = "SELECT idStage FROM candidature WHERE idCandidature = $id";
    $req = $conn -> query($sql)or die($sql);
    $res = $req -> fetch();

    $idUser = $GLOBAL_ouser->get_idUser();
    $idStage = $res['idStage'];
    $sql = "UPDATE stage SET idUser = $idUser WHERE idStage = $idStage";
    $req = $conn -> query($sql)or die($sql);

    $sql = "DELETE FROM candidature WHERE idCandidature = $id";
    $req = $conn -> query($sql)or die($sql);
    header("location:../publique/profile.php");
  }
  // AJOUT A PROFIL EMPLOI CANDIDATURE ACCEPTE 
  if(isset($_POST['addEmp'])){

    $id = $_POST['candidature'];

    $sql = "SELECT idEmpOff FROM candidature WHERE idCandidature = $id";
    $req = $conn -> query($sql)or die($sql);
    $res = $req -> fetch();

    $idUser = $GLOBAL_ouser->get_idUser();
    $idEmp = $res['idEmpOff'];
    $sql = "UPDATE emploiOff SET idUser = $idUser WHERE idEmpOff = $idEmp";
    $req = $conn -> query($sql)or die($sql);

    $sql = "DELETE FROM candidature WHERE idCandidature = $id";
    $req = $conn -> query($sql)or die($sql);
    header("location:../publique/profile.php");
  }
  //REFUS CANDIDATURE PAR ENTREPRISE
  if(isset($_POST['refuse'])){
    $GLOBAL_ouser->refuseCandidature($_POST['candidature'],$conn);
    $_SESSION['success'] = 11;
    header("location:../publique/mescandidaturesEnt.php");
  }
  if (isset($_POST['accept'])){
    $GLOBAL_ouser-> acceptCandidature($_POST['candidature'],$conn);
    $_SESSION['success'] = 12;
    header("location:../publique/mescandidaturesEnt.php");
  }
?>