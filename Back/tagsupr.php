<?php
  include('../tools/bdd.inc.php');

  $lib = $_GET['lib'];
  $sql = "SELECT idTags FROM Tags WHERE libTags = '$lib'";
  $req = $conn -> query($sql);
  $res = $req -> fetch();
  $idtags = $res['idTags'];
  $sql = "DELETE FROM taguser WHERE idTags = $idtags AND idUser=$id";
  $req = $conn -> query($sql);
 ?>
