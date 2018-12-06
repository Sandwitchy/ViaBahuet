<!DOCTYPE html>
<html lang="en">
<?php
  include('tools/bdd.inc.php');
  include('objet/callClass.php');
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

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin.css" rel="stylesheet">

  </head>

  <body class="bg-dark">
    <?php
      if ((isset($_GET['error']))&&($_GET['error'] == 6))
      {
        error($_GET['error']);
      }
    ?>
    <div class="container">
      <div class="card card-register mx-auto mt-5">
        <div class="card-header">Créer un compte entreprise</div>
        <div class="card-body">
          <form method='POST' action="createentreprise.php">
            <div class="form-group">
              <div class="form-label-group">
                <input type="text" id="name" name='name' class="form-control" placeholder="First name" required="required" autofocus="autofocus">
                <label for="name">Nom de l'entreprise</label>
              </div>
            </div>
          </div>
            <input type="submit" name='register' class='btn btn-primary btn-block' value=" S'enregistrer">
          </form>
          <div class="text-center">
            <a class="d-block small mt-3" href="index.php">Page de Connexion</a>
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
