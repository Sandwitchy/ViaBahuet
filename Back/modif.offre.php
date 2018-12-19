<?php
//Ajout du head de page
include('../tools/head.inc.php');
$idOffre = $_GET['offre'];
$SQL_offre = "SELECT * FROM emploioff OF,typeemploi TY WHERE idEmpOff = $idOffre
                AND TY.idTypeEmp = OF.idTypeEmp
                AND statusEmpOff = 0";
$req = $conn->query($SQL_offre);
$idEntreprise = $GLOBAL_ouser->get_idEnt();

while ($res = $req->fetch())
{
?>

  <div id="content-wrapper">
    <div class="container-fluid">
              <form id="formOffre" action="../Back/trait.php" method="POST">
                <div class="col-lg-14">
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="form-label-group">
                        <input type="text" id="typeEmp" name='typeEmp' placeholder="Type d'emploi" value="<?php echo $res['libTypeEmp']; ?>" class="form-control" required="required">
                        <label for="libelle">Type d'emploi</label>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="form-label-group">
                        <input type="text" id="libelle" name='libelle' placeholder="Libellé" value="<?php echo $res['libEmpOff']; ?>" class="form-control" required="required">
                        <label for="libelle">Libellé</label>
                      </div>
                    </div>
                  </div>
                  <br>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="desc">Description</label>
                      <textarea class="form-control" name="descstage" style="resize:none;" id="inputEnt" rows="8" cols="80" maxlength="2048"><?php echo $res['descEmpOff']; ?></textarea>
                    </div>
                  </div>
                  <div class="col-md-9">
                    <?php
                      if($res['libTypeEmp'] == "CDD")
                      {
                    ?>
                    <div class="row">
                      <div class="col-md">
                        <div class="form-group" id="DD">
                          <div class="form-label-group">
                            <input id="DD" type="date"  name='DD' value="<?php echo $res['DDCDD']; ?>" class="form-control">
                            <label for="DD">Date début de stage</label>
                          </div>
                        </div>
                      </div>
                      <div class="col-md">
                        <div class="form-group" id="DF">
                          <div class="form-label-group">
                            <input type="date" id="DF" name='DF' value="<?php echo $res['DFCDD']; ?>" class="form-control">
                            <label for="DF">Date fin de stage</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                    <div class="col-md">
                      <div class="form-group" id="exigence">
                        <div class="form-label-group">
                          <input id="exigence" type="text" name="exigence" value="<?php echo $res['exiEmpOff']; ?>" class="form-control">
                          <label for="exigence">Diplôme(s) requis</label>
                        </div>
                      </div>
                    </div>
                    <div class="col-md">
                      <div class="form-group" id="salaire">
                        <div class="form-label-group">
                          <input id="salaire" type="text" name="salaire" value="<?php echo $res['salaireMoisBrut']; ?>" class="form-control">
                          <label for="salaire">Salaire</label>
                        </div>
                      </div>
                    </div>
                    <div class="form-group" id="enregistrer">
                      <input type='submit' name='modifyoffre' value='Enregistrer les modifications' class='btn btn-primary'>
                      <a href="../publique/mesoffres.php" class="btn btn-secondary">Retour</a>
                      <input type="hidden" name="idOffre" value="<?php echo $idOffre ; ?>">
                    </div>
                  </div>
                  <br>
                </div>
              </div>
            </form>
          </div>
<?php
}
?>


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
