<?php 
  $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";

  $autorizare  = $root . '/admin/componenteAdmin/autorizareAdmin.php';
  $headerAdmin = $root . '/admin/componenteAdmin/headerAdmin.php';
  $footerAdmin    = $root . '/admin/componenteAdmin/footerAdmin.php';
  $formulareModerareOpinii = $path . '/admin/componenteAdmin/formulare_moderare_opinii.php';

  include($autorizare);
  include($headerAdmin);

  print '<div class="admin-main-content admin-opinii-content">
    <h1 class="width100">Modificare sau stergere comentarii utilizatori</h1>
    <b>Comentariile utilizatorilor de la utlima moderare</b>';
 
    $sql = "SELECT * FROM comentarii, admin, carti, autori WHERE id_comentariu>admin.ultimul_comentariu_moderat AND carti.id_carte=comentarii.id_carte AND carti.id_autor=autori.id_autor ORDER BY id_comentariu ASC";
    $resursa = mysqli_query($con, $sql);
    while($row = mysqli_fetch_array($resursa)){

    print '
    <form class="opinii-form" action="'.$formulareModerareOpinii.'" method="POST">
      <p class="opinii-titlu"><b>'.$row['titlu'].'</b> de '.$row['nume_autor'].'</p>
      <a class="opinii-user" href="mailto:'.$row['adresa_email'].'">'.$row['nume_utilizator'].'</a><br />
      <div class="opinii-comentariu">'.$row['comentariu'].'</div>
      <input type="hidden" name="id_comentariu" value="'.$row['id_comentariu'].'" />
      <input class="btn btn-primary opinii-comentarii-btn" type="submit" name="modifica" value="Modifica" />
      <input class="btn btn-primary opinii-comentarii-btn" type="submit" name="sterge" value="Sterge" />
    </form>';

    $ultimul_id = $row['id_comentariu'];
  }
  $nrComentarii = mysqli_num_rows($resursa);
  if($nrComentarii > 0) {
  
  ?>
  <form action="<?=$formulareModerareOpinii?>" method="POST">
    <input type="hidden" name="ultimul_id" value="<?=$ultimul_id?>" />
    <input type="submit" class="btn btn-primary opinii-comentarii-btn" name="seteaza_moderare" value="Seteaza aceste comentarii ca fiind moderate" />
  </form>
  <?php
    }
    else {
      print "<p class='italic'>Nu exista comentarii noi.</p>";
    }
    print '</div>';
    include($footerAdmin);
  ?>
