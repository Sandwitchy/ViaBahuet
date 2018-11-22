<?php
  function error($error)
  {
    switch($error)
    {
      case 1:
        ?>
        <div class="alert alert-danger">
          <strong>Erreur :</strong> La ville entrée n'existe pas
        </div>
        <?php
        $_SESSION['error'] = 0;
        break;
      case 2:
        ?>
        <div class="alert alert-danger">
          <strong>Erreur :</strong> L'un des mots de passe est incorrect. Vérifier si il s'agît bien de votre mot de passe et
          que le nouveau mot de passe et sa confirmation soit identique.
        </div>
        <?php
          $_SESSION['error'] = 0;
        break;
      case 3:
        ?>
        <div class="alert alert-danger">
          <strong>Erreur :</strong> L'image ne correspond pas au type image autorisé ou l'image est trop lourde
        </div>
        <?php
          $_SESSION['error'] = 0;
        break;
      case 4:
        ?>
        <div class="alert alert-danger">
          <strong>Erreur :</strong>Une erreur est survenue
        </div>
        <?php
          $_SESSION['error'] = 0;
        break;
      case 5:
        ?>
        <div class="alert alert-danger">
          <strong>Erreur :</strong> Veuillez entrer un nom de ville existant
        </div>
        <?php
          $_SESSION['error'] = 0;
        break;
    }//end switch error
  }
  function success($success)
  {
    switch($success)
    {
      case 1:
        ?>
        <div class="alert alert-success">
          Vos informations ont bien été mis à jour
        </div>
        <?php
        $_SESSION['success'] = 0;
        break;
      case 2:
      ?>
      <div class="alert alert-success">
        Votre mot de passe à bien été mis à jour
      </div>
      <?php
      $_SESSION['success'] = 0;
        break;
      case 3:
      ?>
      <div class="alert alert-success">
        Votre Image de profil à bien été mis à jour
      </div>
      <?php
      $_SESSION['success'] = 0;
      break;
      case 4:
      ?>
      <div class="alert alert-success">
        L'entreprise a bien été ajoutée !
      </div>
      <?php
      $_SESSION['success'] = 0;
      break;

    }//end switch success
  }
 ?>
