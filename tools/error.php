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
          <strong>Erreur :</strong>Une erreur est survenue !
        </div>
        <?php
          $_SESSION['error'] = 0;
        break;
      case 5:
        ?>
        <div class="alert alert-danger">
          <strong>Erreur :</strong> Veuillez entrer un nom de ville existant.
        </div>
        <?php
          $_SESSION['error'] = 0;
        break;
        case 6:
          ?>
          <div class="alert alert-danger">
            <strong>Erreur :</strong> Les mots de passe sont différents !
          </div>
          <?php
            $_SESSION['error'] = 0;
          break;

          case 7:
            ?>
            <div class="alert alert-danger">
              <strong>Erreur :</strong> L'avis comporte plus de 300 caractères.
            </div>
            <?php
              $_SESSION['error'] = 0;
            break;
            case 9:
              ?>
              <div class="alert alert-danger">
                <strong>Erreur :</strong> Vous avez déja créé un avis pour cette entreprise.
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
          Vos informations ont bien été mises à jour
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
        Votre image de profil à bien été mise à jour
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
      case 5:
      ?>
      <div class="alert alert-success">
        Votre compte à bien été créé, vous pouvez maintenant vous connecter !
      </div>
      <?php
      $_SESSION['success'] = 0;
      break;

      case 6:
      ?>
      <div class="alert alert-success">
        Votre avis à bien été enregistré !
      </div>
      case 7:
      ?>
      <div class="alert alert-success">
        L'offre ou le stage a bien été créé !

      </div>
      <?php
      $_SESSION['success'] = 0;
      break;

      case 8:
      ?>
      <div class="alert alert-warning">
        Votre avis à bien été supprimé!
        </div>
      case 9:

      <div class="alert alert-success">
        Les informations ont bien été modifiées !
      </div>
      <?php
      $_SESSION['success'] = 0;
      break;
    }//end switch success
  }
 ?>
