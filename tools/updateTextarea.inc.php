<?php
include('tools/bdd.inc.php');
include('objet/callClass.php');
  $data['colonne'] = "descUser";
  $data['donnee'] = $_GET['txt'];
  $oController = new Controller();
?>
