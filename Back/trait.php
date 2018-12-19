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

  if(isset($_POST['createstage']))
  {
    $lib = $_POST['lib'];
    $desc = $_POST['desc'];
    $datedeb = $_POST['datedeb'];
    $datefin = $_POST['datefin'];
    $identreprise = $_POST['entreprise'];
    $iduser = $_SESSION['user_info'] -> get_idUser();
    $ostage = new stage($iduser,$identreprise,$desc,$datedeb,$datefin,$lib);
    $ostage -> creastage($conn);
    echo "<script type='text/javascript'>document.location.replace('../publique/profile.php');</script>";
  }
  if(isset($_POST["registerEnt"]))
  {
    $nameEnt = $_POST['nameEnt'];
    $descEnt = $_POST['descEnt'];   //RECUPERATION DDES DONNEES DU FORMULAIRE
    $vilEnt = $_POST['vilEnt'];
    $rueEnt = $_POST['rueEnt'];

    $SQL_ville = "SELECT libvill FROM ville WHERE libvill = '$vilEnt'";
    $req = $conn->query($SQL_ville);
    if($req->rowCount() != 0)
    {
      //INSERTION DES DONNEES DE L'E.
      $data["nameEntreprise"] = $nameEnt;
      $data["descEntreprise"] = $descEnt;
      //INSERTION DE L'ADRESSE DE L'E.        //TYPAGE DES VARIABLES AVANT APPEL A LA FONCTION D'INSERTION
      $data["INSEE"] = $vilEnt;
      $data["rueEntreprise"] = $rueEnt;

      //AJOUT A LA BDD
      $oEnt = new entreprise();
      $oEnt ->insertEntBDD($data,$conn); //(voir entreprise.class.php)
      $_SESSION["success"] = 4; //entreprise a été ajoutée avec succès
      header('Location:../publique/entreprise.php');
    }
    else
    {
      $_SESSION["error"] = 5;
      header('Location:../publique/entreprise.php');
    }
  }

  if(isset($_GET['id']))
  {
    if($_GET['value'] == 0)
    {

      $myId = $GLOBAL_ouser->get_idUser();
      $friendId = $_GET['id'];

      if($myId == $friendId)
      {
        echo "<script type='text/javascript'>document.location.replace('../publique/membre.php');</script>";
      }
      else {
        $ID = $myId.'.'.$friendId;
        $SQL_friend = "INSERT INTO amis VALUES ('$ID',$myId,$friendId)";
        $conn->query($SQL_friend);
        echo "<script type='text/javascript'>document.location.replace('../publique/membre.php');</script>";
        exit();
      }
    }
    elseif($_GET['value'] == 1)
    {
      $myId = $GLOBAL_ouser->get_idUser();
      $friendId = $_GET['id'];
      $SQL = "DELETE FROM amis WHERE idUser1 = $myId AND idUser2 = $friendId";
      $conn->query($SQL);
      echo "<script type='text/javascript'>document.location.replace('../publique/membre.php');</script>";
      exit();
    }
  }

if(isset($_POST['registerStageOffre']))
{
    if($_POST['choix'] == "stage")
    {
      $idEnt = $GLOBAL_ouser->get_idEnt();
      $lib = $conn->quote($_POST['libelle']);
      $desc = $conn->quote($_POST['descstage']);
      $DD = $conn->quote($_POST['DD']);
      $DF = $conn->quote($_POST['DF']);
      $exig = $conn->quote($_POST['exigence']);

      $oStage = new Stage();
      $oStage->StageEnt($lib,$desc,$DD,$DF,$idEnt,$exig,$conn);
      $_SESSION['success'] = 7;
      echo "<script type='text/javascript'>document.location.replace('../publique/mesoffres.php?idEnt=$idEnt');</script>";
    }
    elseif($_POST['choix'] == "offre")
    {
      $idEnt = $GLOBAL_ouser->get_idEnt();
      $lib = $conn->quote($_POST['libelle']);
      $desc = $conn->quote($_POST['descstage']);
      $salaire = $conn->quote($_POST['salaire']);
      $exig = $conn->quote($_POST['exigence']);
      $idTypeEmp = $conn->quote($_POST['typeEmp']);
      $DD = $conn->quote($_POST['DD']);
      $DF = $conn->quote($_POST['DF']);

      $oOffre = new Offre();
      $oOffre->OffreEnt($lib,$desc,$exig,$salaire,$idEnt,$idTypeEmp,$DD,$DF,$conn);
      $_SESSION['success'] = 7;
      echo "<script type='text/javascript'>document.location.replace('../publique/mesoffres.php');</script>";
    }
    else {
      $_SESSION['error'] = 4;
    }
}

if(isset($_POST['modifystage']))
{
  $idStage = $conn->quote($_POST['idStage']);
  $lib = $conn->quote($_POST['libelle']);
  $desc = $conn->quote($_POST['descstage']);
  $DD = $conn->quote($_POST['DD']);
  $DF = $conn->quote($_POST['DF']);
  $exig = $conn->quote($_POST['exigence']);

  $SQL = "UPDATE stage SET libStage = $lib, descStage = $desc, datedebStage = $DD, datefinStage = $DF, exiStage = $exig
          WHERE idStage = $idStage";
  $conn->query($SQL) or die($SQL);
  $_SESSION['succes'] = 9;
  echo "<script type='text/javascript'>document.location.replace('../publique/mesoffres.php');</script>";
}

if(isset($_GET['idStage']))
{
  $idStage = $_GET['idStage'];

  $SQL = "UPDATE stage SET status = 1 WHERE idStage = '$idStage'";
  $conn->query($SQL) or die($SQL);
  echo "<script type='text/javascript'>document.location.replace('../publique/mesoffres.php');</script>";
  exit();

}

if(isset($_GET['idOffre']))
{
  $idOffre = $_GET['idOffre'];

  $SQL = "UPDATE emploioff SET statusEmpOff = 1 WHERE idEmpOff = '$idOffre'";
  $conn->query($SQL) or die($SQL);
  echo "<script type='text/javascript'>document.location.replace('../publique/mesoffres.php');</script>";
  exit();

}

if(isset($_POST['modifyoffre']))
{
  $typeEmp = $_POST['typeEmp'];
  if($typeEmp == "CDD")
  {

    $idoffre = $conn->quote($_POST['idOffre']);
    $lib = $conn->quote($_POST['libelle']);
    $desc = $conn->quote($_POST['descstage']);
    $DD = $conn->quote($_POST['DD']);
    $DF = $conn->quote($_POST['DF']);
    $exig = $conn->quote($_POST['exigence']);
    $salaire = $conn->quote($_POST['salaire']);

    $SQL = "UPDATE emploioff SET libEmpOff = $lib, descEmpOff = $desc, exiEmpOff = $exig, salaireMoisBrut = $salaire, DDCDD = $DD, DFCDD = $DF
            WHERE idEmpOff = $idoffre";
    $conn->query($SQL) or die($SQL);
    $_SESSION['succes'] = 9;
    echo "<script type='text/javascript'>document.location.replace('../publique/mesoffres.php');</script>";
  }
  else {

    $idoffre = $conn->quote($_POST['idOffre']);
    $lib = $conn->quote($_POST['libelle']);
    $desc = $conn->quote($_POST['descstage']);
    $exig = $conn->quote($_POST['exigence']);
    $salaire = $conn->quote($_POST['salaire']);

    $SQL = "UPDATE emploioff SET libEmpOff = $lib, descEmpOff = $desc, exiEmpOff = $exig, salaireMoisBrut = $salaire
            WHERE idEmpOff = $idoffre";
    $conn->query($SQL) or die($SQL);
    $_SESSION['succes'] = 9;
    echo "<script type='text/javascript'>document.location.replace('../publique/mesoffres.php');</script>";
  }



}
?>
