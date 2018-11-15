<!DOCTYPE html>
<html lang="en">

  <head>
    <?php
      include('bdd.inc.php');
      include('./objet/callClass.php');
      if(session_id() == '' || !isset($_SESSION)) {
          // session isn't started
          session_start();
          $_SESSION['success'] = 0;
          $_SESSION['error'] = 0;
      }
      if (!isset($_SESSION['user_info'])) //verifie si un user c'est correctement connecté sinon revoie vers la page de connexion
      {
        echo "<script type='text/javascript'>document.location.replace('index.php');</script>";
      }else {
        $_SESSION['user_info'] ->recupUser($conn);
        $GLOBAL_ouser = $_SESSION['user_info']; // définition de la variable global de l'user connecter
      }
     ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Dashboard</title>

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
    <!--Jquery ui import -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <link rel="stylesheet" href="/code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.js"></script>
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

  </head>

  <body id="page-top">

    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

      <a class="navbar-brand mr-1" href="index.html">Start Bootstrap</a>

      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Navbar Search -->
      <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Rechercher..." aria-label="Search" aria-describedby="basic-addon2">
          <div class="input-group-append">
            <button class="btn btn-primary" type="button">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </div>
      </form>

      <!-- Navbar -->
      <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown no-arrow mx-1">
          <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell fa-fw"></i>
            <span class="badge badge-danger">9+</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
        <li class="nav-item dropdown no-arrow mx-1">
          <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-envelope fa-fw"></i>
            <span class="badge badge-danger">7</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-circle fa-fw"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="pref.php">Préférences</a>
            <a class="dropdown-item" href="#">Activity Log</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
          </div>
        </li>
      </ul>

    </nav>

    <div id="wrapper">

      <!-- Sidebar -->
      <ul class="sidebar navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="home.php">
            <i class="fas fa-fw fa-bars"></i>
            <span>Accueil</span>
          </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" href="index.html">
            <i class="fas fa-fw fa-briefcase"></i>
            <span>Mes Expériences</span>
          </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index.html">
            <i class="fas fa-fw fa-user"></i>
            <span>Les Membres</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="entreprise.php">
            <i class="fas fa-fw fa-building"></i>
            <span>Les Entreprises</span></a>
        </li>
        <?php
          $INT_TypeUser = $GLOBAL_ouser->get_typeUser();
          if ($INT_TypeUser != 1)
          {
            ?>
            <li class="nav-item">
                <a class="nav-link" href="index.html">
                <i class="fas fa-fw fa-database"></i>
                <span>Administration</span></a>
            </li>
            <?php
          }
         ?>
      </ul>
