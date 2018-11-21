<?php
  include('tools/head.inc.php');
 ?>
 <div id="content-wrapper">

   <div class="container-fluid">

         <div class="container-fluid profile">
           <div class="col-xl-14" style="box-shadow:2px 5px 18px #888888;border-radius:3px;border:1px solid rgba(0,0,0,0.15)">
             <h4 class='h4'>Ajouter un stage</h4>
             <form method='post' action='trait.php'>
               <div class='col-md-6' style='margin:5px;padding:5px;'>
                 <div class='form-label-group'>
                   <input type="text" id="lib" name='lib' class="form-control" placeholder="libellé" required="required">
                   <label for='lib'>Libellé du Stage</label>
                 </div>
                 <label for='desc'>Decription du Stage</label>
                 <textarea id="desc" name='desc' class="form-control" required="required"></textarea>
                 <div class='row'>
                   <div class='col-md-6'>
                     <label>Date de début</label>
                     <input type='date' class='form-control' name='datedeb' placeholder='date de début'>
                   </div>
                   <div class='col-md-6'>
                     <label>Date de fin</label>
                     <input type='date' class='form-control' name='datefin' placeholder='date de fin'>
                   </div>
                 </div>
                 <div class='form-group'>
                   <label>Entreprise</label>
                   <select name='entreprise' class='form-control'>
                     <?php
                        $sql = 'SELECT nameEntreprise,idEntreprise
                                FROM entreprise';
                        $req = $conn -> query($sql);
                        while ($res = $req -> fetch())
                        {
                          ?>
                          <option value='<?php echo $res['idEntreprise']; ?>'><?php echo $res['nameEntreprise']; ?></option>
                          <?php
                        }
                      ?>
                   </select>
                 </div>
                 <input type='submit' class='btn btn-primary' name='createstage' value='Créer'>
               </div>
             </form>
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
include('tools/foot.inc.php');
?>
