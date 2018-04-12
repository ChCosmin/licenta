<?php
  $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";

  $autorizare  = $root . '/admin/componenteAdmin/autorizareAdmin.php';
  $headerAdmin = $root . '/admin/componenteAdmin/headerAdmin.php';
  $footerAdmin    = $root . '/admin/componenteAdmin/footerAdmin.php';
  $prelucrareModifcStergere = $path . '/actiuni/admin/prelucrare_modificare_stergere.php';
  
  include($autorizare);
  include($headerAdmin);

  print '<div class="admin-main-content admin-modif-sterge-content">';

  //modificare nume domeniu
  if(isset($_POST['modifica_domeniu'])){
    $sql = "SELECT nume_domeniu FROM domenii WHERE id_domeniu='".$_POST['id_domeniu']."'";
    $resursa = mysqli_query($con, $sql);
    $nume_domeniu = mysqli_fetch_array($resursa);
    print "
    <h1>Modifica nume domeniu</h1>
    <form action='".$prelucrareModifcStergere."' method='POST'>
      <input type='text' name='nume_domeniu' value='".$nume_domeniu['nume_domeniu']."' />
      <input type='hidden' name='id_domeniu' value='".$_POST['id_domeniu']."' />
      <input type='submit' name='modifica_domeniu' value='Modifica' />
    </form>";
  }

  //stergere domeniu
  if(isset($_POST['sterge_domeniu'])){
    $sql = "SELECT titlu, nume_autor FROM carti, autori, domenii WHERE carti.id_domeniu=domenii.id_domeniu AND carti.id_autor=autori.id_autor AND domenii.id_domeniu=".$_POST['id_domeniu'];
    $sqlNumeDomeniu = "SELECT nume_domeniu FROM domenii where id_domeniu=".$_POST['id_domeniu'];
    
    $resursa = mysqli_query($con, $sql);
    $resursaNumeDomeniu = mysqli_query($con, $sqlNumeDomeniu);
    
    $numeDomeniu = mysqli_fetch_array($resursaNumeDomeniu);
    $nrCarti = mysqli_num_rows($resursa);
    if($nrCarti > 0) {
      
      print "<h2 class='formModifSterg-item-title'>Avertizare:</h2>
      <p class='italic'>Nu puteti sterge acest domeniu deoarece contine carti. Mutati cartile in alt domeniu sau stergeti-le inainte sa eliminati acest domeniu!</p>
      <p>Sunt $nrCarti carti care apartin domeniului <b>".$numeDomeniu['nume_domeniu']."</b>!</p>";      
      while($row = mysqli_fetch_array($resursa)){
        print "<b>".$row['titlu']."</b> de ".$row['nume_autor']."<br />";
      }
    } else {
        print '
        <div class="formModifSterg-item">
          <h1>Esti sigur ca vrei sa stergi domeniul "<b>'.$numeDomeniu['nume_domeniu'].'</b>"?</h1>
          <form action="'.$prelucrareModifcStergere.'" method="POST">
            <input type="hidden" name="id_domeniu" value="'.$_POST['id_domeniu'].'" />
            <input class="btn btn-primary formModifSterg-item-btn" type="submit" name="sterge_domeniu" value="Sterge!" />
          </form>
        </div>';
      }
  }
  
  // modificare autor
  if(isset($_POST['modifica_autor'])){
    $sql = "SELECT nume_autor FROM autori WHERE id_autor='".$_POST['id_autor']."'";
    $resursa = mysqli_query($con, $sql);
    $nume_autor = mysqli_fetch_array($resursa);
    print '
    <h1>Modifica nume autor</h1>
    <form action="'.$prelucrareModifcStergere.'" method="POST">
      <input type="text" name="nume_autor" value="'.$nume_autor['nume_autor'].'" />
      <input type="hidden" name="id_autor" value="'.$_POST['id_autor'].'" />
      <input type="submit" name="modifica_autor" value="Modifica" />
    </form>';

  }

  //stergere autor
  if(isset($_POST['sterge_autor'])){
    $sql = "SELECT titlu FROM carti, autori WHERE carti.id_autor=autori.id_autor AND carti.id_autor=".$_POST['id_autor'];
    $sqlNumeAutor = "SELECT nume_autor FROM autori WHERE id_autor=".$_POST['id_autor'];

    $resursa = mysqli_query($con, $sql);
    $resursaNumeAutor = mysqli_query($con, $sqlNumeAutor);

    $nrCarti = mysqli_num_rows($resursa);
    $numeAutor = mysqli_fetch_array($resursaNumeAutor);
    if($nrCarti > 0) {
      print "<p>Sunt $nrCarti carti de acest autor in baza de date!</p>";
      while($row = mysqli_fetch_array($resursa)){
        print $row['titlu']."<br />";
      }
      print "<p>Nu puteti sterge acest autor!</p>";
    } else {        
      print '
      <div class="formModifSterg-item">
        <h1>Esti sigur ca vrei sa stergi autorul "<b>'.$numeAutor['nume_autor'].'</b>"?</h1>
        <form action="'.$prelucrareModifcStergere.'" method="POST">
          <input type="hidden" name="id_autor" value="'.$_POST['id_autor'].'" />
          <input type="submit" class="btn btn-primary formModifSterg-item-btn" name="sterge_autor" value="Sterge!" />
        </form>
      </div>';
    }
  }

  //modificare carte
  if(isset($_POST['modifica_carte'])){
    $sqlCarte = "SELECT * FROM carti WHERE titlu='".$_POST['titlu']."' AND id_autor=".$_POST['id_autor'];
    $resursaCarte = mysqli_query($con, $sqlCarte);
    if(mysqli_num_rows($resursaCarte) == 0){
      print "Aceasta carte nu exista in baza de date";
    } else {
      $rowCarte = mysqli_fetch_array($resursaCarte);
    ?>
    <div class="formModifSterg-item">
      <h1>Modificare carte "<b><?=$rowCarte['titlu']?></b>"</h1>
      <form class="width40 formModifSterg-form" action="<?=$prelucrareModifcStergere?>" method="POST">
        
        <div class="formModifSterg-form-item">
          <label class="width30" for="id_domeniu">Domeniu:</label>            
          <select class="width100" id="id_domeniu" name="id_domeniu">
            <?php
              $sql = "SELECT * FROM domenii ORDER BY nume_domeniu ASC";
              $resursa = mysqli_query($con, $sql);
              while($row = mysqli_fetch_array($resursa)){
                if($row['id_domeniu'] == $rowCarte['id_domeniu']){
                  print "<option SELECTED value='".$row['id_domeniu']."'>".$row['nume_domeniu']."</option>";
                } else {
                  print "<option value='".$row['id_domeniu']."'>".$row['nume_domeniu']."</option>";
                }
              }
            ?>
          </select>
        </div>

        <div class="formModifSterg-form-item">
          <label class="width30" for="id_autor">Autor:</label>      
          <select class="width100" id="id_autor" name="id_autor">
            <?php 
              $sql = "SELECT * FROM autori ORDER BY nume_autor ASC";
              $resursa = mysqli_query($con, $sql);
              while($row = mysqli_fetch_array($resursa)) {
                if($row['id_autor'] == $rowCarte['id_autor']) {
                  print "<option SELECTED value='".$row['id_autor']."'>".$row['nume_autor']."</option>";
                } else {
                  print "<option value='".$row['id_autor']."'>".$row['nume_autor']."</option>";
                }
              } 
            ?>
          </select>          
        </div>

        <div class="formModifSterg-form-item">
          <label class="width30" for="titlu">Titlu:</label>
          <input class="width100" id="titlu" type="text" name="titlu" value="<?=$rowCarte['titlu']?>" />
        </div>

        <div class="formModifSterg-form-item">
          <label class="width30" for="descriere">Descriere:</label>
          <textarea class="width100" style="resize: none" id="descriere" name="descriere" rows="8"><?=$rowCarte['descriere']?></textarea>
        </div>

        <div class="formModifSterg-form-item">
          <label class="width30" for="pret">Pret:</label>
          <input class="width100" id="pret" type="text" name="pret" value="<?=$rowCarte['pret']?>" />
        </div>
        <input type="text" name="id_carte" value="<?=$rowCarte['id_carte']?>" />
        <input type="submit" class="btn btn-primary formModifSterg-item-btn" name="modifica_carte" value="Modifica" />
      </form>
    </div>
    <?php 
    }
  }

  //sterge carte
  if(isset($_POST['sterge_carte'])) {
    $sqlCarte = "SELECT * FROM carti WHERE titlu='".$_POST['titlu']."' AND id_autor=".$_POST['id_autor'];
    $resursaCarte = mysqli_query($con, $sqlCarte);
    $carte = mysqli_fetch_array($resursaCarte);
    if(mysqli_num_rows($resursaCarte) == 0) {
      print '
      <div class="formModifSterg-item">
        <h1>Sterge carte</h1>
        <i>Aceasta carte nu exista in baza de date</i>
      </div>';
    } else {
      print '
      <div class="formModifSterg-item">
        <h1>Esti sigur ca vrei sa stergi cartea "<b>'.$carte['titlu'].'</b>"?</h1>
        <form action="'.$prelucrareModifcStergere.'" method="POST">
          <input type="hidden" name="id_carte" value="'.$carte['id_carte'].'" />
          <input type="submit" class="btn btn-primary formModifSterg-item-btn" name="sterge_carte" value="Sterge!" />
        </form>
      </div>';
    }
  }
  print "</div>"; 
  include($footerAdmin);
?>


  