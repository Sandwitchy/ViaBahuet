<?php
  include('tools/head.inc.php');
  $data[0]['colonne'] = "descUser";
  $data[0]['donnee'] = $_GET['txt'];

  $oController = new Controller();
  $oController->updateBDD('user',$data,$GLOBAL_ouser->get_idUser(),$conn);
  echo "<script type='text/javascript'>document.location.replace('profile.php');</script>";
?>
