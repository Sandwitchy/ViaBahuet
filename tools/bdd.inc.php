<?php
//error handler function
function customError($errno, $errstr) {
  echo "<b>Error:</b> [$errno] $errstr
        <video width='240' height='auto' autoplay loop >
          <source src='../image/erreur_php.mp4' type='video/mp4'>
        </video>"
        ;
}

//set error handler
set_error_handler("customError");
$serveur = "mysql:host=localhost;dbname=ViaBahuet";//initialisation des variables de connexion
$base = "ViaBahuet";
$user = "root";
$pass = "";
try {
    $conn = new PDO($serveur, $user, $pass);
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
}
?>
