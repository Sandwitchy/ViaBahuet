<?php
  include("../tools/bdd.inc.php");
  
  $myId = $_POST['idUser'];
  $friendId = $_POST['idamis'];
  if($_POST['type'] == 0)
  {
    if($myId == $friendId)
    {
      echo "<script type='text/javascript'>document.location.replace('../publique/membre.php');</script>";
    }
    else {
      $ID = $myId.'.'.$friendId;
      $SQL_friend = "INSERT INTO amis VALUES ('$ID',$myId,$friendId)";
      $conn->query($SQL_friend);
    }
  }
  elseif($_POST['type'] == 1)
  {
    $SQL = "DELETE FROM amis WHERE idUser1 = '$myId' AND idUser2 = '$friendId'";
    $conn->query($SQL);
  }
  echo json_encode(true);
?>
