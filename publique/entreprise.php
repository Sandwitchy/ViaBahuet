<?php
//Ajout du head de page
include('../tools/head.inc.php');
?>
<style>
.ui-autocomplete {
  max-height: 200px;
  overflow-y: auto;
  /* prevent horizontal scrollbar */
  overflow-x: hidden;
}
/* IE 6 doesn't support max-height
 * we use height instead, but this forces the menu to always be this tall
 */
* html .ui-autocomplete {
  height: 100px;
}
</style>
<script>
  $( function() {
    var availableTags = [
      <?php
     $sql_libville = "SELECT * FROM ville";
     $req_sql = $conn -> query($sql_libville);
     $i = 1;
     while ($res_req = $req_sql->fetch())
     {
       if ($i == 1)
       {
         $tab = '"'.$res_req['libVill'].'"';
         $i = 0;
       }else {
         $tab = $tab.',"'.$res_req['libVill'].'"';
       }
     }
     echo $tab;
    ?>
    ];
    $( "#villeEnt" ).autocomplete({
      source: availableTags
    });
  } );
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
</body>
</html>
  <div id="content-wrapper">
    <?php
    if(!isset($_SESSION['error']))
     {
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
     /* Moteur de recherche */
     if(isset($_POST['envoiefilter']))
     {
       $i = 0;
       $condition = "";
       $join = "";
       $checkexample = 0;
       /* Option Select */
         if (isset($_POST['example']))
         {
           $checkexample = 1;
           foreach ($_POST['example'] as $key)
           {
             if ($i != 0)
             {
                $condition = $condition.' OR';
              }
             switch ($key) {
               case 0://cas créer par user
                 $condition = $condition." entreprise.createbyuser = 1";
                 break;
               case 1://cas compte entreprise
                 $condition = $condition." entreprise.createbyuser = 0";
                 break;
               case 2://cas même ville
                 $INSEE = $GLOBAL_ouser->get_ville()->get_INSEE();
                 $condition = $condition." ville.INSEE = '$INSEE'";
                 break;
               case 3://cas même tags
                 $tag = $GLOBAL_ouser->selecttags($conn);
                 if (get_class($GLOBAL_ouser) == 'user')
                 {
                   $id = $GLOBAL_ouser->get_idUser();
                   $condition = $condition." tagent.idTags IN (SELECT idTags FROM taguser WHERE idUser = '$id')";
                 }else {
                   $id = $GLOBAL_ouser->get_idEnt();
                   $condition = $condition." tagent.idTags IN (SELECT idTags FROM tagent WHERE idEntreprise = '$id')";
                 }
                 break;
             }
              $i++;
           }
       }
       /* input ville */
       if ((isset($_POST['villesearch']))&&($_POST['villesearch'] != NULL))
       {
          $ville = $conn -> quote($_POST['villesearch']);
         if ($checkexample == 0) {
           $condition = $condition."ville.libVill = $ville";
         }else {
           $condition = $condition."OR  ville.libVill = $ville";
         }
       }
       $sql = " SELECT * FROM concerner c
                LEFT JOIN entreprise ON entreprise.idEntreprise = c.idEntreprise
                LEFT JOIN ville ON ville.INSEE = c.INSEE
                LEFT JOIN tagent ON entreprise.idEntreprise = tagent.idEntreprise
                WHERE ".$condition.
                " GROUP BY entreprise.idEntreprise ASC";
       $ocontroller = new Controller($conn);
       $res = $ocontroller -> envoieSQL($sql,$conn);
       $i = 0;
      }else {
        $ocontroller = new Controller($conn);
        $table[0] = '';
        $res = $ocontroller -> selectAllTable("entreprise",$table);
        $i = 0;
      }
    ?>

    <div class="container-fluid">
    <div class='col-xs-4 border border-secondary' style='padding:2%'>
      <h5>Option</h5>
      <form method='post' action='#'>
        <div class='row'>
          <div class='col-md'>
            <button  onclick="$('#creaentreprise').modal('show')" type="button" class="btn btn-primary" name="button">Ajouter une entreprise</button>
          </div>
          <div class='col-sm'>
            <select name="example[]" multiple size="3">
              <optgroup label="Création">
                <option value="0">Créer par un membre</option>
                <option value="1">Compte entreprise</option>
              </optgroup>
              <optgroup label="Adresse">
                <option value="2">Même ville que moi</option>
              </optgroup>
              <optgroup label='Tag'>
                <option value='3'>Même Tag que moi</option>
              </optgroup>
            </select>
          </div>
          <div class='form-group col-sm'>
            <input type='text' class="form-control" placeholder="Chercher une ville..." name='villesearch'  id='villeEnt'>
          </div>
          <div class='col-sm'>
            <button type='submit' name='envoiefilter' class='btn btn-primary'><i class="fas fa-search"></i></button>
          </div>
        </div>
      </form>
    </div>
    <!-- Affichage Entreprise -->
    <div class="col-xl-14 border border-secondary" style='padding:2%;margin-top:1%;'>
      <div class='row'>
        <?php
          if (count($res) == 0)
          {
            echo "Aucun résultat";
          }else {
          foreach ($res as $enter)
          {
              ?>
              <div class="card" style='width:15rem;margin:4px;'>
                <div class='vb-profilepic card-head img-thumbnail' style="background-image:url('../image/<?php echo $enter['photoEnt']; ?>');
                                                                          width:100%;
                                                                          height:220px;"></div>
                <div class="card-body">
                  <h5 class="card-title"><?php echo $enter['nameEntreprise']; ?></h5>
                  <p class="card-text"><?php echo substr($enter['descEntreprise'],0,50); ?></p>
                    <?php
                      if ($enter['createbyuser'] == 0) {
                        echo "<p class='text-muted'>Tags: <br>";
                        $identre = $enter['idEntreprise'];
                        $sqltags = "SELECT * FROM tags t,tagent e WHERE e.idTags = t.idTags AND idEntreprise = '$identre'";
                        $reqtags = $conn -> query($sqltags)or die($sqltags);
                        $tags = "";
                        $bool = 0;
                        if ($reqtags -> rowCount() == 0)
                        {
                          echo "Aucun tags";
                        }else {
                          while ($restags = $reqtags -> fetch())
                          {
                            if ($bool == 0)
                            {
                              $bool = 1;
                              $tags = $restags['libTags'];
                            }else {
                              $tags = $tags." - ".$restags['libTags'];
                            }
                          }
                          echo $tags."</p>";
                        }
                      }
                   ?>
                  <?php
                  if ((get_class($GLOBAL_ouser)=='entreprise')&&($enter['idEntreprise'] == $GLOBAL_ouser->get_idEnt()))
                  {
                    ?> <p class="text-muted">Vous</p>
                  </div>
                  <div class='card-footer'>
                    <a href="profileent.php" class="btn btn-primary">Voir profil</a>
                  </div><?php
                  }
                  elseif($enter['createbyuser'] == 1)
                  {
                    ?> <p class="text-muted">Entreprise créer par un membre</p>
                  </div>
                  <div class='card-footer'>
                    <a href="profileEntO.php?ent=<?php echo $enter['idEntreprise'];  ?>" class="btn btn-primary">Voir profil</a>
                  </div><?php
                  }else
                  {
                    ?> <p class="text-muted">Est une entreprise</p>
                  </div>
                  <div class='card-footer'>
                    <a href="profileEntO.php?ent=<?php echo $enter['idEntreprise'];  ?>" class="btn btn-primary">Voir profil</a>
                  </div><?php
                  } ?>

              </div>
              <?php
              if ($i == 3)
              {
                ?><div class="w-100"></div><?php
                $i = 0;
              }else {
                $i++;
              }
            }
          }
        ?>
      </div>
    </div>

<!--Modal de création entreprise -->
    <div class="modal fade" id="creaentreprise" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Créer une Entreprise</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <form  action="../Back/trait.php" method="post">
              <div class="form-group">
                <div class="form-label-group">
                  <input type="text" id='inputEnt'  name='nameEnt' class="form-control" placeholder="login" required="required">
                  <label for="inputEnt">Nom de l'entreprise</label>
                </div>
              </div>
              <div class="form-group">

                <label for="descEnt">Description de l'entreprise</label>
                <textarea class="form-control" id='descEnt' name="descEnt" style="resize:none;"  rows="8" cols="80" maxlength="2048"></textarea>
              </div>
              <div class="row">
                <div class="col-md">
                  <div class="form-group">
                    <div class="form-label-group">
                      <input type="text" id='villeEnt' name='vilEnt' class="form-control ui-widget" placeholder="Ville" required="required">
                      <label for="villeEnt">Ville</label>
                    </div>
                  </div>
                </div>
                <div class="col-md">
                  <div class="form-group">
                    <div class="form-label-group">
                      <input type="text" id='inputEnt' name='rueEnt' class="form-control" placeholder="Rue">
                      <label for="inputEnt">Rue</label>
                    </div>
                  </div>
                </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
              <input type='submit' name='registerEnt' value='Enregistrer' class='btn btn-primary'>
            </form>
          </div>
        </div>
      </div>
    </div>


    </div>
    <!-- /.container-fluid -->

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
