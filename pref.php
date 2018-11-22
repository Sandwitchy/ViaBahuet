<?php
//Ajout du head de page
include('tools/head.inc.php');
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
  $( "#inputLibville" ).autocomplete({
    source: availableTags
  });
} );
$('#ModalMDP').on('shown.bs.modal', function () {
  $('#triggermodal').trigger('onclick')
})
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
      <div class='col-xl-14' style='box-shadow:2px 5px 18px #888888;padding:2%;margin-left:2%;'>
        <h1>Mes Préférences</h1>
        <form method='post' action='#'>
        <div class='col-md-8'>
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
              <button type="button" id="triggermodal" name='mdp' data-toggle="modal" data-target="#ModalMDP" class='btn btn-danger'>Modifier le Mot de Passe</button>
            </div>
          </div>
        </div>

        <div class='col-md-8'>
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
        <div class='col-md-8'>
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
        <div class='col-md-8'>
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
            <div class="form-group col-md-3">
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
          </div>
        </div>
        <div class='col-md-8'>
          <input type='submit' name='envoie' value='Enregistrer' class='btn btn-primary'>
          <a href='home.php'><button type='button' class='btn btn-secondary'>Annuler</button></a>
        </div>
      </form>
    </div><!--end contanier xl-14 -->
    <div class='col-md' style='box-shadow:2px 5px 18px #888888;padding:2%;margin-left:2%;margin-right:2%;'>
      <div class="text-center">
        <img class='img-fluid img-circle' style='border-radius:50%;height:150px;margin:auto;' src='image/<?php echo $GLOBAL_ouser->get_photoUser(); ?>'>
        <h4>Image de profil</h4>
      </div>
      <form method='post' enctype="multipart/form-data" action='gestImg.php'>
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
    </div>
    <!-- /.container-fluid -->
    <?php
    /*
      GESTION FORMULAIRE
    */
    if (isset($_POST['envoie']))
    {
      $CP = $_POST['CP'];
      $lib = $_POST['ville'];
      $ville = new ville($lib,$CP);
      $check = $ville->searchIfExist($conn);
      if ($check == FALSE)
      {
        $_SESSION['error'] = 1;
        die("alors? on sait pas dev :imsexy:");
        echo "<script type='text/javascript'>document.location.replace('pref.php');</script>";
      }
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
      }else {
        unset($_SESSION['error']);
        $_SESSION['error'] = 2;
      }
      echo "<script type='text/javascript'>document.location.replace('pref.php');</script>";
    }
     ?>
     <!-- Modal Mot de passe -->
     <div class="modal" id="ModalMDP" role="dialog">
       <div class="modal-dialog" role="document">
         <div class="modal-content">
           <div class="modal-header">
             <h5 class="modal-title">Modifier le Mot de Passe</h5>
           </div>
           <div class="modal-body">
             <form method='POST' action="#">
               <div class="form-group">
                 <div class="form-label-group">
                   <input type="password" id="inputOldPass" name='oldpass' value='<?php echo $GLOBAL_ouser->get_loginUser();?>' class="form-control" placeholder="Password" required="required">
                   <label for="inputOldPass">Ancien Mot de Passe</label>
                 </div>
               </div>
               <div class="form-group">
                 <div class="form-label-group">
                   <input type="password" id="inputNewPass" name='newpass' value='<?php echo $GLOBAL_ouser->get_loginUser();?>' class="form-control" placeholder="New Password" required="required">
                   <label for="inputNewPass">Nouveau Mot de Passe</label>
                 </div>
               </div>
               <div class="form-group">
                 <div class="form-label-group">
                   <input type="password" id="inputConfPass" name='confpass' value='<?php echo $GLOBAL_ouser->get_loginUser();?>' class="form-control" placeholder="Confirm Password" required="required">
                   <label for="inputConfPass">Comfirmer Nouveau Mot de Passe</label>
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
include('tools/foot.inc.php');
 ?>
