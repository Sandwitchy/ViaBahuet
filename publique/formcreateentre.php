<!DOCTYPE html>
<html lang="en">
<?php
  include('../tools/bdd.inc.php');
  include('../objet/callClass.php');
  include('../tools/error.php');
 ?>
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Register</title>

    <!-- Bootstrap core CSS-->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!--Jquery ui import -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <link rel="stylesheet" href="/code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.js"></script>
    <!-- Custom styles for this template-->
    <link href="../css/sb-admin.css" rel="stylesheet">
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
  </head>

  <body class="bg-dark">
    <?php
      if ((isset($_GET['error']))&&($_GET['error'] == 6))
      {
        error($_GET['error']);
      }
      if ((!isset($_GET['user']))||($_GET['user'] == 'none'))
      {
        $id = 'none';
      }
      else
      {
        $id = $_GET['user'];
        $sql_recup = "SELECT nameEntreprise,rueEntreprise,libVill,descEntreprise
                      FROM entreprise e,concerner c,ville v
                      WHERE e.idEntreprise = c.idEntreprise
                      AND c.INSEE = v.INSEE
                      AND e.idEntreprise = '$id'";
        $req = $conn -> query($sql_recup);
        $res = $req->fetchall(PDO::FETCH_ASSOC);
      }
    ?>
    <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">Créer un compte entreprise</div>
        <div class="card-body">
          <form method='POST' action="">
            <div class="form-group">
              <div class="form-label-group">
                <input type="text" id="name" name='name' class="form-control" placeholder="First name" value='<?php if($id != 'none'){echo $res[0]['nameEntreprise'];} ?>' required="required" autofocus="autofocus">
                <label for="name">Nom de l'entreprise</label>
              </div>
              <div class="form-label-group">
                <input type="text" id="login" name='login' class="form-control" placeholder="Login" required="required" autofocus="autofocus">
                <label for="login">Votre login</label>
              </div>
              <div class="form-label-group">
                <input type="text" id="mail" name='mail' class="form-control" placeholder="mail" required="required" autofocus="autofocus">
                <label for="mail">Votre mail</label>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-6">
                <div class='form-label-group'>
                  <input type="password" id="password" name='password' class="form-control" placeholder="password" required="required" autofocus="autofocus">
                  <label for="password">Votre mot de passe</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class='form-label-group'>
                  <input type="password" id="comfirmpass" name='comfirmpass' class="form-control" placeholder="confrmpass" required="required" autofocus="autofocus">
                  <label for="comfirmpass">Confirmer le mot de passe</label>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-6">
                <div class='form-label-group'>
                  <input type="text" id="villeEnt" name='ville' value='<?php if($id != 'none'){echo $res[0]['libVill'];} ?>' class="form-control" placeholder="ville" required="required" autofocus="autofocus">
                  <label for="ville">Votre ville</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class='form-label-group'>
                  <input type="text" id="rue" name='rue' class="form-control" placeholder="rue" required="required" autofocus="autofocus">
                  <label for="rue">Votre Rue</label>
                </div>
              </div>
            </div>
          </div>
            <input type='hidden' name='id' value='<?php echo $id; ?>'>
            <input type="submit" name='register' class='btn btn-primary btn-block' value=" S'enregistrer">
          </form>
          <div class="text-center">
            <a class="d-block small mt-3" href="index.php">Page de Connexion</a>
          </div>
        </div>
    </div><!--container-->

    <?php
      if (isset($_POST['register']))
      {
        $id = $_POST['id'];
        $var_PassUser = $_POST['password'];
        $var_ConfirmPassUser = $_POST['comfirmpass'];
        if ($var_PassUser == $var_ConfirmPassUser)
        {
          $name = $_POST['name'];
          $login = $_POST['login'];
          $mail = $_POST['mail'];
          $ville = $_POST['ville'];
          $oville = new ville($ville);
          $check = $oville -> searchIfExist($conn);
          if ($check == true)
          {
            $rue = $_POST['rue'];
            $INSEE = $oville -> get_INSEE();
            $user = new entreprise();
            $bool = $user -> registeruserentreprise($conn,$name,$mail,$var_PassUser,$login,$INSEE,$rue,$id);
            echo "<script type='text/javascript'>document.location.replace('index.php?success=5');</script>";
          }else {//ville inconnue
            echo "<script type='text/javascript'>document.location.replace('formcreateentre.php?error=5&user=$id');</script>";
          }
        }else
        { // mot de passe différent
          echo "<script type='text/javascript'>document.location.replace('formcreateentre.php?error=6&user=$id');</script>";
        }
      }
     ?>





    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Page level plugin JavaScript-->
    <script src="../vendor/chart.js/Chart.min.js"></script>
    <script src="../vendor/datatables/jquery.dataTables.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin.min.js"></script>
  </body>

</html>
