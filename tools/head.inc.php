<!DOCTYPE html>
<html lang="en">

  <head>
    <?php
      include('bdd.inc.php');
      include('../objet/callClass.php');
      include('error.php');
      include('function.php');

      if(session_id() == '' || !isset($_SESSION)) {
          // session isn't started
          session_start();
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

    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href='../css/profile.css' rel='stylesheet'>
    <!-- Custom fonts for this template-->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="../vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin.css" rel="stylesheet">

    <!--Jquery ui import -->
      <script src="../vendor/jquery/jquery.min.js"></script>
      <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.js"></script>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.ui.position.js"></script>
    <!-- Jquery multi select avec filter -->
      <link rel="stylesheet" href="../vendor/jquery-select-filter/jquery.multiselect.css">
      <script src="../vendor/jquery-select-filter/jquery.multiselect.js"></script>
      <link rel="stylesheet" href="../vendor/jquery-select-filter/jquery.multiselect.filter.css">
      <script src="../vendor/jquery-select-filter/jquery.multiselect.filter.js"></script>
      <!-- Jquery tags -->
      <link rel="stylesheet" href="../vendor/tags/css/prettytag.css">
      <script src="../vendor/tags/js/jquery.prettytag.js"></script>



      <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
      <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

   <!-- Page level plugin CSS-->
   <link href="../vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

   <!-- Custom styles for this template-->
   <link href="../css/sb-admin.css" rel="stylesheet">

   <!--Jquery ui import -->
     <script src="../vendor/jquery/jquery.min.js"></script>
     <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
     <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
     <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.js"></script>

     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-contextmenu/2.7.1/jquery.ui.position.js"></script>
   <!-- Jquery multi select avec filter -->
     <link rel="stylesheet" href="../vendor/jquery-select-filter/jquery.multiselect.css">
     <script src="../vendor/jquery-select-filter/jquery.multiselect.js"></script>
     <link rel="stylesheet" href="../vendor/jquery-select-filter/jquery.multiselect.filter.css">
     <script src="../vendor/jquery-select-filter/jquery.multiselect.filter.js"></script>
     <!-- Jquery tags -->
     <link rel="stylesheet" href="../vendor/tags/css/prettytag.css">
     <script src="../vendor/tags/js/jquery.prettytag.js"></script>


     <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
     <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  </head>
  <body id="page-top">

    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">


      <a class="navbar-brand mr-1" href="index.html">Via Bahuet</a>

      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Navbar Search -->
      <form method='GET' action='searchGlobal.php' class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
          <input type="text" name='searchGlobal' class="form-control" placeholder="Rechercher..." aria-label="Search" aria-describedby="basic-addon2">
          <div class="input-group-append">
            <button class="btn btn-primary" type="submit">
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
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
            <a class="dropdown-item" href="#">Action</a>
            <a class="dropdown-item" href="#">Another action</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a>
          </div>
        </li>
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            <i class="fas fa-user-circle fa-fw"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">

             <a class="dropdown-item" href=
             "<?php if(get_class($GLOBAL_ouser) == "user"){
             echo "pref.php";
             }else{
             echo "prefEnt.php"; }?>"
             >Préférences</a>
            <a class="dropdown-item" href="#">Activity Log</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" onclick="$('#logoutModal').modal('show')">Se déconnecter</a>
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
            <?php if (get_class($GLOBAL_ouser) == "user") {?>
            <a class="nav-link" href="profile.php">
            <?php }else{ ?>
            <a class="nav-link" href="profileent.php">
            <?php }?>
            <i class="fas fa-fw fa-briefcase"></i>
            <span>Mon profil</span>
          </a>
        </li>
        <?php
          if(get_class($GLOBAL_ouser) == 'user')
          {
            ?>
            <li class="nav-item dropdown">

                <a class="nav-link" href="amis.php">
                <i class="fas fa-fw fa-user-friends"></i>
                <span>Mes amis</span>
              </a>
            </li>
            <?php
          }
         ?>
        <li class="nav-item">
            <a class="nav-link" href="membre.php">
            <i class="fas fa-fw fa-user"></i>
            <span>Les Membres</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="entreprise.php">
            <i class="fas fa-fw fa-building"></i>
            <span>Les Entreprises</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="lesoffres.php">
            <i class="fas fa-fw fa-folder-open"></i>
            <span>Les offres</span></a>
        </li>
          <?php
          if(get_class($GLOBAL_ouser) == "entreprise")
          {
          ?>
        <li class="nav-item">
            <a class="nav-link" href="../publique/mesoffres.php">
            <i class="far fa-bookmark"></i>
            <span>Mes offres</span></a>
        </li>
      <?php } ?>
        <?php
        if (get_class($GLOBAL_ouser) == "user") {
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
        }

         ?>
      </ul>
