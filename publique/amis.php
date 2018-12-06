<?php
//Ajout du head de page
include('../tools/head.inc.php');
$myId = $GLOBAL_ouser->get_idUser();
$SQL_amis = "SELECT * FROM user,amis WHERE amis.idUser2 = user.idUser AND idUser1 = $myId";
$req = $conn->query($SQL_amis);
?>

  <div id="content-wrapper">

    <div class="container-fluid">
      <h3>Mes amis</h3>
      <div class="col-lg">
        <div class="row">
          <div class="col-md-24">
            <div class="row">
              <div class="col-md-8">
                <div class="row">
              <?php
                while($res = $req ->fetch())
                {
                ?>
                <div class="col-md-8">
                  <div class="row">
                    <div class="col-md-4">
                      <img src="../image/<?php echo $res['photoUser']; ?>" class="img-fluid img-thumbnail rounded" alt="">
                    </div>
                    <div class="col-md-6">
                      <p> <a href="profile.php?user=<?php echo $res['idUser']; ?>"><?php echo $res["nameUser"]." ".$res["preUser"]; ?></a> </p>
                      <p> <?php echo $res["mailUser"]; ?> </p>

                      <p><?php echo $res["descUser"]; ?></p>
                    </div>
                  </div>
                </div>
              <?php
                }
              ?>
                </div>
              </div>
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
