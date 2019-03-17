<?php
//Ajout du head de page
include('../tools/head.inc.php');
if(isset($_GET['user']))
{
  if($GLOBAL_ouser->get_idUser() != $_GET['user'])
  {
    echo "<script type='text/javascript'>document.location.replace('profileOther.php?user=$_GET[user]');</script>";
  }
}
?>
<style media="screen">
.emp-profile{
  padding-top: 3%;
  padding-bottom: 3%;
  margin-top: 3%;
  margin-bottom: 3%;
  border-radius: 0.5rem;
  background: #fff;
}
.profile-img{
  text-align: center;
}
.profile-img img{
  width: 70%;
  height: 100%;
}
.profile-img .file {
  position: relative;
  overflow: hidden;
  margin-top: -20%;
  width: 70%;
  border: none;
  border-radius: 0;
  font-size: 15px;
  background: #212529b8;
}
.profile-img .file input {
  position: absolute;
  opacity: 0;
  right: 0;
  top: 0;
}
.profile-head h5{
  color: #333;
}
.profile-head h6{
  color: #0062cc;
}
.profile-edit-btn{
  border: none;
  border-radius: 1.5rem;
  width: 70%;
  padding: 2%;
  font-weight: 600;
  color: #6c757d;
  cursor: pointer;
}
.proile-rating{
  font-size: 12px;
  color: #818182;
  margin-top: 5%;
}
.proile-rating span{
  color: #495057;
  font-size: 15px;
  font-weight: 600;
}
.profile-head .nav-tabs{
  margin-bottom:5%;
}
.profile-head .nav-tabs .nav-link{
  font-weight:600;
  border: none;
}
.profile-head .nav-tabs .nav-link.active{
  border: none;
  border-bottom:2px solid #0062cc;
}
.profile-work{
  padding: 14%;
  margin-top: -15%;
}
.profile-work p{
  font-size: 12px;
  color: #818182;
  font-weight: 600;
  margin-top: 10%;
}
.profile-work a{
  text-decoration: none;
  color: #495057;
  font-weight: 600;
  font-size: 14px;
}
.profile-work ul{
  list-style: none;
}
.profile-tab label{
  font-weight: 600;
}
.profile-tab p{
  font-weight: 600;
  color: #0062cc;
}
</style>
  <div id="content-wrapper">

    <div class="container-fluid profile">
      <div class="col-xl-14" style="box-shadow:2px 5px 18px #888888;border-radius:3px;border:1px solid rgba(0,0,0,0.15)">
        <div class="row">

          <div class="col-md col-lg col-ms col-xs">
            <div class="row">

          <div class="container emp-profile" style="padding:0;">
            <form method="post">
                <div class="row">
                    <div class="col-md-4">
                      <div class='vb-profilepic img-thumbnail' style="background-image:url('../image/<?php echo $GLOBAL_ouser->get_photoUser()?>');
                                                                                      width:50%;
                                                                                      height:250px;"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-head">
                                    <h5>
                                        <?php echo $GLOBAL_ouser->get_preUser()." ".$GLOBAL_ouser->get_nameUser(); ?>
                                    </h5>
                                    <div class="col-md col-lg col-ms col-xs" style="margin-bottom:2%;">
                                      <div class="col-md-8"> <!-- BIOGRAPHIE -->
                                        <h6 style="color:#212529">
                                          Bio :
                                          <a href="" style="color:rgb(<?php echo rand(0,230).','.rand(0,230).','.rand(0,230); ?>)" class="typewrite" data-period="850" data-type=<?php echo displayBio($GLOBAL_ouser->get_descUser()); ?>>
                                            <span class="wrap"></span>
                                          </a>
                                        </h6>
                                        <br>
                                      </div>
                                    </div>
                                    <br>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">À propos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#stages" role="tab" aria-controls="profile" aria-selected="false">Stages</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <a href="pref.php" class="profile-edit-btn btn-warning" style="color:white;text-decoration:none;">Modifier le profil</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-work">
                            <p>TAGS :</p>
                            <?php
                            $tagsuser = $GLOBAL_ouser -> selecttags($conn);
                            if ($tagsuser == false)
                            {
                              echo "Pas de tags";
                            }else {
                              ?><ul class="cloud-tags"> <?php
                              foreach ($tagsuser as $tag){
                                $tags = $tag['libTags'];
                                ?>
                                <li>
                                   <a href="#tag_link" onclick="tagdelete('<?php echo $tags;?>')"> <?php echo $tags; ?></a>
                                 </li>
                                <?php
                              }
                              ?></ul><?php
                            }
                           ?>
                            <script>
                            $(function(){
                              $(".cloud-tags").prettyTag();
                            });
                            </script>

                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Nom / Prénom</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $GLOBAL_ouser->get_nameUser()." ".$GLOBAL_ouser->get_preUser(); ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $GLOBAL_ouser->get_mailUser(); ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Téléphone</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $GLOBAL_ouser->get_telUser(); ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Profession</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>Web Developer and Designer</p>
                                            </div>
                                        </div>
                            </div>
                            <div class="tab-pane fade show" id="stages" role="tabpanel" aria-labelledby="profile-tab">
                              <a href="stagecrea.php" class="btn btn-primary">Ajouter un stage</a>
                              <?php
                              $idUser = $GLOBAL_ouser->get_idUser();
                                $sql = "SELECT datedebStage,datefinStage,libStage,descStage,nameEntreprise,photoEnt
                                        FROM stage s,entreprise e
                                        WHERE s.idEntreprise = e.idEntreprise
                                        AND s.idUser = '$idUser'";

                                $req = $conn -> query($sql);
                                if ($req -> rowCount() == 0) {
                                  echo "Aucun Résultat";
                                }
                                else {
                                  while ($res = $req ->fetch()) {
                                ?>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Libellé</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $res['libStage']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Description</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $res['descStage']; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Date de début</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo dateFR($res['datedebStage']); ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Date de fin</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo dateFR($res['datefinStage']); ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Entreprise d'accueil</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $res['nameEntreprise']; ?></p>
                                            </div>
                                        </div>
                            </div>
                        </div>
                    </div>
                    <?php
                      }
                    }
                    ?>
                </div>
            </form>
        </div>

            </div>
          </div>

          <div class="w-100"></div> <!-- RETOUR A LA LIGNE DE LA GRID -->
        </div>
      </div> <!-- FIN GRID PROFILE -->
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
       location.href = "../Back/updateTextarea.inc.php?txt="+textarea;
       var textarea = document.getElementById('textarea');
       textarea.setAttribute("readonly","readonly");
     }
   }
 </script>
<?php

//ajout du pied de page
include('../tools/foot.inc.php');
 ?>
