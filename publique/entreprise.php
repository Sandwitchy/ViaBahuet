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

    <button id="btnadd" onclick="appear()" type="button" class="btn btn-primary" name="button">Ajouter une entreprise</button>

    <form style="display:none" id="formEnt" action="../Back/trait.php" method="post">
      <div class="col-lg-14">
        <div class="col-md-6">
          <div class="form-group">
            <div class="form-label-group">
              <input type="text" id="nameEnt" name='nameEnt' value='' class="form-control" placeholder="login" required="required">
              <label for="nameEnt">Nom de l'entreprise</label>
            </div>
          </div>
        </div>
        <br>
        <div class="col-md-6">
          <div class="form-group">
            <label for="descEnt">Description de l'entreprise</label>
            <textarea class="form-control" name="descEnt" style="resize:none;" id="inputEnt" rows="8" cols="80" maxlength="2048"></textarea>
          </div>
        </div>
        <div class="col-md-9">
          <div class="row">
            <div class="col-md-3">
              <div class="form-group">
                <div class="form-label-group">
                  <input type="text" id="villeEnt" name='vilEnt' value='' class="form-control ui-widget" placeholder="Ville" required="required">
                  <label for="villeEnt">Ville</label>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <div class="form-label-group">
                  <input type="text" id="rueEnt" name='rueEnt' value='' class="form-control" placeholder="Rue">
                  <label for="rueEnt">Rue</label>
                </div>
              </div>
            </div>
          </div>
        </div>
        <br>
        <div class="col-md-6">
          <input type='submit' name='registerEnt' value='Enregistrer' class='btn btn-primary'>
        </div>
      </div>
    </form>

    <script type="text/javascript">
      function appear()
      {
        document.getElementById("btnadd").style = "display:none";
        document.getElementById("formEnt").style = "display:flow";
      }
    </script>
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
