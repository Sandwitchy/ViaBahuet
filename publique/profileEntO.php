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
  <script>
  $( function() {
    $( "#tabs" ).tabs();
  } );
  $(document).ready(function(){
    $(".cloud-tags").prettyTag();
  });
  </script>

  <div id="content-wrapper">
    <?php
    if(!isset($_SESSION['error'])) {
      $_SESSION['error'] = 0;
    }else if (($_SESSION['error'] != 0)||(isset($_SESSION['error'])))
    {
      error($_SESSION['error']);
    }
    if(!isset($_SESSION['success'])) {
      $_SESSION['success'] = 0;
    }elseif (($_SESSION['success'] != 0)||(isset($_SESSION['success'])))
    {
      success($_SESSION['success']);
    }
    ?>
    <div class="container-fluid profile">
      <div class="col-xl-14" style="box-shadow:2px 5px 18px #888888;border-radius:3px;border:1px solid rgba(0,0,0,0.15)">
        <div class="row">

          <div class="col-md col-lg col-ms col-xs">
            <div class="row">

              <div class="col-md-6">
                <img class="img-thumbnail" src="../image/<?php echo $res['photoEnt']; ?>" alt="Photo de profil" style="width:120px;height:120px;margin-top:15px;margin-left:20px;"> <!-- IMAGE -->
              </div>
              <div class="col-lg-4 col-md-4 col-sm-5 col-xs-5" style="margin-top:2%;">
              <!-- NOM -->
                  <h4 class="h4"><?php echo $res['nameEntreprise']; ?></h4>
              </div>
            </div>
          </div>
          <div class="col-md col-lg col-ms col-xs" > <!-- Boutons d'info -->
            <div class="col-md-5 col-sm-3">
              <p>Site web : <?php
              if (isset($res['sitewebEntreprise'])) {
                echo $res['sitewebEntreprise'];
              }else {
                echo "aucun site web";
              }
               ?></p>
            </div>
            <div class="col-md">
              <p>Taille de l'entreprise : <?php
                echo utf8_encode($res['libTailleEntreprise']);
               ?></p>

            </div>
            <?php if($res['createbyuser'] !=  1){ ?>
            <div class="col-md" >
              Tags affiliés à l'entreprise :
            </div>
              <ul class="cloud-tags">
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
                    <li>
                       <a href="#tag_link"> <?php echo $tags['libTags']; ?></a>
                     </li>
                     <?php
                  }
                }
              ?>
              </ul>
          <?php } ?>

          </div>

          <div class="w-100"></div> <!-- RETOUR A LA LIGNE DE LA GRID -->

          <div class="col-md col-lg col-ms col-xs" style="margin-bottom:2%;">
            <div class="col-md-8"> <!-- BIOGRAPHIE -->
                <?php if(get_class($GLOBAL_ouser) == 'user'){ ?>
              <button name='avis' class='btn btn-primary' onclick="$('#addavis').modal('show')">Donner un avis!</button>
            <?php } ?>
              <br>
                  <hr class="separator"> <!-- SEPARATEUR -->
              <br>
              <textarea id='textarea' readonly value="textProfile" rows="8" cols="80"
              style="resize:none;box-shadow:2px 2px 10px #888888;outline:0;"><?php echo $res['descEntreprise'];?></textarea>
            </div>
          </div>
        </div>
      </div> <!-- FIN GRID PROFILE -->

      <div id="tabs">
        <ul>
          <li><a href="#tabs-1">Avis</a></li>
          <li><a href="#tabs-2">Personne ayant travaillé</a></li>
        </ul>
        <div id="tabs-1">
          <h5>Avis </h5>
          <div class='row'>
          <?php
            $sql = "SELECT * FROM avisentre a,user u
                    WHERE a.idUser = u.idUser
                    AND a.idEntreprise = $idEnt";
            $req = $conn -> query($sql);
            while ($res = $req -> fetch())
            {
              ?>
                <div class="card border-primary mb-3" style="max-width: 15rem;margin:1%">
                  <div class="card-header">
                    <div class='row'>
                      <div class='col-md'>
                        <img src="../image/<?php echo $res['photoUser']; ?>" style="width:64px;height:auto;"  class='img-thumbnail img-fluid' alt="">
                      </div>
                      <div class='col-md'>
                        <a href="profile.php?user=<?php echo $res['idUser']; ?>"><p><b><?php echo $res['nameUser']." ".$res['preUser'] ?></b></p></a>
                      </div>
                    </div>
                  </div>
                  <div class="card-body text-primary">
                    <h5 class="card-title"><?php echo "Le :".dateFR($res['dateavis']);?></h5>
                    <p class="card-text"><?php echo $res['avistxt'];?></p>
                    <?php if ((get_class($GLOBAL_ouser) == 'user')&&($res['idUser'] == $GLOBAL_ouser->get_idUser())): ?>
                      <button class='btn btn-warning btn-sm' onclick="$('#avismod').modal('show')"><i class="fas fa-edit"></i></button>
                      <button class='btn btn-danger btn-sm' onclick="$('#avisdel').modal('show')"><i class="fas fa-trash-alt"></i></button>
                    <?php endif; ?>
                  </div>
                </div>
              <?php
            }
           ?>
         </div><!--row-->
        </div>
        <div id="tabs-2">
          <h5>Personne ayant travaillé dans cette entreprise : </h5><br>
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
                  <div class="card border-primary mb-3" style="max-width: 18rem;margin:1%">
                    <div class="card-header">
                      <div class='row'>
                        <div class='col-md'>
                          <img src="../image/<?php echo $res_job['photoUser']; ?>" style="width:64px;height:auto;"  class='img-thumbnail img-fluid' alt="">
                        </div>
                        <div class='col-md'>
                          <p><b><?php echo $res_job['nameUser']." ".$res_job['preUser'] ?></b></p>
                        </div>
                      </div>
                    </div>
                    <div class="card-body text-primary">
                      <a href="profile.php?user=<?php echo $res_job['idUser']; ?>" class="btn btn-primary btn-sm">voir profil</a>
                    </div>
                  </div>
                  <?php
              }//end affichage job
            }
            ?>
          </div>
        </div>
      </div>

    </div>
    <!-- /.container-fluid -->
    <!-- modal créer avis -->
    <div class="modal fade" tabindex="-1" id="addavis" role="dialog">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Donner un avis</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method='post' action='../Back/trait.php'>
          <div class="modal-body">
            <textarea class='form-control' name='avistxt' placeholder="Donner votre avis sur cette entreprise!"></textarea>
          </div>
          <div class="modal-footer">
            <input type='hidden' value='<?php echo $idEnt;?>' name='entreprise'>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary" name='saveavis'>Enregistrer</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Modal modifier avis -->
    <?php
      if (get_class($GLOBAL_ouser) == "user") {
        $idUser = $GLOBAL_ouser->get_idUser();
        $sql_mod = "SELECT * FROM avisentre WHERE idEntreprise = $idEnt AND idUser = $idUser";
        $req_mod = $conn -> query($sql_mod)or die($sql_mod);
        $resmodavis = $req_mod -> fetch();
      }

    ?>
    <div class="modal fade" tabindex="-1" id="avismod" role="dialog">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Modifier votre avis</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method='post' action='../Back/trait.php'>
          <div class="modal-body">
            <textarea class='form-control' name='avistxt'><?php echo $resmodavis['avistxt']; ?></textarea>
          </div>
          <div class="modal-footer">
            <input type='hidden' value='<?php echo $idEnt;?>' name='entreprise'>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-primary" name='modavis'>Enregistrer</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <!--modal suppresion avis -->
    <div class="modal fade" tabindex="-1" id="avisdel" role="dialog">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content p-3 mb-2 bg-danger text-white">
          <div class="modal-header">
            <h5 class="modal-title">Supprimer votre avis</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method='post' action='../Back/trait.php'>
          <div class="modal-body">
            Voulez vous vraiment supprimer votre avis?
          </div>
          <div class="modal-footer">
            <input type='hidden' value='<?php echo $idEnt;?>' name='entreprise'>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-warning" name='delavis'>Supprimer</button>
          </div>
          </form>
        </div>
      </div>
    </div>
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
