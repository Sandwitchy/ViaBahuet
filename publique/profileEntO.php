<?php
//Ajout du head de page
include('../tools/head.inc.php');
$idEnt = $_GET['ent'];
if((get_class($GLOBAL_ouser) != 'user' )&&($GLOBAL_ouser->get_idEnt() == $_GET['ent']))
{
  echo "<script type='text/javascript'>document.location.replace('profileent.php');</script>";
}
$SQL_user = "SELECT idEntreprise,nameEntreprise,mailEntreprise,descEntreprise,photoEnt,createbyuser,libTailleEntreprise
              FROM entreprise e, tailleentreprise t
              WHERE e.idTailleEntreprise = t.idTailleEntreprise
              AND e.idEntreprise = '$idEnt'";

$req = $conn->query($SQL_user);
$res = $req -> fetch()
?>

  <div id="content-wrapper">

    <div class="container-fluid profile">
      <div class="col-xl-14" style="box-shadow:2px 5px 18px #888888;border-radius:3px;border:1px solid rgba(0,0,0,0.15)">
        <div class="row">

          <div class="col-md col-lg col-ms col-xs">
            <div class="row">

              <div class="col-md-6">
                <img class="img-thumbnail" src="../image/<?php echo $res['photoEnt']; ?>" alt="Photo de profil" style="width:120px;height:120px;margin-top:15px;margin-left:20px;"> <!-- IMAGE -->
              </div>
              <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5" style="margin-top:2%;">
                <div class="col-md"> <!-- NOM -->
                  <h4 class="h4"><?php echo $res['nameEntreprise']; ?></h4>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md col-lg col-ms col-xs" style="color:#007BFF;"> <!-- Boutons d'info -->
            <div class="col-md-5 col-sm-3">
              <p>Site web : <?php echo $res['mailEntreprise']; ?></p>
            </div>
            <div class="col-md">
              <p>Taille de l'entreprise : <?php echo utf8_encode($res['libTailleEntreprise']); ?></p>

            </div>
            <?php if($res['createbyuser'] !=  1){ ?>
            <div class="col-md" >
              Tags affiliés à l'entreprise :
              <div class='row'>
              <?php
                $sql_tags = "SELECT * FROM tagent e,tags t
                              WHERE e.idEntreprise = '$idEnt'
                              AND e.idTags = t.idTags";
                $req_tags = $conn -> query($sql_tags);
                if ($req_tags->rowCount() == 0)
                {
                  echo "L'entreprise ne possède pas de tags";
                }else {
                  while ($tags = $req_tags -> fetch())
                  { ?>
                    <button type='button' name='tags' class='tag blue btn'
                     style='color:white;'><?php echo $tags['libTags']; ?></button>
                     <?php
                  }
                }
              ?>
              </div>
            </div>
          <?php } ?>

          </div>

          <div class="w-100"></div> <!-- RETOUR A LA LIGNE DE LA GRID -->

          <div class="col-md col-lg col-ms col-xs" style="margin-bottom:2%;">
            <div class="col-md-8"> <!-- BIOGRAPHIE -->
              <br>
                  <hr class="separator"> <!-- SEPARATEUR -->
              <br>
              <textarea id='textarea' readonly value="textProfile" rows="8" cols="80"
              style="resize:none;box-shadow:2px 2px 10px #888888;outline:0;"><?php echo $res['descEntreprise'];?></textarea>
            </div>
          </div>
        </div>
      </div> <!-- FIN GRID PROFILE -->

      <div class="col-lg" style="box-shadow:2px 5px 18px #888888;border-radius:3px;padding:1%;margin-top:1%;border:1px solid rgba(0,0,0,0.15)">
        <h4>Personne ayant travaillé dans cette entreprise : </h4><br>
        <div class='row'>
          <?php
          $sql_job = "SELECT DISTINCT u.idUser,preUser,nameUser,photoUser FROM stage s,user u
                      WHERE s.idUser = u.idUser
                      AND s.idEntreprise = '$idEnt'";
          $req_job = $conn -> query($sql_job)or die($sql_job);
          if ($req_job->rowCount()== 0)
          {
            echo "<div class='container'><p>Personne<p></div>";
          }else
          {
            while ($res_job = $req_job -> fetch())
            {

                ?>
                <div class="col-md-4">
                  <div class="card flex-row flex-wrap">
                      <div class="card-header border-0">
                          <img src="../image/<?php echo $res_job['photoUser']; ?>" style="height:64px;width:auto" class='img-thumbnail' alt="">
                      </div>
                      <div class="card-block px-2">
                          <h4 class="card-title"><?php echo $res_job['nameUser']." ".$res_job['preUser'] ?></h4>
                          <a href="profile.php?user=<?php echo $res_job['idUser']; ?>" class="btn btn-primary btn-sm">voir profil</a>
                      </div>
                  </div>
                </div>
                <?php
            }//end affichage job
          }
          ?>
        </div>
      </div>
    </div>
    <!-- /.container-fluid -->

    <!-- Sticky Footer -->
    <footer class="sticky-footer">
      <div class="container my-auto">
        <div class="copyright text-center my-auto">
          <span>Copyright © Your Website 2018</span>
        </div>
      </div>
    </footer>

  </div>
  <!-- /.content-wrapper -->
<?php

//ajout du pied de page
include('../tools/foot.inc.php');
 ?>
