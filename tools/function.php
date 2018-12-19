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


  function DataTableStage($SQL_stage,$conn)
  {
    ?>
    <table id="stagetable" class="display" style="font-size:12.5px;width:100%;font-style:italic">
      <thead>
        <tr>
            <th>#</th>
            <th>Date commentaire</th>
            <th>Commentaire</th>
            <th>Date début</th>
            <th>Date fin</th>
            <th>Libellé</th>
            <th>Description</th>
            <th>Exigences</th>
            <th></th>
            <th></th>
        </tr>
      </thead>
      <tbody>
        <?php
          $req = $conn->query($SQL_stage) or die($SQL_stage);
          while ($res = $req -> fetch())
          {
          ?>
          <tr>
            <td><?php echo $res['idStage']; ?></td> <!-- 9 TD -->
            <td><?php echo $res['dateComm']; ?></td>
            <td><?php echo $res['contentComm']; ?></td>
            <td><?php echo $res['datedebStage']; ?></td>
            <td><?php echo $res['datefinStage']; ?></td>
            <td><?php echo $res['libStage']; ?></td>
            <td><?php echo $res['descStage']; ?></td>
            <td><?php echo $res['exiStage']; ?></td>
            <td> <a href="../Back/modif.stage.php?stage=<?php echo $res['idStage']; ?>" name="idStage"><i class="fas fa-edit" style="color:#FFC312"></i></a> </td>
            <td> <a href="#" id="deletestage" value="<?php echo $res['idStage']; ?>" onclick="recupidStage(<?php echo $res['idStage']; ?>)"><i class="fas fa-trash-alt" style="color:#EA2027;"></i></a></td>
          </tr>
          <?php
          }
        ?>
      </tbody>
      <tfoot>
      <tr>
        <th>#</th>
        <th>Date commentaire</th>
        <th>Commentaire</th>
        <th>Date début</th>
        <th>Date fin</th>
        <th>Libellé</th>
        <th>Description</th>
        <th>Exigences</th>
        <th>Qui ?</th>
      </tr>
      </tfoot>
    </table>
    <?php
  }

  function DataTableOffre($SQL_offre,$conn)
  {
    ?>
    <table id="offretable" class="display" style="font-size:12.5px;font-style:italic;width:100%">
      <thead>
        <tr>
            <th>#</th>
            <th>Type d'emploi</th>
            <th>Libellé</th>
            <th>Description</th>
            <th>Exigences</th>
            <th>Salaire / Mois Brut</th>
            <th>Date début</th>
            <th>Date fin</th>
            <th></th>
            <th></th>
        </tr>
      </thead>
      <tbody>
        <?php
          $req = $conn->query($SQL_offre) or die($SQL_offre);
          $i = 0;
          while ($res = $req -> fetch())
          {
            $i = $i++;
          ?>
          <tr>
            <td><?php echo $res['idEmpOff']; ?></td> <!-- 8 TD -->
            <td><?php echo $res['libTypeEmp']; ?></td>
            <td><?php echo $res['libEmpOff']; ?></td>
            <td><?php echo $res['descEmpOff']; ?></td>
            <td><?php echo $res['exiEmpOff']; ?></td>
            <td><?php echo $res['salaireMoisBrut']; ?></td>
            <td><?php echo $res['DDCDD']; ?></td>
            <td><?php echo $res['DFCDD']; ?></td>
            <td> <a href="../Back/modif.offre.php?offre=<?php echo $res['idEmpOff']; ?>" name="idStage"><i class="fas fa-edit" style="color:#FFC312"></i></a> </td>
            <td> <a href="#" id="deleteoffre" value="<?php echo $res['idEmpOff']; ?>" onclick="recupidOffre(<?php echo $res['idEmpOff']; ?>)"><i class="fas fa-trash-alt" style="color:#EA2027;"></i></a></td>
          </tr>
          <?php
          }
        ?>
      </tbody>
      <tfoot>
      <tr>
        <th>#</th>
        <th>Type d'emploi</th>
        <th>Libellé</th>
        <th>Description</th>
        <th>Exigences</th>
        <th>Salaire / Mois Brut</th>
        <th>Date début</th>
        <th>Date fin</th>
      </tr>
      </tfoot>
    </table>
    <?php

  }
 ?>
<script type="text/javascript">
  function recupidStage(idStage)
  {
    if(confirm("Voulez vous supprimer ce stage / offre ?"))
    {
      document.location.replace('../Back/trait.php?idStage='+idStage);
    }
  }

  function recupidOffre(idOffre)
  {
    if(confirm("Voulez vous supprimer ce stage / offre ?"))
    {
      document.location.replace('../Back/trait.php?idOffre='+idOffre);
    }
  }
</script>
