<?php
//Ajout du head de page
include('../tools/head.inc.php');
?>
<script>
  $( function() {
    var availableTags = [
      <?php
     $sql_libville = "SELECT * FROM ville";
     $req_sql = $conn -> query($sql_libville);
     $i = 1;
     while ($res_req = $req_sql->fetch())
     {
       if ($i == 1)
       {
         $tab = '"'.$res_req['libVill'].'"';
         $i = 0;
       }else {
         $tab = $tab.',"'.$res_req['libVill'].'"';
       }
     }
     echo $tab;
    ?>
    ];
    $( "#villeEnt" ).autocomplete({
      source: availableTags
    });
  } );
  </script>
</body>
</html>
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

    <div class="container-fluid">
    <div class='col-xs-4'>
      <button  onclick="$('#creaentreprise').modal('show')" type="button" class="btn btn-primary" name="button">Ajouter une entreprise</button>
    </div>
    <!-- Affichage Entreprise -->
    <div class="col-xl-14">
      <div class='row'>
        <?php
          $ocontroller = new Controller($conn);
          $table[0] = '';
          $res = $ocontroller -> selectAllTable("entreprise",$table);
          $i = 0;
          foreach ($res as $enter)
          {
            ?>
            <div class="card" style='width:15rem;margin:5px;'>
              <img class="card-img-top img-thumbnail" src="../image/<?php echo $enter['photoEnt']; ?>" alt="Card image cap">
              <div class="card-body">
                <h5 class="card-title"><?php echo $enter['nameEntreprise']; ?></h5>
                <p class="card-text"><?php echo substr($enter['descEntreprise'],0,50); ?></p>
                <?php
                if ((get_class($GLOBAL_ouser)=='entreprise')&&($enter['idEntreprise'] == $GLOBAL_ouser->get_idEnt()))
                {
                  ?> <p class="text-muted">Vous</p>
                </div>
                <div class='card-footer'>
                  <a href="profileent.php" class="btn btn-primary">Voir profil</a>
                </div><?php
                }
                elseif($enter['createbyuser'] == 1)
                {
                  ?> <p class="text-muted">Créer par un membre</p>
                </div>
                <div class='card-footer'>
                  <a href="" class="btn btn-primary">Voir profil</a>
                </div><?php
                }else
                {
                  ?> <p class="text-muted">Est une entreprise</p>
                </div>
                <div class='card-footer'>
                  <a href="" class="btn btn-primary">Voir profil</a>
                </div><?php
                } ?>
            </div>
            <?php
            if ($i == 3)
            {
              ?><div class="w-100"></div><?php
              $i = 0;
            }else {
              $i++;
            }
          }
        ?>
      </div>
    </div>

<!--Modal de création entreprise -->
    <div class="modal fade" id="creaentreprise" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Créer une Entreprise</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form  action="../Back/trait.php" method="post">
              <div class="form-group">
                <div class="form-label-group">
                  <input type="text" id='inputEnt'  name='nameEnt' class="form-control" placeholder="login" required="required">
                  <label for="inputEnt">Nom de l'entreprise</label>
                </div>
              </div>
              <div class="form-group">
                <label for="descEnt">Description de l'entreprise</label>
                <textarea class="form-control" id='descEnt' name="descEnt" style="resize:none;"  rows="8" cols="80" maxlength="2048"></textarea>
              </div>
              <div class="row">
                <div class="col-md">
                  <div class="form-group">
                    <div class="form-label-group">
                      <input type="text" id='villeEnt' name='vilEnt' class="form-control ui-widget" placeholder="Ville" required="required">
                      <label for="villeEnt">Ville</label>
                    </div>
                  </div>
                </div>
                <div class="col-md">
                  <div class="form-group">
                    <div class="form-label-group">
                      <input type="text" id='inputEnt' name='rueEnt' class="form-control" placeholder="Rue">
                      <label for="inputEnt">Rue</label>
                    </div>
                  </div>
                </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
              <input type='submit' name='registerEnt' value='Enregistrer' class='btn btn-primary'>
            </form>
          </div>
        </div>
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
