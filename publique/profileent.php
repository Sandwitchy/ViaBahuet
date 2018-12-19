<?php
//Ajout du head de page
include('../tools/head.inc.php');
?>
<script>
$( function() {
  $( "#tabs" ).tabs();
  } );
</script>
  <div id="content-wrapper">

    <div class="container-fluid profile">
      <div class="col-xl-14" style="box-shadow:2px 5px 18px #888888;border-radius:3px;border:1px solid rgba(0,0,0,0.15)">
        <div class="row">

          <div class="col-md col-lg col-ms col-xs">
            <div class="row">

              <div class="col-md-6">
                <img class="pp" src="../image/<?php echo $GLOBAL_ouser->get_photoEnt(); ?>" class="img-fluid" alt="Photo de profil" style="border-radius:50%;width:120px;height:120px;margin-top:15px;margin-left:20px;"> <!-- IMAGE -->
              </div>
              <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5" style="margin-top:2%;">
                <div class="col-md"> <!-- NOM -->
                  <h4 class="h4"><?php echo $GLOBAL_ouser->get_nameEnt(); ?></h4>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md col-lg col-ms col-xs" style="color:#007BFF;"> <!-- Boutons d'info -->
            <div class="col-md-5 col-sm-3">
              <a href="#" style="text-decoration:none;"><i class="fas fa-user-friends"></i> Liste d'amis</a>
            </div>
            <div class="col-md-5 col-sm-3">
              <a href="#" style="text-decoration:none;"><i class="fas fa-address-book"></i> Mes coordonnées</a>
            </div>
            <div class="col-md-5 col-sm-3">
              <a href="pref.php"  style="text-decoration:none;"><i class="fas fa-edit"></i>Modifier mes informations</a>
            </div>

          </div>

          <div class="w-100"></div> <!-- RETOUR A LA LIGNE DE LA GRID -->

          <div class="col-md col-lg col-ms col-xs" style="margin-bottom:2%;">
            <div class="col-md-8"> <!-- BIOGRAPHIE -->
              <br>
                  <hr class="separator"> <!-- SEPARATEUR -->
              <br>
              <a href="#" onclick="changeState()" style="text-decoration:none;"><i class="fas fa-edit"></i></a>
              <textarea id='textarea' onblur="register()" readonly value="textProfile" rows="8" cols="80"
              style="resize:none;box-shadow:2px 2px 10px #888888;outline:0;"><?php echo $GLOBAL_ouser->get_descEnt();?></textarea>
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
            $idEnt = $GLOBAL_ouser->get_idEnt();
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
                  <div class="card border-primary mb-3" style="max-width: 18rem;">
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
  <script type="text/javascript">
    function changeState()
    {
      var textarea = document.getElementById("textarea");
      textarea.removeAttribute("readonly");
      textarea.setAttribute("checkButton","1");
    }

    function register()
    {
      if(document.getElementById("textarea").getAttribute("checkButton") == 1)
      {
        var textarea = document.getElementById('textarea').value;
        location.href = "updateTextarea.inc.php?txt="+textarea;
        var textarea = document.getElementById('textarea');
        textarea.setAttribute("readonly","readonly");
      }
    }
  </script>
<?php

//ajout du pied de page
include('../tools/foot.inc.php');
 ?>
