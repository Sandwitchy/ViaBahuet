<?php
//Ajout du head de page

// var_dump($GLOBAL_ouser->afficheAllOffres($conn));
include('../tools/head.inc.php');
$SQL_TypeEmp = "SELECT * FROM typeemploi";
$req = $conn->query($SQL_TypeEmp);
?>

  <div id="content-wrapper">
    <div class="container-fluid">
      <button id="btnadd" onclick="appear()" type="button" class="btn btn-primary" name="button">Ajouter une offre</button>
      <form style="display:none" id="formOffre" action="../Back/trait.php" method="POST">
        <div class="col-lg-14">
          <div class="col-md-6">
            <div class="form-group">
              <div class="form-label-group" required>
                <h4>Ajouter un stage / une offre d'emploi</h4>
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
              <div class="col-md-3">
                <div class="form-group" id="DD">
                  <div class="form-label-group">
                    <input id="DD" type="date"  name='DD' value='' class="form-control" placeholder="Rue">
                    <label for="DD">Date début de stage</label>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group" id="DF">
                  <div class="form-label-group">
                    <input type="date" id="DF" name='DF' value='' class="form-control" placeholder="Rue">
                    <label for="DF">Date fin de stage</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
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
          <div class="col-md-6">
            <input type='submit' name='registerStageOffre' value='Enregistrer' class='btn btn-primary'>
          </div>
        </div>
      </form>
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
  <script type="text/javascript">
    function appear()
    {
      document.getElementById("btnadd").style = "display:none";
      document.getElementById("formOffre").style = "display:flow";
    }

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
