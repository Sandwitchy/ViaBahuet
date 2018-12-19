<?php
  include('../tools/bdd.inc.php');
  include('../objet/callClass.php');
  if(session_id() == '' || !isset($_SESSION)) {
      // session isn't started
      session_start();
  }
  if (isset($_POST['envoieProPic']))
  {
      $n = $_FILES['imgProfile']['name'];
      $t = $_FILES['imgProfile']['type'];
      $s = $_FILES['imgProfile']['size'];
      $temp = $_FILES['imgProfile']['tmp_name'];
      $e = $_FILES['imgProfile']['error'];
      imgprofile($n,$t,$s,$temp,$e,$conn,$_SESSION['user_info']);
  }
  function imgprofile($n,$t,$s,$temp,$e,$conn,$ouser)
  {
      if (get_class($ouser) == 'user')
      {
        if ($e != 0)
        {
          $_SESSION['error'] = 4;
          header('location:../publique/pref.php');
        }
        else
        {
          $oldimg = $ouser -> get_photoUser();
          if ((strstr($t,'png'))||(strstr($t,'jpg'))||(strstr($t,'jpeg'))||(strstr($t,'gif')))
          {
            if ($s > 2500000)
            {
              $_SESSION['error'] = 3;
              header('location:../publique/pref.php');
            }
            else
            {
              $ext = ".".pathinfo($n, PATHINFO_EXTENSION);
              $idUser = $ouser->get_idUser();
              $pathnewphoto1 = "../image/".$idUser.$ext;
              $pathnewphoto = $idUser.$ext;
              move_uploaded_file($temp,$pathnewphoto1);
              if ($oldimg != 'pic.jpg')
              {
                unlink($oldimg);
              }
              $sql = "UPDATE user SET photoUser = '$pathnewphoto' WHERE idUser = '$idUser'";
              $req_sql = $conn -> query($sql);
              unset($_SESSION['success']);
              $_SESSION['success'] = 3;
              header('location:../publique/pref.php');
            }
          }
          else
          {
            unset($_SESSION['error']);
            $_SESSION['error'] = 3;
            header('location:../publique/pref.php');
          }
        }
    }//end if user
    elseif (get_class($ouser) == 'entreprise')
    {
      if ($e != 0)
      {
        $_SESSION['error'] = 4;
        header('location:../publique/prefEnt.php');
      }
      else
      {
        $oldimg = $ouser -> get_photoEnt();
        if ((strstr($t,'png'))||(strstr($t,'jpg'))||(strstr($t,'jpeg'))||(strstr($t,'gif')))
        {
          if ($s > 2500000)
          {
            $_SESSION['error'] = 3;
            header('location:../publique/prefEnd.php');
          }
          else
          {
            $ext = ".".pathinfo($n, PATHINFO_EXTENSION);
            $idUser = $ouser->get_idEnt();
            $pathnewphoto1 = "../image/".$idUser.$ext;
            $pathnewphoto = $idUser.$ext;
            move_uploaded_file($temp,$pathnewphoto1);
            if ($oldimg != 'pic.jpg')
            {
              unlink($oldimg);
            }
            $sql = "UPDATE entreprise SET photoEnt = '$pathnewphoto' WHERE idEntreprise = '$idUser'";
            $req_sql = $conn -> query($sql);
            unset($_SESSION['success']);
            $_SESSION['success'] = 3;
            header('location:../publique/prefEnt.php');
          }
        }
        else
        {
          unset($_SESSION['error']);
          $_SESSION['error'] = 3;
          header('location:../publique/prefEnt.php');
        }
      }//end error 4
    }//end if class
  }
 ?>
