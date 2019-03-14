<?php
//Ajout du head de page
include('../tools/head.inc.php');
?>
<script>
$("#czContainer").czMore();
</script>

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
  $( "#inputLibville" ).autocomplete({
    source: availableTags
  });
} );
$( function() {
  var tagstable = [
    <?php
      createviewtags($conn);
      $tags = selectviewtags($conn);
      $i = 1;
      if ($tags == "")
      {
        echo "";
      }else
      {
        foreach($tags as $tag)
        {
          if ($i == 1)
          {
            $tab = "{id:". $tag['idtags'].", value:'". $tag['libtags']."'}";
            $i = 0;
          }else {
            $tab = $tab.",{id:". $tag['idtags'].", value:'". $tag['libtags']."'}";
          }
        }
      }
      echo $tab;
     ?>
  ];
  $("#tags").autocomplete({
    source:tagstable,
    minLength: 0,
  })
  } );
  function tagdelete(value){
      $.ajax({
            // chargement du fichier externe Taggestion.php
            url      : "../Back/Taggestion.php",
            // Passage des données au fichier externe (ici le nom cliqué)
            data     : {
                        libTags: value,
                        idUser: <?php echo $GLOBAL_ouser->get_idUser(); ?>
                        },
            cache    : true,
            dataType : "json",
            method   : "POST",
            error    : function(request, error) { // Info Debuggage si erreur
                         alert("Erreur : responseText: "+request.responseText);
                       },
            success  : function() {
                        location.reload();
                       }
       });
  }
  $(document).ready(function(){
    $(".cloud-tags").prettyTag();
  });
</script>
  <div id="content-wrapper">
    <div class="container-fluid">
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
    <div class='row'>
      <div class='col-lg-8' style='box-shadow:2px 5px 18px #888888;padding:2%;margin:1%;'>
        <h1>Mes Préférences</h1>
        <form method='post' action='#'>
        <div class='col-md'>
          <div class='row'>
            <div class='col-md'>
              <div class="form-group">
                <div class="form-label-group">
                  <input type="text" id="inputLogin" name='login' value='<?php echo $GLOBAL_ouser->get_loginUser();?>' class="form-control" placeholder="login" required="required">
                  <label for="inputLogin">Identifiant</label>
                </div>
              </div>
            </div>
            <div class='col-md'>
              <button type="button" id="triggermodal" name='mdp' onclick="$('#ModalMDP').modal('show')" class='btn btn-danger'>Modifier le Mot de Passe</button>
            </div>
          </div>
        </div>

        <div class='col-md'>
          <div class='row'>
            <div class="form-group col-md">
              <div class="form-label-group">
                <input type="text" id="inputName"  value='<?php echo $GLOBAL_ouser->get_nameUser();?>' name='name' class="form-control" placeholder="name" required="required">
                <label for="inputName">Nom</label>
              </div>
            </div>
            <div class="form-group col-md">
              <div class="form-label-group">
                <input type="text" id="inputPrenom" name='prenom'  value='<?php echo $GLOBAL_ouser->get_preUser();?>' class="form-control" placeholder="prenom" required="required">
                <label for="inputPrenom">Prénom</label>
              </div>
            </div>
          </div>
        </div>
        <div class='col-md'>
          <div class='row'>
            <div class="form-group col-md">
              <div class="form-label-group">
                <input type="text" id="inputMail" name='mail'  value='<?php echo $GLOBAL_ouser->get_mailUser();?>' class="form-control" placeholder="mail" required="required">
                <label for="inputMail">Email</label>
              </div>
            </div>
            <div class="form-group col-md">
              <div class="form-label-group">
                <input type="text" id="inputTel" name='tel' class="form-control"  value='<?php echo $GLOBAL_ouser->get_telUser();?>' placeholder="tel" required="required">
                <label for="inputTel">Numéro de Téléphone</label>
              </div>
            </div>
          </div>
        </div>
        <!-- Gestion Adresse -->
        <div class='col-md'>
          <div class='row'>
            <div class="form-group col-md">
              <div class="form-label-group">
                <input type="text" id="inputRue" name='rue' class="form-control" placeholder="rue"  value='<?php echo $GLOBAL_ouser->get_adresse();?>' required="required">
                <label for="inputRue">Rue</label>
              </div>
            </div>
            <?php
              $ville = $GLOBAL_ouser -> get_ville();
              $CP = $ville -> get_CP();
              $lib = $ville ->get_libVil();
             ?>
            <div class="form-group col-md">
              <div class="form-label-group">
                <input type="text" id="inputCP" name='CP' value="<?php echo $CP; ?> "class="form-control" placeholder="CP"  required="required">
                <label for="inputCP">Code Postal</label>
              </div>
            </div>
            <div class="form-group col-md">
              <div class="form-label-group">
                <input type="text" id="inputLibville" name='ville' value="<?php echo $lib; ?>" class="form-control autocomplete" placeholder="ville"  required="required">
                <label for="inputLibville">Ville</label>
              </div>
            </div>
            <div class="form-group col-md">
              <div class="form-label-group">
                <div id="czContainer">
                  <div id="first">
                    <div class="recordset">
                      <input type="text" name="input 1" id="input 1">
                      <input type="text" name="input 2" id="input 2">
                      <input type="text" name="input 3" id="input 3">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class='col-md-8'>
          <input type='submit' name='envoie' value='Enregistrer' class='btn btn-primary'>
          <a href='home.php'><button type='button' class='btn btn-secondary'>Annuler</button></a>
        </div>
      </form>
    </div><!--end contanier xl-14 -->
    <div class='col-md' style='box-shadow:2px 5px 18px #888888;padding:2%;margin:1%;'>
      <div class="text-center">
      <div class='vb-profilepic img-thumbnail' style="background-image:url('../image/<?php echo $GLOBAL_ouser->get_photoUser()?>');
                                                                      width:75%;
                                                                      height:175px;"></div>
        <h4>Image de profil</h4>
      </div>
      <form method='post' enctype="multipart/form-data" action='../tools/gestImg.php'>
        <div class="custom-file">
         <input type="file" name='imgProfile' class="custom-file-input" id="customFile">
         <label class="custom-file-label" for="customFile">Choisir une img</label>
       </div>
       <div class='text-center' style="margin-top:2%">
         <div class="btn-group">
           <input type='submit' value='Envoyer' name='envoieProPic' class='btn btn-primary'>
           <input type='reset' value='Annuler' class='btn btn-secondary'>
         </div>
       </div>
      </form>
    </div><!--end container md-2-->
</div><!--end row -->
      </div><!--container XS-14-->
      <div class="xs-14" style='box-shadow:2px 5px 18px #888888;padding:2%;margin:1%;'>
        <div class='col-md'>
          <h4>Mes Tags</h4>
          <?php
            $tagsuser = $GLOBAL_ouser -> selecttags($conn);
            ?>
            <div class='row'>
              <?php
              if ($tagsuser == false)
              {
                echo "Vous n'avez aucun tag";
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
         </div>
        </div>
        <?php
          if(isset($_POST['tags']))
          {
            $bool = $GLOBAL_ouser -> deletetags($_POST['tags'],$conn);
            echo "<script type='text/javascript'>location.reload();</script>";
          }
         ?>
        <form method='post'>
          <div class='form-row align-items-center'>
            <div class='col-auto'>
              <input type='text' class='form-control form-control-sm' id='tags' name='libtags'>
            </div>
            <div class='col-auto'>
              <input type='submit' class='btn btn-primary' name='envoietags'>
            </div>
          </div>
        </form>
      </div><!-- container xs-14-->

    </div>
    <!-- /.container-fluid -->
    <?php
    /*
      GESTION FORMULAIRE
    */
    if (isset($_POST['envoietags']))
    {
      $libtags = $_POST['libtags'];
      $GLOBAL_ouser -> createjointag2user($libtags,$conn);
      echo "<script type='text/javascript'>document.location.replace('pref.php');</script>";
    }
    if (isset($_POST['envoie']))
    {
      $CP = $_POST['CP'];
      $lib = $_POST['ville'];
      $ville = new ville($lib,$CP);
      $check = $ville->searchIfExist($conn);
      if ($check == FALSE)
      {
        $_SESSION['error'] = 1;
        echo "<script type='text/javascript'>document.location.replace('pref.php');</script>";
        die();
      }else{
        $login = $_POST['login'];
        $nom = $_POST['name'];
        $prenom = $_POST['prenom'];
        $mail = $_POST['mail'];
        $tel = $_POST['tel'];
        $rue = $_POST['rue'];
        $GLOBAL_ouser -> updateUser($login,$nom,$prenom,$mail,$tel,$rue,$ville,$conn);
        unset($_SESSION['success']);
        $_SESSION['success'] = 1;
        echo "<script type='text/javascript'>document.location.replace('pref.php');</script>";
      }
      
    }
    if (isset($_POST['modpass']))
    {
      $old = $_POST['oldpass'];
      $new = $_POST['newpass'];
      $confirm = $_POST['confpass'];
      $res = $GLOBAL_ouser -> changePass($old,$new,$confirm,$conn);
      if ($res == true)
      {
        unset($_SESSION['success']);
        $_SESSION['success'] = 2;
      }elseif ($res == false) {
        unset($_SESSION['error']);
        $_SESSION['error'] = 2;
      }
      echo "<script type='text/javascript'>document.location.replace('pref.php');</script>";
    }
     ?>
     <!-- Modal Mot de passe -->
     <div class="modal fade" id="ModalMDP" tabindex="1" role="dialog">
       <div class="modal-dialog" role="document">
         <div class="modal-content">
           <div class="modal-header">
             <h5 class="modal-title">Modifier le Mot de Passe</h5>
           </div>
           <div class="modal-body">
             <form method='POST' action="#">
               <div class="form-group">
                 <div class="form-label-group">
                   <input type="password" id="inputOldPass" name='oldpass' class="form-control" placeholder="Password" required="required">
                   <label for="inputOldPass">Ancien Mot de Passe</label>
                 </div>
               </div>
               <div class="form-group">
                 <div class="form-label-group">
                   <input type="password" id="inputNewPass" name='newpass' class="form-control" placeholder="New Password" required="required">
                   <label for="inputNewPass">Nouveau Mot de Passe</label>
                 </div>
               </div>
               <div class="form-group">
                 <div class="form-label-group">
                   <input type="password" id="inputConfPass" name='confpass' class="form-control" placeholder="Confirm Password" required="required">
                   <label for="inputConfPass">Confirmer Nouveau Mot de Passe</label>
                 </div>
               </div>
           </div>
           <div class="modal-footer">
             <input type='submit' name="modpass" value='Enregistrer' class='btn btn-danger'>
             <button type="button" class="btn btn-primary" data-dismiss="modal">Annuler</button>
           </form>
           </div>
         </div>
      </div>
     </div><!--end Modal Mot de passe -->

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
