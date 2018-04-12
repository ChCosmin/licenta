<?php 
    $path = "/licenta2";
    $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";
  
    $autorizare  = $root . '/admin/componenteAdmin/autorizareAdmin.php';
    $headerAdmin = $root . '/admin/componenteAdmin/headerAdmin.php';
    $footerAdmin    = $root . '/admin/componenteAdmin/footerAdmin.php';
    $formulareModificareStergere = $path . '/admin/componenteAdmin/formulare_modificare_stergere.php';

    include($autorizare);
    include($headerAdmin);
?>
<div class="admin-main-content admin-modif-sterge-content">
  <h1>Modificare sau stergere</h1>
  <p class="modif-sterge-nota italic"><b>Nota:</b> Nu veti putea sterge domenii care au carti in ele. Inainte de a sterge domeniul, modificati cartile din el astefel incat sa apartina altor domenii. De asemenea nu veti putea sterge un autor daca exista carti in baza de date care au acel autor.</p>
  
  <div class="modif-sterg-items">
    <div class="modif-sterg-item">
      <h5 class="modif-sterg-titlu bold italic">Selecteaza domeniul ce doresti sa il modifici sau stergi:</h5>
      <form class="modif-sterg-form" action="<?=$formulareModificareStergere?>" method="POST">
        <h6 class="width10">Domeniu:</h6> 
        <select class="width90" name="id_domeniu">
          <?php 
            $sql = "SELECT * FROM domenii ORDER BY nume_domeniu ASC";
            $resursa = mysqli_query($con, $sql);
            while($row = mysqli_fetch_array($resursa)){
              print "<option value='".$row['id_domeniu']."'>".$row['nume_domeniu']."</option>";
            }
          ?>
        </select>
        <input class="bold btn btn-primary modif-sterg-btn width45" type="submit" name="modifica_domeniu" value="Modifica" />
        <input class="bold btn btn-primary modif-sterg-btn width45" type="submit" name="sterge_domeniu" value="Sterge" />
      </form>
    </div>  

    <div class="modif-sterg-item">
      <h5 class="modif-sterg-titlu bold italic">Selecteaza autorul ce doresti sa il modifici sau stergi:</h5>
      <form class="modif-sterg-form" action="<?=$formulareModificareStergere?>" method="POST">
        <h6 class="width10">Autor:</h6>
        <select class="width90" name="id_autor">
          <?php 
            $sql = "SELECT * FROM autori ORDER BY nume_autor ASC";
            $resursa = mysqli_query($con, $sql);
            while($row = mysqli_fetch_array($resursa)){
              print "<option value='".$row['id_autor']."'>".$row['nume_autor']."</option>";
            }
          ?>
        </select>
        <input class="bold btn btn-primary modif-sterg-btn width45" type="submit" name="modifica_autor" value="Modifica" />
        <input class="bold btn btn-primary modif-sterg-btn width45" type="submit" name="sterge_autor" value="Sterge" />
      </form>
    </div>

    <div class="modif-sterg-item">
      <h5 class="modif-sterg-titlu bold italic">Selecteaza autorul si scrie titlul cartii ce doresti sa o modifici sau stergi:</h5>
      <form class="modif-sterg-form" action="<?=$formulareModificareStergere?>" method="POST">
          <div class="modif-sterg-form-field">
            <h6 class="width10">Autor:</h6>
            <select class="width90" name="id_autor">
              <?php
                $sql = "SELECT * FROM autori ORDER BY nume_autor ASC";
                $resursa = mysqli_query($con, $sql);
                while($row = mysqli_fetch_array($resursa)){
                  print "<option value='".$row['id_autor']."'>".$row['nume_autor']."</option>";
                }
              ?>
            </select>
          </div>
          <div class="modif-sterg-form-field">
            <h6 class="width10">Titlu:</h6>
            <input class="width90" type='text' name="titlu" />
          </div>
        <input class="bold btn btn-primary modif-sterg-btn width45" type="submit" name="modifica_carte" value="Modifica" />
        <input class="bold btn btn-primary modif-sterg-btn width45" type="submit" name="sterge_carte" value="Sterge" />
      </form>
    </div>
  </div>
 
</div>
<?php include($footerAdmin); ?>