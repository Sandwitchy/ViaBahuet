<?php
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
