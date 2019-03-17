<?php


  //créer une vue vtags qui référence tout les tags et leur type
  function createviewtags($conn)
  {
    $sql = "CREATE VIEW vtags (idtags,libtags) AS
            SELECT idtags,libtags
            FROM tags t";
    $conn -> query($sql);
    return true;
  }
  function selectviewtags($conn)
  {
    $sql = "SELECT * FROM vtags";
    $req = $conn -> query($sql);
    $res = $req -> fetchall(PDO::FETCH_ASSOC);
    return $res;
  }
  function dateFr($date)
  {
    return strftime('%d-%m-%Y',strtotime($date));
  }


  function DataTableStage($SQL_stage,$conn,$bool)
  {
    if((get_class($_SESSION['user_info']) == "entreprise")&&($bool == 1))
    {
    ?>
    <table id="stagetable" class="display" style="font-size:12.5px;width:100%;font-style:italic">
      <thead>
        <tr>
            <th>#</th>
            <th>Date commentaire</th>
            <th>Commentaire</th>
            <th>Date début</th>
            <th>Date fin</th>
            <th>Libellé</th>
            <th>Description</th>
            <th>Exigences</th>
            <th></th>
            <th></th>
        </tr>
      </thead>
      <tbody>
        <?php
          $req = $conn->query($SQL_stage) or die($SQL_stage);
          while ($res = $req -> fetch())
          {
          ?>
          <tr>
            <td><?php echo $res['idStage']; ?></td> <!-- 9 TD -->
            <td><?php echo $res['dateComm']; ?></td>
            <td><?php echo $res['contentComm']; ?></td>
            <td><?php echo dateFr($res['datedebStage']); ?></td>
            <td><?php echo dateFr($res['datefinStage']); ?></td>
            <td><?php echo $res['libStage']; ?></td>
            <td><?php echo $res['descStage']; ?></td>
            <td><?php echo $res['exiStage']; ?></td>
            <td> <a href="../Back/modif.stage.php?stage=<?php echo $res['idStage']; ?>" name="idStage"><i class="fas fa-edit" style="color:#FFC312"></i></a> </td>
            <td> <a href="#" id="deletestage" value="<?php echo $res['idStage']; ?>" onclick="recupidStage(<?php echo $res['idStage']; ?>)"><i class="fas fa-trash-alt" style="color:#EA2027;"></i></a></td>
          </tr>
          <?php
          }
        ?>
      </tbody>
      <tfoot>
      <tr>
        <th>#</th>
        <th>Date commentaire</th>
        <th>Commentaire</th>
        <th>Date début</th>
        <th>Date fin</th>
        <th>Libellé</th>
        <th>Description</th>
        <th>Exigences</th>
        <th>Qui ?</th>
      </tr>
      </tfoot>
    </table>
    <?php
    }
    else
    {
    ?>
    <table id="stagetable" class="display" style="font-size:12.5px;width:100%;font-style:italic">
      <thead>
        <tr>
            <th>#</th>
            <th>Entreprise</th>
            <th>Ville</th>
            <th>Date début</th>
            <th>Date fin</th>
            <th>Libellé</th>
            <th>Description</th>
            <th>Exigences</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $req = $conn->query($SQL_stage) or die($SQL_stage);
          while ($res = $req -> fetch())
          {
            $idEntreprise = $res['idEntreprise'];
            $SQL_tag = "SELECT libtags FROM tagent, tags,entreprise WHERE tagent.idTags = tags.idTags AND tagent.idEntreprise = $idEntreprise";
            $reqtag = $conn->query($SQL_tag) or die($SQL_tag);
            $restag = $reqtag -> fetch();
          ?>
          <tr>
            <td><?php echo $res['idStage']; ?></td> <!-- 9 TD -->
            <td> <a style="color:rgb(<?php echo rand(0,200); ?>,<?php echo rand(0,200) ;?>, <?php echo rand(0,200);?>);text-decoration:underline;" class="btn" href="#" data-toggle="tooltip" title="<?php gettags($restag); ?>"><?php echo $res['nameEntreprise']; ?></a> </td>
            <td><?php echo $res['libVill']; ?></td>
            <td><?php echo $res['datedebStage']; ?></td>
            <td><?php echo $res['datefinStage']; ?></td>
            <td><?php echo $res['libStage']; ?></td>
            <td><?php echo $res['descStage']; ?></td>
            <td><?php echo $res['exiStage']; ?></td>
          </tr>
          <?php
          }
        ?>
      </tbody>
      <tfoot>
      <tr>
        <th>#</th>
        <th>Entreprise</th>
        <th>Ville</th>
        <th>Date début</th>
        <th>Date fin</th>
        <th>Libellé</th>
        <th>Description</th>
        <th>Exigences</th>
      </tr>
      </tfoot>
    </table>
    <?php
    }
  }

  function DataTableOffre($SQL_offre,$conn,$bool)
  {
    if((get_class($_SESSION['user_info']) == "entreprise")&&($bool == 1))
    {
    ?>
    <table id="offretable" class="display" style="font-size:12.5px;font-style:italic;width:100%">
      <thead>
        <tr>
            <th>#</th>
            <th>Type d'emploi</th>
            <th>Libellé</th>
            <th>Description</th>
            <th>Exigences</th>
            <th>Salaire / Mois Brut</th>
            <th>Date début</th>
            <th>Date fin</th>
            <th></th>
            <th></th>
        </tr>
      </thead>
      <tbody>
        <?php
          $req = $conn->query($SQL_offre) or die($SQL_offre);
          $i = 0;
          while ($res = $req -> fetch())
          {
            $i = $i++;
          ?>
          <tr>
            <td><?php echo $res['idEmpOff']; ?></td> <!-- 8 TD -->
            <td><?php echo $res['libTypeEmp']; ?></td>
            <td><?php echo $res['libEmpOff']; ?></td>
            <td><?php echo $res['descEmpOff']; ?></td>
            <td><?php echo $res['exiEmpOff']; ?></td>
            <td><?php echo $res['salaireMoisBrut']."€"; ?></td>
            <td><?php echo dateFr($res['DDCDD']); ?></td>
            <td><?php echo dateFr($res['DFCDD']); ?></td>
            <td> <a href="../Back/modif.offre.php?offre=<?php echo $res['idEmpOff']; ?>" name="idStage"><i class="fas fa-edit" style="color:#FFC312"></i></a> </td>
            <td> <a href="#" id="deleteoffre" value="<?php echo $res['idEmpOff']; ?>" onclick="recupidOffre(<?php echo $res['idEmpOff']; ?>)"><i class="fas fa-trash-alt" style="color:#EA2027;"></i></a></td>
          </tr>
          <?php
          }
        ?>
      </tbody>
      <tfoot>
      <tr>
        <th>#</th>
        <th>Type d'emploi</th>
        <th>Libellé</th>
        <th>Description</th>
        <th>Exigences</th>
        <th>Salaire / Mois Brut</th>
        <th>Date début</th>
        <th>Date fin</th>
        <th></th>
        <th></th>
      </tr>
      </tfoot>
    </table>
    <?php
    }
    else
    {
    ?>
      <table id="offretable" class="display" style="font-size:12.5px;font-style:italic;width:100%">
        <thead>
          <tr>
              <th>#</th>
              <th>Entreprise</th>
              <th>Ville</th>
              <th>Type d'emploi</th>
              <th>Libellé</th>
              <th>Description</th>
              <th>Exigences</th>
              <th>Salaire / Mois Brut</th>
              <th>Date début</th>
              <th>Date fin</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $SQL_tag = "SELECT libtags FROM tagent, tags WHERE tagent.idTags = tags.idTags";
            $reqtag = $conn->query($SQL_tag) or die($SQL_tag);
            $restag = $reqtag -> fetch();
            $req = $conn->query($SQL_offre) or die($SQL_offre);
            $i = 0;
            while ($res = $req -> fetch())
            {
              $i = $i++;
            ?>
            <tr>
              <td> <?php echo $res['idEmpOff']; ?> </td> <!-- 8 TD -->
              <td> <a style="color:rgb(<?php echo rand(0,200); ?>,<?php echo rand(0,200) ;?>, <?php echo rand(0,200);?>);text-decoration:underline;" class="btn" href="#" data-toggle="tooltip" title="<?php gettags($restag); ?>"><?php echo $res['nameEntreprise']; ?></a> </td>
              <th> <?php echo $res['libVill']; ?> </th>
              <td><?php echo $res['libTypeEmp']; ?></td>
              <td><?php echo $res['libEmpOff']; ?></td>
              <td><?php echo $res['descEmpOff']; ?></td>
              <td><?php echo $res['exiEmpOff']; ?></td>
              <td><?php echo $res['salaireMoisBrut']; ?></td>
              <td><?php echo $res['DDCDD']; ?></td>
              <td><?php echo $res['DFCDD']; ?></td>
            </tr>
            <?php
            }
          ?>
        </tbody>
        <tfoot>
        <tr>
          <th>#</th>
          <th>Entreprise</th>
          <th>Ville</th>
          <th>Type d'emploi</th>
          <th>Libellé</th>
          <th>Description</th>
          <th>Exigences</th>
          <th>Salaire / Mois Brut</th>
          <th>Date début</th>
          <th>Date fin</th>
        </tr>
        </tfoot>
      </table>
      <?php
    }

  }

 ?>
 <?php
 function gettags($restag)
 {
   if($restag != "")
   {
     $i = 1;
     foreach($restag as $untag)
     {
       if($i == 1)
       {
         echo $untag;
         $i = 0;
       }
       else {
         $untag = " - ".$untag;
         echo $untag;
       }
     }
   }
   else
   {
     echo "Aucun tag";
   }

 }
?>
<script type="text/javascript">

  function recupidStage(idStage)
  {
    if(confirm("Voulez vous supprimer ce stage / offre ?"))
    {
      document.location.replace('../Back/trait.php?idStage='+idStage);
    }
  }

  function recupidOffre(idOffre)
  {
    if(confirm("Voulez vous supprimer ce stage / offre ?"))
    {
      document.location.replace('../Back/trait.php?idOffre='+idOffre);
    }
  }
</script>

<script type="text/javascript">
//made by vipul mirajkar thevipulm.appspot.com
var TxtType = function(el, toRotate, period) {
      this.toRotate = toRotate;
      this.el = el;
      this.loopNum = 0;
      this.period = parseInt(period, 10) || 2000;
      this.txt = '';
      this.tick();
      this.isDeleting = false;
  };

  TxtType.prototype.tick = function() {
      var i = this.loopNum % this.toRotate.length;
      var fullTxt = this.toRotate[i];

      if (this.isDeleting) {
      this.txt = fullTxt.substring(0, this.txt.length - 1);
      } else {
      this.txt = fullTxt.substring(0, this.txt.length + 1);
      }

      this.el.innerHTML = '<span class="wrap">'+this.txt+'</span>';

      var that = this;
      var delta = 145 - Math.random() * 100;

      if (this.isDeleting) { delta /= 2; }

      if (!this.isDeleting && this.txt === fullTxt) {
      delta = this.period;
      this.isDeleting = true;
      } else if (this.isDeleting && this.txt === '') {
      this.isDeleting = false;
      this.loopNum++;
      delta = 500;
      }

      setTimeout(function() {
      that.tick();
      }, delta);
  };

  window.onload = function() {
      var elements = document.getElementsByClassName('typewrite');
      for (var i=0; i<elements.length; i++) {
          var toRotate = elements[i].getAttribute('data-type');
          var period = elements[i].getAttribute('data-period');
          if (toRotate) {
            new TxtType(elements[i], JSON.parse(toRotate), period);
          }
      }
      // INJECT CSS
      var css = document.createElement("style");
      css.type = "text/css";
      css.innerHTML = ".typewrite > .wrap { border-right: 0.08em solid #fff}";
      document.body.appendChild(css);
  };
</script>
<?php
  function duplicateForm()
  {
  ?>
  <script type="text/javascript">
  // Dynamically add-on fields

  $(function() {
    var count = 1;
    // Remove button click
    $(document).on(
        'click',
        '[data-role="appendRow"] > .form-inline [data-role="remove"]',
        function(e)
        {
            e.preventDefault();
            if(count > 1)
            {
              $(this).closest('.form-row').remove();
              count = count -1;
            }
            else if(count == 1){
              count = 1;
            }
            console.log(count);
        }
    );
    // Add button click
    $(document).on(
        'click',
        '[data-role="appendRow"] > .form-row [data-role="add"]',
        function(e)
        {
            e.preventDefault();
            var container = $(this).closest('[data-role="appendRow"]');
            new_field_group = container.children().filter('.form-row:first-child').clone();
            new_field_group.find('label').html('Upload Document').append("name='text'+count");
            new_field_group.find('input').each(function(){
                $(this).val('');
                $(this).attr('name', "text[]");

            });
            container.append(new_field_group);
            count = count+1;
            console.log(count);
        }
    );
  });


  // file upload

  $(document).on('change', '.file-upload', function(){
  var i = $(this).prev('label').clone();
  var file = this.files[0].name;
  $(this).prev('label').text(file);
  });

  </script>
</head>
<body>


<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>


<div class="container">

<div class="form-group row custom-upload">


  <div class="col-md-12">
    <div data-role="appendRow">
          <div class="form-inline form-row">

            <input input type="text" class="form-control mb-2 mr-sm-2 col-sm-4" id="field-name" name="text[]" placeholder="Texte biographique">

      <button class="btn btn-sm btn-danger  mb-2" data-role="remove">
       <i class="fa fa-minus"></i>
      </button>
      <button class="btn btn-sm btn-primary  mb-2" data-role="add">
          <i class="fa fa-plus"></i>
      </button>


          </div>  <!-- /div.form-inline -->
      </div>  <!-- /div[data-role="dynamic-fields"] -->
  </div>
</div>
</div>
</body>
</html>

  <?php
  }
?>
<?php
  function displayBio($descUser)
  {
    if($descUser != "")
    {
      $bio = '["';
      $descUser = explode('|',$descUser);
      $bool = 0;
      foreach ($descUser as $undescUser)
      {
        if($bool == 0)
        {
          $bio = $bio.$undescUser.'"';
          $bool++;
        }
        else {
          $bio = $bio.',"'.$undescUser.'"';
        }
      }
      $bio = $bio.']';
    }
    else {
      $bio = "";
    }
    return $bio;
  }
?>
