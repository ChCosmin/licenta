<?php 
  $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";

  $autorizare  = $root . '/admin/componenteAdmin/autorizareAdmin.php';
  $headerAdmin = $root . '/admin/componenteAdmin/headerAdmin.php';
  $footerAdmin    = $root . '/admin/componenteAdmin/footerAdmin.php';
  $prelucrare = $path . '/actiuni/admin/prelucrare_adaugare.php';
  include($autorizare);
  include($headerAdmin);
?>
<div class="admin-main-content admin-adaugare-content">
  <h1>Adaugare</h1>
  <div class="adaugare-item">
    <h5 class="adaugare-item-titlu bold italic">Adauga domeniu</h5>
    <form class="adaugare-item-form" action="<?=$prelucrare?>" method="POST">
      <input class="width100" type="text" name="domeniu_nou" placeholder="Domeniu nou"/>
      <input class="btn btn-primary adauga-form-btn width100" type="submit" name="adauga_domeniu" value="Adauga" />
    </form>
  </div>
  
  <div class="adaugare-item">
    <h5 class="adaugare-item-titlu bold italic">Adauga autor</h5>
    <form class="adaugare-item-form" action="<?=$prelucrare?>" method="POST">
      <input class="width100" type="text" name="autor_nou" placeholder="Autor nou"/>
      <input class="width100" type="text" name="autor_descriere_nou" placeholder="Descriere autor nou"/>
      <input class="width100" type="text" name="sursa_descriere" placeholder="Sursa descriere"/>
      <input class="btn btn-primary adauga-form-btn width100" type="submit" name="adauga_autor" value="Adauga" />
    </form>
  </div>
 
  <div class="adaugare-item">
    <h5 class="adaugare-item-titlu bold italic">Adauga carte</h5>
    <form class="adaugare-item-form" action="<?=$prelucrare?>" method="POST">
  
        <div class="adaugare-form-field">
          <h6 class="width20">Domeniu:</h6>
          <select class="width100" name="id_domeniu">
            <?php 
              $sql = "SELECT * FROM domenii ORDER BY nume_domeniu ASC";
              $resursa = mysqli_query($con, $sql);
              while($row = mysqli_fetch_array($resursa)){
                print '<option value="'.$row['id_domeniu'].'">'.$row['nume_domeniu'].'</option>';
              }
            ?>
          </select>          
        </div>

        <div class="adaugare-form-field">
          <h6 class="width20">Autor:</h6>
          <select class="width100" name="id_autor">
            <?php 
              $sql = "SELECT * FROM autori ORDER BY nume_autor ASC";
              $resursa = mysqli_query($con, $sql);
              while($row = mysqli_fetch_array($resursa)){
                print '<option value="'.$row['id_autor'].'">'.$row['nume_autor'].'</option>';
              }
            ?>
          </select>
        </div>

        <div class="adaugare-form-field">
          <h6 class="width20">Titlu:</h6>
          <input class="width100" type="text" name="titlu" />
        </div>

        <div class="adaugare-form-field">
          <h6 class="width20">Descriere:</h6>
          <textarea class="width100 adaugare-form-textarea" name="descriere" rows="8"></textarea>
        </div>
        
        <div class="adaugare-form-field">
          <h6 class="width20">Pret:</h6>
          <input class="width100" type="text" name="pret" />
        </div>

        <div class="adaugare-form-field">
          <input class="btn btn-primary adauga-form-btn width100" type="submit" name="adauga_carte" value="Adauga" />
        </div>
    </form>
  </div>
 
</div>
<?php include($footerAdmin); ?>