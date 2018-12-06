<head>
<!-- Bootstrap core CSS-->
<link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom fonts for this template-->
<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<!-- Custom styles for this template-->
<link href="../css/sb-admin.css" rel="stylesheet">
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
</head>
<body class="bg-dark">
<div class="container">
  <div class='col-md-10 mx-auto mt-5'>

<?php
include('../tools/bdd.inc.php');
include('../objet/callClass.php');
include('../tools/error.php');
  //gestion de l'incription d'un nouvelle USER
  if (isset($_POST['register']))
  {
    ?>
    <h4 style='text-align:center;color:white;'>Est-ce vous?</h4>
    <div class='row'>
    <?php
    //récupere les informations des formulaires
    $var_NameUser =  $_POST['name'];
    //vérifie si les mots de passe sont identique
    $ouser = new entreprise();
    $res = $ouser -> checkifexist($var_NameUser,$conn);
    if ($res !== false)
    {
      foreach ($res as $entreprise)
      {
        ?>
        <div class="card" style="width: 18rem;margin:1%;">
          <div class="card-body">
            <h5 class="card-title"><?php echo $entreprise['nameEntreprise']; ?></h5>
            <h6 class="card-subtitle mb-2 text-muted">à <?php echo $entreprise['libVill']; ?></h6>
            <p class="card-text">
              <?php
              if (strlen($entreprise['descEntreprise'])>50)
              {
                echo substr($entreprise['descEntreprise'],0,50)." ...";
              }else {
                echo $entreprise['descEntreprise'];
              }

              ?></p>
              <?php
                if ($entreprise['createbyuser'] == 1)
                {
                  ?>
                  <div class="card-text">
                    <small class="text-muted">créer par un utilisateur classique</small>
                  </div>
                  <form method='post' action='#'>
                    <input type='hidden' value='<?php echo $entreprise['idEntreprise']; ?>' name='identre'>
                    <input type='submit' class="btn btn-sm btn-outline-info" name='mergedata' value="C'est moi!">
                  </form>
                  <?php
                }elseif ($entreprise['createbyuser'] == 0) {
                  ?>
                  <div class="card-text">
                    <a class="text-muted" data-toggle="tooltip" title="Si il s'agît de vous veuillez contactez l'administrateur" data-placement="bottom">Déja créer par une entreprise</a>
                  </div>
                  <?php
                }
               ?>
          </div>
        </div>
        <?php
      }
    }else {
      //aucun résultat trouvé
      header('location:formcreateentre.php?user=none');
    }
  }
  //fusion du nouveau compte avec ancien compte
  if (isset($_POST['mergedata']))
  {
    $id = $_POST['identre'];
    header('location:formcreateentre.php?user='.$id);
  }
  //aucun compte choisi
  if (isset($_POST['none']))
  {
    header('location:formcreateentre.php?user=none');
  }
 ?>
</div>
<form method='post'>
<input type='submit' name='none'  class='btn btn-outline-warning' value="ce n'est pas moi">
</form>
</div>
</div>
</body>
