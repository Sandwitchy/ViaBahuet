<?php
  include('../tools/head.inc.php');


  if (get_class($GLOBAL_ouser) == 'user')
  {
    $data[0]['colonne'] = "descUser";
    $data[0]['donnee'] = $_GET['txt'];
    $id = $GLOBAL_ouser->get_idUser();
    $oController = new Controller();
    $oController->updateBDD('user',$data,$id,$conn);
    echo "<script type='text/javascript'>document.location.replace('../publique/profile.php');</script>";
  }else {
    $data[0]['colonne'] = "descEntreprise";
    $data[0]['donnee'] = $_GET['txt'];
    $id = $GLOBAL_ouser->get_idEnt();
    $oController = new Controller();
    $oController->updateBDD('entreprise',$data,$id,$conn);
    echo "<script type='text/javascript'>document.location.replace('../publique/profileent.php');</script>";
  }



?>
