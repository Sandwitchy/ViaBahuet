<?php
//Ajout du head de page
include('../tools/head.inc.php');
$idUser = $_GET['user'];

$SQL_user = "SELECT u.idUser,nameUser,preUser,mailUser,loginUser,descUser,photoUser
              FROM user u
              WHERE u.idUser = '$idUser'";

$req = $conn->query($SQL_user);
$res = $req -> fetch();

?>
<script>
  $(document).ready(function(){
    $(".cloud-tags").prettyTag();
  });
</script>
  <div id="content-wrapper">

    <div class="container-fluid profile">
      <div class="col-xl-14" style="box-shadow:2px 5px 18px #888888;border-radius:3px;border:1px solid rgba(0,0,0,0.15)">
        <div class="row">

          <div class="col-md col-lg col-ms col-xs">
            <div class="row">

              <div class="col-md-6">
                <img class="pp" src="../image/<?php echo $res['photoUser']; ?>" class="img-fluid" alt="Photo de profil" style="border-radius:50%;width:120px;height:120px;margin-top:15px;margin-left:20px;"> <!-- IMAGE -->
              </div>
              <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5" style="margin-top:2%;">
                <div class="col-md"> <!-- NOM -->
                  <h4 class="h4"><?php echo $res['nameUser']; ?></h4>
                </div>
                <div class="col-md"> <!-- PRENOM -->
                  <h5 class="h5"><?php echo $res['preUser']; ?></h5>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md col-lg col-ms col-xs" style="color:#007BFF;"> <!-- Boutons d'info -->
            <div class="col-md" >
              Tags affiliés à l'utilisateur :
            </div>
              <ul class="cloud-tags">
              <?php
                $sql_tags = "SELECT * FROM taguser u,tags t
                              WHERE u.idUser = '$idUser'
                              AND u.idTags = t.idTags";
                $req_tags = $conn -> query($sql_tags);
                if ($req_tags->rowCount() == 0)
                {
                  echo "L'utilisateur ne possède pas de tags";
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
          </div>

          <div class="w-100"></div> <!-- RETOUR A LA LIGNE DE LA GRID -->

          <div class="col-md col-lg col-ms col-xs" style="margin-bottom:2%;">
            <div class="col-md-8"> <!-- BIOGRAPHIE -->
              <br>
                  <hr class="separator"> <!-- SEPARATEUR -->
              <br>
              <textarea id='textarea' readonly value="textProfile" rows="8" cols="80"
              style="resize:none;box-shadow:2px 2px 10px #888888;outline:0;"><?php echo $res['descUser'];?></textarea>
            </div>
          </div>
        </div>
      </div> <!-- FIN GRID PROFILE -->

      <section class="experience" style="box-shadow:2px 5px 18px #888888;margin-top:1.5%;border-radius:3px;border:1px solid rgba(0,0,0,0.15)">
        <div class="col-lg-14">
          <div class="col-md-4">
            <h4 class="h4">Expérience</h4>
          </div>
          <div class="col-md-10"> <!-- CONTENU DU/DES STAGE(S)-->
            <div class="col-md-5">
              <h6 class="h6">Libellé du job</h6>
            </div>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
          </div>
        </div>
      </section>

      <section class="stage" style="box-shadow:2px 5px 18px #888888;margin-top:1.5%;border-radius:3px;border:1px solid rgba(0,0,0,0.15)">
        <div class="col-lg-14">
          <div class='row' style='margin:5px;'>
            <div class="col-md-10">
              <p class="h4">Stages</p>
            </div>

          </div>
          <?php
            $idUser = $GLOBAL_ouser->get_idUser();
            $sql_stage = "SELECT datedebStage,datefinStage,libStage,descStage,nameEntreprise,photoEnt
                    FROM stage s,entreprise e
                    WHERE s.idEntreprise = e.idEntreprise
                    AND s.idUser = '$idUser'";

            $req_stage = $conn -> query($sql_stage);
            while ($res_stage = $req_stage -> fetch())
            {
              ?>
              <div class="col-md-10" style="box-shadow:2px 5px 18px #888888;margin:2%;"> <!-- CONTENU DU/DES STAGE(S)-->
              <div class='row'>
                <div class='col-md-2'>
                  <img src='../image/<?php echo $res_stage['photoEnt']; ?>' class='img-thumbnail' style="height:128px;width:auto;">
                </div>
                <div class='col-md'>
                  <div class='row' >
                    <div class="col-md-4">
                      <h4 class="h4"><?php echo $res_stage['libStage']; ?></h4>
                    </div>
                    <div class='col-sm'>
                      <p class='lead'><u><strong><?php echo $res_stage['nameEntreprise']; ?></strong></u></p>
                    </div>
                  </div>
                  <div class='row' style="margin-left:2%;">
                    <div class='col-xs-3'>
                      <span class="badge badge-secondary"><?php echo dateFR($res_stage['datedebStage']); ?></span>
                    </div>
                    <div class='col-xs-3'>
                      <span class="badge badge-secondary"><?php echo dateFR($res_stage['datefinStage']); ?></span>
                    </div>
                  </div>
                  <p><?php echo $res_stage['descStage'];?> </p>
                </div>
              </div>
            </div>
              <?php
            }
          ?>
          <!-- fin affichage BDD -->
        </div>
      </section>

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
