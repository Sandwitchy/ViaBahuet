<?php
//Ajout du head de page
include('../tools/head.inc.php');
?>
<script>
$(function(){
  $("select").multiselect({
    // shows header
     header: true,
     // height
     height: 200,
     // min width
     minWidth: 250,
     // additional classes
     classes: '',
     // custom text
     checkAllText: 'Tout cocher',
     uncheckAllText: 'Tout décocher',
     noneSelectedText: 'Choisir des options',
     // shows check/uncheck all links
     showCheckAll: true,
     showUncheckAll: true,
     // text for selected options
     selectedText: '# selectionné',
     selectedList: 0,
     // clise icon
     closeIcon: 'ui-icon-circle-close',
     // show/hide animations
     show: null,
     hide: null,
     // auto open
     autoOpen: false,
     // allows to select multiple options
     multiple: true,
     // position options
     position: {},
     // where to append the multiple select to
     appendTo: null,
     // menu width
     menuWidth:null,
     // list separator
     selectedListSeparator: ',',
     // disables input on toggle
     disableInputsOnToggle: true,
     // grouped columns
     groupColumns: false
  }).multiselectfilter({
    // The text to appear left of the input.
    label: 'Filtre:',
    // The width of the input in pixels.
    width: null,
    // The HTML5 placeholder attribute value of the input.
    placeholder: 'Saisir un filtre',
    // A boolean value denoting whether or not to reset the search box & any filtered options when the widget closes.
    autoReset: false,
    // in milliseconds
    debounceMS: 250
  });
});
</script>
<?php
$oController = new Controller($conn);
$FROM = "user u";
if(isset($_POST['rechercher']))
{
  if(!empty($_POST['rechercher']))
  {
    $isEmpty = 0;
    $conditions = "WHERE nameUser = ".$conn->quote($_POST['rechercher']);
  }
  else
  {
    $isEmpty = 1;
    $conditions = '';
  }
}
else {
  $isEmpty = 1;
  $conditions = '';
}

if(isset($_POST['filter']))
{
  if($isEmpty == 1)
  {
    $conditions = "WHERE ";
  }

  /* Option Select */
    if(isset($_POST['filter']))
    {
      foreach ($_POST['filter'] as $key)
      {
        switch ($key) {
          case 0://cas même ville
              $conditions = $conditions." u.INSEE = ".$conn->quote($GLOBAL_ouser->get_ville()->get_INSEE());
            break;
          case 1://cas est mon ami
              $FROM .= ",amis a";
              $conditions .= "u.idUser = a.idUser2";
              $conditions = $conditions." AND a.idUser1 = ".$GLOBAL_ouser->get_idUser();
            break;
        }
       }
    }
}
$SQL = "SELECT * FROM ".$FROM." ".$conditions;
$req = $oController->envoieSQL($SQL,$conn);

if(isset($_POST['reset']))
{
  $noCondi[0] = '';
  $req = $oController->selectAllTable("user u",$noCondi);

}
?>

  <div id="content-wrapper">

    <div class="container-fluid">

      <!-- BARRE DE RECHERCHE -->
      <form class="" action="#" method="post">
        <input type="text" name="rechercher">
        <input type="submit" name="" value="Rechercher">
        <input type="submit" name="reset" value="Retour">
        <select name="filter[]" multiple size="5">
            <?php
              if(!empty($GLOBAL_ouser->get_ville()->get_INSEE()))
              {
              ?>
              <option value="0">Même ville que moi</option>
              <?php
              }
            ?>
            <option value="1">Est mon ami</option>
        </select>
      </form>
      <script type="text/javascript">
      $(function(){
      $("select").multiselect();
      });
      </script>

<body>
<br>
<script>
function gestionamis(value,type){
    $.ajax({
          // chargement du fichier externe Taggestion.php
          url      : "../Back/amisgestion.php",
          // Passage des données au fichier externe (ici le nom cliqué)
          data     : {
                      idamis: value,
                      idUser: <?php
                                    if (get_class($GLOBAL_ouser) == 'user')
                                    {
                                      echo $GLOBAL_ouser->get_idUser() ;
                                    }
                                    ?>,
                      type:type
                      },
          cache    : true,
          dataType : "json",
          method   : "POST",
          error    : function(request, error) { // Info Debuggage si erreur
                       alert("Erreur : responseText: "+request.responseText);
                     },
          success  : function() {
                      location.reload();
                     }
     });
}
</script>
      <div class="col-lg"> <!-- ELEMENT A GAUCHE DE LA PAGE-->
        <div class="row">
          <div class="col-md-24">
                <div class="row">

                      <?php
                      for($i = 0; $i < count($req) ; $i++)
                      {
                      ?>
                      <div class="card" style='width:15rem;margin:5px;'>
                        <div class='vb-profilepic card-head img-thumbnail' style="background-image:url('../image/<?php echo $req[$i]['photoUser']; ?>');
                                                                                  width:100%;
                                                                                  height:220px;"></div>
                          <div class="card-body">
                          <h5 class="card-title"><?php echo $req[$i]['nameUser']; ?></h5>
                          <p> <a href="profile.php?user=<?php echo $req[$i]['idUser']; ?>"><?php echo $req[$i]["nameUser"]." ".$req[$i]["preUser"]; ?></a> </p>
                        </div>

                          <?php
                          if ((get_class($GLOBAL_ouser) == "user"))
                          {
                            ?><div class='card-footer'><?php
                            $bool =$GLOBAL_ouser->checkFriend($req[$i]['idUser'],$conn);
                            if ($req[$i]['idUser'] == $GLOBAL_ouser->get_idUser())
                            {
                              ?>
                            <a  class="btn btn-danger btn-sm" style='color:white;'>Vous êtes si seul?</a>
                              <?php
                            }
                            else
                            {
                              if($bool == true)
                              {
                              ?>
                              <button onclick="gestionamis(<?php echo $req[$i]['idUser']; ?>,1)" class="btn btn-danger btn-sm" ><?php echo "Retirer l'ami"; ?></button>
                              <?php
                              }
                              else
                              {
                                ?>
                                <button onclick="gestionamis(<?php echo $req[$i]['idUser']; ?>,0)"  class="btn btn-success btn-sm" ><?php echo "Ajouter en ami"; ?></button>
                                <?php
                              }
                            }
                            ?></div><?php
                          }
                          ?>

                        </div>

                      <?php
                      }
                      ?>
                      </div>
          </div>
        </div>
      </div>

    </div>
    <!-- Sticky Footer -->
    <footer class="sticky-footer">
      <div class="container my-auto">
        <div class="copyright text-center my-auto">
          <span>Copyright © Your Website 2018</span>
        </div>
      </div>
    </footer>

  </div>
  <!-- /.content-wrapper -->

<?php
//ajout du pied de page
include('../tools/foot.inc.php');
 ?>
