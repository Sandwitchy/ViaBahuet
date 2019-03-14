<?php 
    include('../tools/head.inc.php');

    // GESTION MESSAGE FLASH
    if(!isset($_SESSION['error'])) {
    $_SESSION['error'] = 0;
    }else if (($_SESSION['error'] != 0)||(isset($_SESSION['error'])))
    {
    error($_SESSION['error']);
    }
    if(!isset($_SESSION['success'])) {
    $_SESSION['success'] = 0;
    }elseif (($_SESSION['success'] != 0)||(isset($_SESSION['success'])))
    {
    success($_SESSION['success']);
    }
?>
<div class='container'>
    <h1>Mes Candidatures</h1>
    <?php 
        $GLOBAL_ouser -> getCandidature($conn);
    ?>
</div>