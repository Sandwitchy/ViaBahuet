<!DOCTYPE html>
<html lang="en">
  <?php
    include('tools/bdd.inc.php');
    include('objet/callClass.php');
   ?>
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ViaBahuet - Connexion</title>

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">

  </head>
  <body class="bg-dark">
    <?php
    //tentative de connexion d'un user
      if (isset($_POST['connexion']))
      {
        $var_LOG = $_POST['log'];
        $var_Password = $_POST['password'];
        $ocontroller = new Controller($conn);
        $INT_resconn = $ocontroller -> connexionVerif($var_LOG,$var_Password);
        print_r($INT_resconn);
        if ($INT_resconn == "FALSE")
        {
          ?>
          <div class="alert alert-danger">
            <strong>Erreur :</strong> Identifiant/Mail ou mot de passe faux
          </div>
          <?php
        }
        else
        {
          $ouser = new user($INT_resconn);
          $ouser -> recupUser($conn);
          session_start();
          $_SESSION['user_info'] = $ouser;
          header('location:home.php');
        }
      }
     ?>
    <div class="container">
      <div class="card card-login mx-auto mt-5">
        <div class="card-header">Se Connecter</div>
        <div class="card-body">
          <form method='post' action='#'>
            <div class="form-group">
              <div class="form-label-group">
                <input type="text" id="inputEmail" name='log' class="form-control" placeholder="Email address" required="required" autofocus="autofocus">
                <label for="inputEmail">Email ou Identifiant</label>
              </div>
            </div>
            <div class="form-group">
              <div class="form-label-group">
                <input type="password" id="inputPassword" name='password' class="form-control" placeholder="Password" required="required">
                <label for="inputPassword">Mot de passe</label>
              </div>
            </div>
            <div class="form-group">
              <div class="checkbox">
                <label>
                  <input type="checkbox" value="remember-me">
                  Se souvenir du mot de passe
                </label>
              </div>
            </div>
            <input type='submit' name='connexion' class='btn btn-primary btn-block' value="Se Connecter">
          </form>
          <div class="text-center">
            <a class="d-block small mt-3" href="register.php">Créer un compte</a>
            <a class="d-block small" href="">Mot de passe oublié ?</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  </body>

</html>
