<?php
  include('tools/bdd.inc.php');
  include('objet/callClass.php');
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


  if (isset($_POST['createstage']))
  {
    $lib = $_POST['lib'];
    $desc = $_POST['desc'];
    $datedeb = $_POST['datedeb'];
    $datefin = $_POST['datefin'];
    $identreprise = $_POST['entreprise'];
    $iduser = $_SESSION['user_info'] -> get_idUser();
    $ostage = new stage($iduser,$identreprise,$desc,$datedeb,$datefin,$lib);
    $ostage -> creastage($conn);
    echo "<script type='text/javascript'>document.location.replace('profile.php');</script>";
  }
 ?>
