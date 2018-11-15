<?php
//Ajout du head de page
include('tools/head.inc.php');
?>

  <div id="content-wrapper">

    <div class="container-fluid profile">
      <div class="col-xl-14" style="box-shadow:2px 5px 18px #888888;border-radius:3px;border:1px solid rgba(0,0,0,0.15)">
        <div class="row">

          <div class="col-md col-lg col-ms col-xs">
            <div class="row">

              <div class="col-md-6">
                <img class="pp" src="image/<?php echo $GLOBAL_ouser->get_photoUser(); ?>" class="img-fluid" alt="Photo de profil" style="border-radius:50%;width:120px;height:120px;margin-top:15px;margin-left:20px;"> <!-- IMAGE -->
              </div>
              <div class="col-lg-3 col-md-3 col-sm-5 col-xs-5" style="margin-top:2%;">
                <div class="col-md"> <!-- NOM -->
                  <h4 class="h4"><?php echo $GLOBAL_ouser->get_nameUser(); ?></h4>
                </div>
                <div class="col-md"> <!-- PRENOM -->
                  <h5 class="h5"><?php echo $GLOBAL_ouser->get_preUser(); ?></h5>
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
              <textarea id='textarea' onblur="register()" readonly value="textProfile" rows="8" cols="80" style="resize:none;box-shadow:2px 2px 10px #888888;outline:0;"><?php echo $GLOBAL_ouser->get_descUser();?></textarea>
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
          <div class="col-md-4">
            <h4 class="h4">Stages</h4>
          </div>
          <div class="col-md-10"> <!-- CONTENU DU/DES STAGE(S)-->
            <div class="col-md-5">
              <h6 class="h6">Libellé du stage</h6>
            </div>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
          </div>
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
include('tools/foot.inc.php');
 ?>
