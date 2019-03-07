<!DOCTYPE html>
<html lang="en">
<?php
  include('../tools/bdd.inc.php');
  include('../objet/callClass.php');
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

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin.css" rel="stylesheet">

  </head>

  <body class="bg-dark">
    <?php
      //gestion de l'incription d'un nouvelle USER
      if (isset($_POST['register']))
      {
        //récupere les informations des formulaires
        $var_NameUser =        $_POST['nom'];
        $var_PrenomUser =      $_POST['prenom'];
        $var_IdentifiantUser = $_POST['ident'];
        $var_MailUser =        $_POST['mail'];
        $var_PassUser =        $_POST['password'];
        $var_ConfirmPassUser = $_POST['confirmpassword'];

        //vérifie si les mots de passe sont identique
        if ($var_PassUser == $var_ConfirmPassUser)
        {
          $ouser = new user("",$var_NameUser,$var_PrenomUser,$var_MailUser,$var_PassUser,$var_IdentifiantUser);
          $ouser -> registeruser($conn,$var_NameUser,$var_PrenomUser,$var_MailUser,$var_PassUser,$var_IdentifiantUser);
          $_SESSION['success'] = 5;
          header('location:index.php');
        }else //si mot de passe différent -> affichage message d'erreur
        {
          ?>
          <div class="alert alert-danger">
            <strong>Erreur :</strong> Les mots de passes ne sont pas identiques
          </div>
          <?php
        }
      }
     ?>
    <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">Créer un compte</div>
        <div class="card-body">
          <form method='POST' action="#">
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="text" id="firstName" name='nom' class="form-control" placeholder="First name" required="required" autofocus="autofocus">
                    <label for="firstName">Nom</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="text" id="lastName" name='prenom' class="form-control" placeholder="Last name" required="required">
                    <label for="lastName">Prénom</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="text" id="inputIdentifiant" name='ident' class="form-control" placeholder="Identifiant" required="required">
                <label for="inputIdentifiant">Votre Identifiant</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="email" id="inputEmail" name='mail' class="form-control" placeholder="Email address" required="required">
                <label for="inputEmail">Adresse Email</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-row">
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="password" id="inputPassword" name='password' class="form-control" placeholder="Password" required="required">
                    <label for="inputPassword">Mot de passe</label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-label-group">
                    <input type="password" id="confirmPassword" name='confirmpassword' class="form-control" placeholder="Confirm password" required="required">
                    <label for="confirmPassword">Confirmer le mot de passe</label>
                  </div>
                </div>
              </div>
            </div>
            <input type="submit" name='register' class='btn btn-primary btn-block' value=" S'enregistrer">
          </form>
          <div class="text-center">
            <a class="d-block small mt-3" href="index.php">Page de Connexion</a>
            <a class="d-block small" href="registerentreprise.php">Vous êtes une Entreprise inscrivez-vous ici</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  </body>

</html>
