<?php
  include('tools/bdd.inc.php');
  include('objet/callClass.php');
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
    $oldimg = $ouser -> get_photoUser();
    $cheminimg = "image/";
    if ($e == 0)
    {
      if ((strstr($t,'png'))||(strstr($t,'jpg'))||(strstr($t,'jpeg'))||(strstr($t,'gif')))
      {
        if ($s > 2500000)
        {
          $_SESSION['error'] = 3;
          header('location:pref.php');
        }
        else
        {
          $ext = ".".pathinfo($n, PATHINFO_EXTENSION);
          $idUser = $ouser->get_idUser();
          $pathnewphoto = "image/".$idUser.$ext;
          move_uploaded_file($temp,$pathnewphoto);
          if ($oldimg != 'image/pic.jpg')
          {
            unlink($oldimg);
          }
          $sql = "UPDATE user SET photoUser = '$pathnewphoto' WHERE idUser = '$idUser'";
          $req_sql = $conn -> query($sql);
          unset($_SESSION['success']);
          $_SESSION['success'] = 3;
          header('location:pref.php');
        }
      }
      else
      {
        unset($_SESSION['error']);
        $_SESSION['error'] = 3;
        header('location:pref.php');
      }
    }else
    {
      unset($_SESSION['error']);
      $_SESSION['error'] = 4;
      header('location:pref.php');
    }

  }
 ?>
