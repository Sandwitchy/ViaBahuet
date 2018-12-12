<?php
//Ajout du head de page
include('../tools/head.inc.php');

$oController = new Controller($conn);
if(isset($_POST['rechercher']))
{
  if(!empty($_POST['rechercher']))
  {
    $conditions[0] = $conn->quote($_POST['rechercher']);
  }
  else {
    $conditions[0] = '';
  }
}
else {
  $conditions[0] = '';
}
$req = $oController->selectAllTable("user u",$conditions);

if(isset($_POST['reset']))
{
  $conditions[0] = '';
  $req = $oController->selectAllTable("user u",$conditions);

}
?>

  <div id="content-wrapper">

    <div class="container-fluid">

      <!-- BARRE DE RECHERCHE -->
      <form class="" action="#" method="post">
        <input type="text" name="rechercher" value="">
        <input type="submit" name="" value="Rechercher">
        <input type="submit" name="reset" value="retour">
      </form>
<body>
<br>
      <div class="col-lg"> <!-- ELEMENT A GAUCHE DE LA PAGE-->
        <div class="row">
          <div class="col-md-24">
            <div class="row">
              <div class="col-md-8">
                <div class="row">

                      <?php
                      for($i = 0; $i < count($req) ; $i++)
                      {
                      ?>
                      <div class="col-md-6" id="user">
                        <div class="row">
                          <div class="col-md-6">
                            <img src="../image/<?php echo $req[$i]['photoUser']; ?>" class="img-fluid img-thumbnail rounded" style="width:128px;height:128px;" alt="">
                          </div>
                          <div class="col-md">
                            <p> <a href="profile.php?user=<?php echo $req[$i]['idUser']; ?>"><?php echo $req[$i]["nameUser"]." ".$req[$i]["preUser"]; ?></a> </p>
                            <p> <?php echo $req[$i]["mailUser"]; ?> </p>
                            <?php
                            $bool =$GLOBAL_ouser->checkFriend($req[$i]['idUser'],$conn);
                              if($bool == true)
                              {
                              ?>
                              <p> <a  class="btn btn-danger btn-sm" href="../Back/trait.php?id=<?php echo $req[$i]['idUser']; ?>&value=1 " value='1'><?php echo "Retirer l'ami"; ?></a> </p>
                              <?php
                              }
                              else
                              {
                                ?>
                                <p> <a  class="btn btn-success btn-sm" href="../Back/trait.php?id=<?php echo $req[$i]['idUser']; ?>&value=0 " value='0'><?php echo "Ajouter en ami"; ?></a> </p>
                                <?php
                              }
                            ?>
                          </div>
                        </div>
                    </div>
                      <?php
                      }
                      ?>
                </div>
              </div>
              <div class="col-md-4 border rounded"> <!-- ELEMENT A DROITE DE LA PAGE -->
                <div class="row">
                  <div class="col-md-6">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                  </div>
                  <div class="col-md-6">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                  </div>
                </div>
              </div>
            </div>
          </div>
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
