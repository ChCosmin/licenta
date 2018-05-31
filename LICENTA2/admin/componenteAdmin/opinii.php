<?php 
  $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";

  $autorizare  = $root . '/admin/componenteAdmin/autorizareAdmin.php';
  $headerAdmin = $root . '/admin/componenteAdmin/headerAdmin.php';
  $footerAdmin    = $root . '/admin/componenteAdmin/footerAdmin.php';
  $formulareModerareOpinii = $path . '/admin/componenteAdmin/formulare_moderare_opinii.php';

  require '../../vendor/autoload.php';
  $client = new EasyRdf_Sparql_Client("http://localhost:7200/repositories/librarie_licenta");

  include($autorizare);
  include($headerAdmin);

  print '<div class="admin-main-content admin-opinii-content">
    <h1 class="width100">Modificare sau stergere comentarii utilizatori</h1>
    <b>Comentariile utilizatorilor de la utlima moderare</b>';
 
    $sql = 'PREFIX c: <http://chinde.ro#>
    select * where {
      GRAPH c:Carti {
        ?idCarte c:titlu ?titlu.
        ?idCarte c:autor ?idAutor.
      }
      GRAPH c:Autori {
        ?idAutor c:numeAutor ?numeAutor.
      }
      GRAPH c:Comentarii {
        ?idComentariu c:carte ?idCarte.
        ?idComentariu c:id ?valId.
        ?idComentariu c:emailUtilizator ?email.
        ?idComentariu c:utilizator ?numeUtil.
        ?idComentariu c:comentariu ?coment.
      }
      GRAPH c:Admins {
        ?idAdmin c:ultimulComentariuModerat ?ultimCom.
      } filter(?valId > ?ultimCom)
    } order by ?idComentariu';

    $resursa = $client->query($sql);

    foreach($resursa as $row){
    print '
    <form class="opinii-form" action="'.$formulareModerareOpinii.'" method="POST">
      <p class="opinii-titlu"><b>'.$row->titlu.'</b> de '.$row->numeAutor.'</p>
      <a class="opinii-user" href="mailto:'.$row->email.'">'.$row->numeUtil.'</a><br />
      <div class="opinii-comentariu">'.$row->coment.'</div>
      <input type="hidden" name="id_comentariu" value="'.$row->valId.'" />
      <input class="btn btn-primary opinii-comentarii-btn" type="submit" name="modifica" value="Modifica" />
      <input class="btn btn-primary opinii-comentarii-btn" type="submit" name="sterge" value="Sterge" />
    </form>';

    $ultimul_id = $row->valId;
  }
  $nrComentarii = 0;
  foreach($resursa as $row){
    $nrComentarii += 1;
  }

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
