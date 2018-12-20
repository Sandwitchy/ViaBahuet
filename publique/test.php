<?php
  include('../tools/bdd.inc.php');
  include('../tools/function.php');
  $sql3 = "INSERT INTO tagent(idTags,idEntreprise) VALUES(12,23)";
  $req3 = $conn -> query($sql3)or die(errorSQL($sql3));
?>
