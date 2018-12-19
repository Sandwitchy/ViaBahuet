<?php
  include('../tools/bdd.inc.php');

  $libtags = $_POST['libTags'];
  $idUser = $_POST['idUser'];
  $sql = "SELECT idTags
          FROM tags
          WHERE libTags = '$libtags'";
  $req = $conn -> query($sql);
  $res = $req -> fetch();
  $idTags = $res['idTags'];

  $sql = "DELETE FROM tagent
          WHERE idTags = '$idTags'
          AND idEntreprise = '$idUser'";
  $req = $conn -> query($sql);
  echo json_encode(true);
 ?>
