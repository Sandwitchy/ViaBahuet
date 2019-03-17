<?php
//Ajout du head de page

// var_dump($GLOBAL_ouser->afficheAllOffres($conn));
include('../tools/head.inc.php');
$SQL_TypeEmp = "SELECT * FROM typeemploi";
$req = $conn->query($SQL_TypeEmp);
?>
<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});

$(document).ready(function() {
    $('#stagetable').DataTable( {
      "language": {
            "lengthMenu": "Afficher _MENU_ résultats par page",
            "zeroRecords": "Aucun résultat - désolé",
            "info": "Page _PAGE_ sur _PAGES_",
            "infoEmpty": "Pas de résultats",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "search":         "Rechercher:",
            "paginate": {
                "first":      "First",
                "last":       "Last",
                "next":       "Suivant",
                "previous":   "Précédent"},

      }
    } );
    $('#offretable').DataTable( {
      "language": {
            "lengthMenu": "Afficher _MENU_ résultats par page",
            "zeroRecords": "Aucun résultat - désolé",
            "info": "Page _PAGE_ sur _PAGES_",
            "infoEmpty": "Pas de résultats",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "search":         "Rechercher:",
            "paginate": {
                "first":      "First",
                "last":       "Last",
                "next":       "Suivant",
                "previous":   "Précédent"}

      }
    } );
} );

$( function() {
    $( "#tabs" ).tabs();
  } );
</script>

  <div id="content-wrapper">
    <?php
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

      <div id="tabs">
        <ul>
          <li><a href="#tabs-1">Stage</a></li>
          <li><a href="#tabs-2">Offre d'emploi</a></li>
        </ul>
        <div id="tabs-1">
          <?php DataTableStage("SELECT * FROM stage S,entreprise ent, ville V, concerner C
                                WHERE ent.idEntreprise = C.idEntreprise
                                AND C.INSEE = V.INSEE
                                AND ent.idEntreprise = S.idEntreprise
                                AND S.status = 0
                                AND s.idUser IS NULL
                                GROUP BY S.idStage",$conn,0);
          ?>
        </div> <!-- fin tab 1-->
        <div id="tabs-2">
            <?php DataTableOffre("SELECT * FROM emploioff E, entreprise ent, typeemploi TypeE, ville V, concerner C
                                  WHERE ent.idEntreprise = C.idEntreprise
                                  AND C.INSEE = V.INSEE
                                  AND ent.idEntreprise = E.idEntreprise
                                  AND E.idEmpOff = TypeE.idTypeEmp
                                  AND statusEmpOff = 0;
                                  AND e.idUser IS NULL
                                  GROUP BY E.idEmpOff",$conn,0); ?>
        </div><!-- fin tab 2 -->
      </div><!-- FIN DIV TAB-->

      </div><!-- fin container -->
    </div><!-- fin wrapper -->

    <!-- Sticky Footer -->
    <footer class="sticky-footer">
      <div class="container my-auto">
        <div class="copyright text-center my-auto">
          <span>Copyright © Your Website 2018</span>
        </div>
      </div>
    </footer>

  </div>
  <script type="text/javascript">
    function getStage()
    {
      document.getElementById("stage").value = "stage";
      document.getElementById("offre").value = "0";

      if(document.getElementById("stage").value == "stage")
      {
        document.getElementById("DD").style = "display:flow";
        document.getElementById("DF").style = "display:flow";
        document.getElementById("salaire").style = "display:none";
        document.getElementById("formTypeEmp").style = "display:none";

      }
    }
    function getOffre()
    {
      document.getElementById("offre").value = "offre";
      document.getElementById("stage").value = "0";

      if(document.getElementById("offre").value == "offre")
      {
        document.getElementById("formTypeEmp").style = "display:flow";
        document.getElementById("salaire").style = "display:flow";
        document.getElementById("DD").style = "display:none";
        document.getElementById("DF").style = "display:none";
      }
    }

    function getDate()
    {
      if(document.getElementById("selectTypeEmp").value == "CDD")
      {
        document.getElementById("DD").style = "display:flow";
        document.getElementById("DF").style = "display:flow";
      }
      else {
        document.getElementById("DD").style = "display:none";
        document.getElementById("DF").style = "display:none";
      }
    }
  </script>
  <!-- /.content-wrapper -->

<?php
//ajout du pied de page
include('../tools/foot.inc.php');
 ?>
