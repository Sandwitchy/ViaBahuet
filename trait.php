<?php

  include('tools/bdd.inc.php');
  include('./objet/callClass.php');

  if(session_id() == '' || !isset($_SESSION)) {
      // session isn't started
      session_start();
  }
  if (!isset($_SESSION['user_info'])) //verifie si un user c'est correctement connecté sinon revoie vers la page de connexion
  {
    echo "<script type='text/javascript'>document.location.replace('index.php');</script>";
  }else {
    $_SESSION['user_info'] ->recupUser($conn);
    $GLOBAL_ouser = $_SESSION['user_info']; // définition de la variable global de l'user connecter

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
      header('Location:entreprise.php');
    }
    else
    {
      $_SESSION["error"] = 5;
      header('Location:entreprise.php');
    }
  }


?>
