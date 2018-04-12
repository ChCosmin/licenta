<?php 
    $path = "/licenta2";
    $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";
  
    $autorizare  = $root . '/admin/componenteAdmin/autorizareAdmin.php';
    $headerAdmin = $root . '/admin/componenteAdmin/headerAdmin.php';
    $footerAdmin    = $root . '/admin/componenteAdmin/footerAdmin.php';
    $prelucrareOpinii = $path . '/actiuni/admin/prelucrare_moderare_comentarii.php';

    include($autorizare);
    include($headerAdmin);

    print '<div class="admin-main-content admin-prelucrare-opinii-content">';

    // formular modificare comentariu
    if(isset($_POST['modifica'])){
      $sql = "SELECT * FROM comentarii WHERE id_comentariu=".$_POST['id_comentariu'];
      $resursa = mysqli_query($con, $sql);
      $row = mysqli_fetch_array($resursa);
      print '
        <h1>Modifica acest comentariu</h1>
        <form action="'.$prelucrareOpinii.'" method="POST">

          <div class="opinii-moderare-form-item">
            <label class="width20" for="nume_utilizator">Nume:</label>
            <input class="width70" id="nume_utilizator" type="text" name="nume_utilizator" value="'.$row['nume_utilizator'].'" />
          </div>

          <div class="opinii-moderare-form-item">
            <label class="width20" for="adresa_email">Email:</label>
            <input class="width70" id="adresa_email" type="text" name="adresa_email" value="'.$row['adresa_email'].'" />
          </div>

          <div class="opinii-moderare-form-item">
            <label class="width20" for="comentariu">Comentariu:</label>
            <textarea style="resize: none" class="width70" id="comentariu" type="text" name="comentariu" cols="45" rows="8">'.$row['comentariu'].'</textarea>
          </div>
         
          <input type="hidden" name="id_comentariu" value="'.$_POST['id_comentariu'].'" />
          <input class="width100 btn btn-primary opinii-moderare-btn" type="submit" name="modifica" value="Modifica" />
        </form>
      ';
    }

    // formular sterge comentariu
    if(isset($_POST['sterge'])){
      print '
        <h1>Esti sigur ca vrei sa stergi acest comentariu?</h1>
        <form action="'.$prelucrareOpinii.'" method="POST">
          <input type="hidden" name="id_comentariu" value="'.$_POST['id_comentariu'].'" />
          <input type="submit" class="btn btn-primary opinii-moderare-btn" name="sterge" value="Sterge" />
        </form>
      ';
    }

    // formular seteaza moderare
    if(isset($_POST['seteaza_moderare'])){
      print '
      <h1>Seteaza comentariile ca fiind moderate</h1>
      <p>Esti sigur ca vrei sa setezi comentariile din pagina precedenta ca fiind moderate? Le-ai verificat pe toate?</p>
      <form action="'.$prelucrareOpinii.'" method="POST">
        <input type="hidden" name="ultimul_id" value="'.$_POST['ultimul_id'].'" />
        <input type="submit" class="btn btn-primary opinii-moderare-btn" name="seteaza_moderare" value="Da" />
      </form>
      ';
    } 

    print '</div>';


 include($footerAdmin); ?>