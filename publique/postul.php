<?php 
    include('../tools/head.inc.php');
    /**
     * Vérification de l'existence du GET pour offres de stage
     */
    if($GLOBAL_ouser -> checkIfStupid($conn,(isset($_GET['offres']) ? $_GET['offres'] : $_GET['offreEmploi']),(isset($_GET['offres']) ?0:1))){
        $_SESSION['error'] = 10;
        echo "<script type='text/javascript'>document.location.replace('lesoffres.php');</script>";
    }
    $offres = new Offre();
    if((isset($_GET['offres']))&&(!$offres -> offreExiste($conn,$_GET['offres'],0))){
        echo "<script type='text/javascript'>document.location.replace('lesoffres.php');</script>";
    }
    elseif((isset($_GET['offres']))&&($offres -> offreExiste($conn,$_GET['offres'],0)))
    {
        ?>
            <!-- Confirmer postulez stage -->
            <div class='container' style='  margin: auto;
                                            width: 80%;
                                            padding: 10px;'>

                <div class="card">
                    <h5 class="card-header">Confirmations</h5>
                    <div class="card-body">
                        <h5 class="card-title">Voulez vous vraiment postulez à cette offre ?</h5>
                        <p class="card-text">Une fois votre candidature envoyé vous pourrais la consultée à tout moment dans l'onglet <a href="tosoon"><u><i>Mes Candidatures</i></u></a></p>
                        <form method='post' action='../Back/postul.trait.php'>
                            <input type='hidden' name='offreStage' value='<?php echo $_GET['offres']?>'>
                            <button type='submit' class="btn btn-success">Postuler</button>
                            <a href="lesoffres.php" class="btn btn-secondary">Annuler</a>
                        </form>
                    </div>
                </div>

            </div>
        <?php
    }
     /**
     * Vérification de l'existence du GET pour offres d' Emploi
     */
    $offres = new Offre();
    if((isset($_GET['offreEmploi']))&&(!$offres -> offreExiste($conn,$_GET['offreEmploi'],1))){
        echo "<script type='text/javascript'>document.location.replace('lesoffres.php');</script>";
    }elseif((isset($_GET['offreEmploi']))&&($offres -> offreExiste($conn,$_GET['offreEmploi'],1))){
        ?>
            <!-- Confirmer postulez stage -->
            <div class='container' style='  margin: auto;
                                            width: 80%;
                                            padding: 10px;'>

                <div class="card">
                    <h5 class="card-header">Confirmations</h5>
                    <div class="card-body">
                        <h5 class="card-title">Voulez vous vraiment postulez à cette offre ?</h5>
                        <p class="card-text">Une fois votre candidature envoyé vous pourrais la consultée à tout moment dans l'onglet <a href="tosoon"><u><i>Mes Candidatures</i></u></a></p>
                        <form method='post' action='../Back/postul.trait.php'>
                            <input type='hidden' name='offreEmploi' value='<?php echo $_GET['offreEmploi']?>'>
                            <button type='submit' class="btn btn-success">Postuler</button>
                            <a href="lesoffres.php" class="btn btn-secondary">Annuler</a>
                        </form>
                    </div>
                </div>

            </div>
        <?php
    }
    
    ?>
    