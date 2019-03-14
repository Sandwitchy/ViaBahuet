
<?php
    include('../tools/head.inc.php');
        $lol = $_GET['searchGlobal'];
        $loln = $lol;
        $lol = $conn->quote("%".$lol."%");

        $sql = "SELECT * FROM user u
                INNER JOIN ville v ON u.INSEE = v.INSEE
                WHERE u.nameUser LIKE $lol
                OR u.preUser LIKE $lol
                OR v.libVill = '$loln'
                GROUP BY u.INSEE";
        $req = $conn -> query($sql)or die($sql);
?>

      <div id="content-wrapper">

        <div class="container-fluid">
            <div class='row'>
                <div class='col-md-6'>
                    <h5>Utilisateurs : </h5>
                    <?php 
                    if($req -> rowCount() == 0){
                        echo 'Aucun résultat';
                    }else{
                        while($res = $req -> fetch()){
                            
                        ?>
                            <div class="col-md-8">
                            <div class="row">
          
                              <div class="col-md-4">
                                <img src="../image/<?php echo $res['photoUser']; ?>" class="img-fluid img-thumbnail rounded" height="128" width="128" alt="">
                              </div>
                              <div class="col-md">
                                <a href="profile.php?user=<?php echo $res['idUser']; ?>"><?php echo $res["nameUser"]." ".$res["preUser"]; ?></a>
                                <p>Situé à : <?php echo $res["libVill"]; ?> </p>
                                <p> <?php echo $res["mailUser"]; ?> </p>
                                <p><?php echo $res["descUser"]; ?></p>
                              </div>
                            </div>
                          </div>
                        <?php
                            }
                        }
                    ?>
                </div>
                <div class="col-md-6">
                    <?php

                       $sql = "SELECT * FROM entreprise e
                               INNER JOIN concerner c ON e.idEntreprise = c.idEntreprise
                               INNER JOIN ville v ON v.INSEE = c.INSEE
                               WHERE e.nameEntreprise LIKE $lol
                               OR v.libVill = '$loln'
                               GROUP BY e.idEntreprise";
                       $req = $conn -> query($sql)or die($sql);  
                    ?>
                    <h5>Entreprise : </h5>
                    <?php 
                    if($req -> rowCount() == 0){
                        echo 'Aucun résultat';
                    }else{
                        while($res = $req -> fetch()){ 
                        ?>
                            <div class="col-md-8">
                            <div class="row">
          
                              <div class="col-md-4">
                                <img src="../image/<?php echo $res['photoEnt']; ?>" class="img-fluid img-thumbnail rounded" height="128" width="128" alt="">
                              </div>
                              <div class="col-md">
                                <a href="profileEntO.php?ent=<?php echo $res['idEntreprise']; ?>"><?php echo $res["nameEntreprise"]; ?></a>
                                <p>Situé à : <?php echo $res["libVill"]; ?> </p>                                
                                <p> <?php echo $res["mailEntreprise"]; ?> </p>
                                <p><?php echo $res["descEntreprise"]; ?></p>
                              </div>
                            </div>
                          </div>
                        <?php
                            }
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

    <?php
    //ajout du pied de page
    include('../tools/foot.inc.php');
     ?>
