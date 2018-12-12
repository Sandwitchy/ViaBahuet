<?php
  //créer une vue vtags qui référence tout les tags et leur type
  function createviewtags($conn)
  {
    $sql = "CREATE VIEW vtags (idtags,libtags,libtypetags) AS
            SELECT idtags,libtags,libTypeTags
            FROM tags t,typetags g
            WHERE t.idTypeTags = g.idTypeTags";
    $req = $conn -> query($sql);
    return true;
  }
  function selectviewtags($conn)
  {
    $sql = "SELECT * FROM vtags";
    $req = $conn -> query($sql);
    $res = $req -> fetchall(PDO::FETCH_ASSOC);
    return $res;
  }
  function dateFr($date)
  {
    return strftime('%d-%m-%Y',strtotime($date));
  }
 ?>
