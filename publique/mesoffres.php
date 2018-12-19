<?php
//Ajout du head de page

// var_dump($GLOBAL_ouser->afficheAllOffres($conn));
include('../tools/head.inc.php');
$SQL_TypeEmp = "SELECT * FROM typeemploi";
$req = $conn->query($SQL_TypeEmp);
$idEntreprise = $GLOBAL_ouser->get_idEnt();
?>
<script type="text/javascript">
$(document).ready(function() {
    $('#stagetable').DataTable( {
      "language": {
            "lengthMenu": "Afficher _MENU_ résultats par page",
            "zeroRecords": "Aucun résultat - désolé",
            "info": "Page _PAGE_ sur _PAGES_",
            "infoEmpty": "Pas de résultats",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "search":         "Rechercher:",
            "paginate": {
                "first":      "First",
                "last":       "Last",
                "next":       "Suivant",
                "previous":   "Précédent"},

      }
    } );
    $('#offretable').DataTable( {
      "language": {
            "lengthMenu": "Afficher _MENU_ résultats par page",
            "zeroRecords": "Aucun résultat - désolé",
            "info": "Page _PAGE_ sur _PAGES_",
            "infoEmpty": "Pas de résultats",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "search":         "Rechercher:",
            "paginate": {
                "first":      "First",
                "last":       "Last",
                "next":       "Suivant",
                "previous":   "Précédent"}

      }
    } );
} );

$( function() {
    $( "#tabs" ).tabs();
  } );
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
    <div class="container-fluid">
      <button id="btnadd" onclick="$('#form').modal('show')" type="button" class="btn btn-success" name="button">Ajouter une offre</button>
      <!-- MODAL -->
      <div class="modal fade bd-example-modal-lg" id="form" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Ajout d'un stage / d'une offre</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="formOffre" action="../Back/trait.php" method="POST">
                <div class="col-lg-14">
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="form-label-group" required>
                        <div class="radio">
                          <label><input type="radio" id="stage" onclick="getStage()" value="0" name="choix"> Stage</label>
                        </div>
                        <div class="radio">
                          <label><input type="radio" id="offre" onclick="getOffre()" value="0" name="choix"> Offre d'emploi</label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="form-label-group">
                        <input type="text" id="libelle" name='libelle' placeholder="Libellé" value='' class="form-control" required="required">
                        <label for="libelle">Libellé</label>
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="desc">Description</label>
                      <textarea class="form-control" name="descstage" style="resize:none;" id="inputEnt" rows="8" cols="80" maxlength="2048"></textarea>
                    </div>
                  </div>
                  <div class="form-group" id="formTypeEmp">
                    <label for="exampleFormControlSelect1">Type d'emploi</label>
                    <select onchange="getDate()" class="form-control" id="selectTypeEmp" name="typeEmp">
                      <option value="">---SELECTIONNER UN TYPE---</option>
                      <?php
                        while ($res = $req -> fetch())
                        {
                        ?>
                        <option id="TypeEmp" value="<?php echo $res['libTypeEmp']; ?>"><?php echo $res["libTypeEmp"]; ?></option>
                        <?php
                        }
                      ?>
                    </select>
                  </div>
                  <div class="col-md-9">
                    <div class="row">
                      <div class="col-md">
                        <div class="form-group" id="DD">
                          <div class="form-label-group">
                            <input id="DD" type="date"  name='DD' value='' class="form-control" placeholder="Rue">
                            <label for="DD">Date début de stage</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md">
                        <div class="form-group" id="DF">
                          <div class="form-label-group">
                            <input type="date" id="DF" name='DF' value='' class="form-control" placeholder="Rue">
                            <label for="DF">Date fin de stage</label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md">
                      <div class="form-group" id="exigence">
                        <div class="form-label-group">
                          <input id="exigence" type="text" name="exigence" value='' class="form-control">
                          <label for="exigence">Diplôme(s) requis</label>
                        </div>
                      </div>
                      <div class="form-group" id="salaire">
                        <div class="form-label-group">
                          <input id="salaire" type="number" name="salaire" value='' class="form-control">
                          <label for="salaire">Salaire</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <br>
                </div>
              </div>
              <div class="modal-footer">
                <input type='submit' name='registerStageOffre' value='Enregistrer' class='btn btn-primary'>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </form>
          </div>
        </div>
      </div>
      <!-- FIN MODAL -->

      <!-- SEPARATION -->
      <br>
      <!-- SEPARATION -->

          <div id="tabs">
            <ul>
              <li><a href="#tabs-1">Stage</a></li>
              <li><a href="#tabs-2">Offre d'emploi</a></li>
            </ul>
            <div id="tabs-1">
              <?php DataTableStage("SELECT *
                              FROM stage
                              WHERE idEntreprise = $idEntreprise AND status = 0 AND idUser IS NULL",$conn); ?>
            </div> <!-- fin tab 1-->
            <div id="tabs-2">
                <?php DataTableOffre("SELECT * FROM emploioff OF,typeemploi TY WHERE idEntreprise = $idEntreprise
                                AND OF.idTypeEmp = TY.idTypeEmp
                                AND statusEmpOff = 0",$conn); ?>
            </div><!-- fin tab 2 -->
          </div><!-- FIN DIV TAB-->

      </div><!-- fin container -->
    </div><!-- fin wrapper -->

    <!-- Sticky Footer -->
    <footer class="sticky-footer">
      <div class="container my-auto">
        <div class="copyright text-center my-auto">
          <span>Copyright © Your Website 2018</span>
        </div>
      </div>
    </footer>

  </div>
  <script type="text/javascript">
    function getStage()
    {
      document.getElementById("stage").value = "stage";
      document.getElementById("offre").value = "0";

      if(document.getElementById("stage").value == "stage")
      {
        document.getElementById("DD").style = "display:flow";
        document.getElementById("DF").style = "display:flow";
        document.getElementById("salaire").style = "display:none";
        document.getElementById("formTypeEmp").style = "display:none";

      }
    }
    function getOffre()
    {
      document.getElementById("offre").value = "offre";
      document.getElementById("stage").value = "0";

      if(document.getElementById("offre").value == "offre")
      {
        document.getElementById("formTypeEmp").style = "display:flow";
        document.getElementById("salaire").style = "display:flow";
        document.getElementById("DD").style = "display:none";
        document.getElementById("DF").style = "display:none";
      }
    }

    function getDate()
    {
      if(document.getElementById("selectTypeEmp").value == "CDD")
      {
        document.getElementById("DD").style = "display:flow";
        document.getElementById("DF").style = "display:flow";
      }
      else {
        document.getElementById("DD").style = "display:none";
        document.getElementById("DF").style = "display:none";
      }
    }
  </script>
  <!-- /.content-wrapper -->

<?php
//ajout du pied de page
include('../tools/foot.inc.php');
 ?>
