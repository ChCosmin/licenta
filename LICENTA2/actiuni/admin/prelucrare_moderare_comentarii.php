<?php 
  $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";

  $autorizare  = $root . '/admin/componenteAdmin/autorizareAdmin.php';
  $headerAdmin = $root . '/admin/componenteAdmin/headerAdmin.php';
  $footerAdmin    = $root . '/admin/componenteAdmin/footerAdmin.php';
  $adminOpiniiPath = $path . '/admin/componenteAdmin/opinii.php';

  include($autorizare);
  include($headerAdmin);

  require '../../vendor/autoload.php';    
  $client = new EasyRdf_Sparql_Client("http://localhost:7200/repositories/librarie_licenta", "http://localhost:7200/repositories/librarie_licenta/statements");
  
  // modificare comentariu
  if(isset($_POST['modifica'])){
    if($_POST['nume_utilizator'] == ''){
      print '<div class="admin-main-content"><p>Nu ai completat numele de utilizator</p></div>';
    } else if($_POST['adresa_email'] == '') {
      print '<div class="admin-main-content"><p>Nu ai completat adresa de email</p></div>';
    } else if($_POST['comentariu'] == ''){
      print '<div class="admin-main-content"><p>Campul Comentariu este gol</p></div>';
    } else {
      $sql = 'PREFIX c: <http://chinde.ro#>
      with c:Comentarii
      DELETE { 
        c:Com'.$_POST['id_comentariu'].' c:utilizator ?utilizator.
        c:Com'.$_POST['id_comentariu'].' c:emailUtilizator ?email.
        c:Com'.$_POST['id_comentariu'].' c:comentariu ?coment.
      }    
      INSERT { 
        c:Com'.$_POST['id_comentariu'].' c:utilizator "'.$_POST['nume_utilizator'].'".
        c:Com'.$_POST['id_comentariu'].' c:emailUtilizator <mailto:'.$_POST['adresa_email'].'>.
        c:Com'.$_POST['id_comentariu'].' c:comentariu "'.$_POST['comentariu'].'".
      }
      WHERE  { 
        c:Com'.$_POST['id_comentariu'].' c:utilizator ?utilizator.
        c:Com'.$_POST['id_comentariu'].' c:emailUtilizator ?email.
        c:Com'.$_POST['id_comentariu'].' c:comentariu ?coment. 
      }';
      $client->update($sql);
      header("Location:".$adminOpiniiPath);
    }
  }
  
  // sterge comentariu
  if(isset($_POST['sterge'])){
    $sql = 'PREFIX c: <http://chinde.ro#>
    delete where {
      GRAPH c:Comentarii {
        c:Com'.$_POST['id_comentariu'].' ?y ?z
      }
    }';    
    $client->update($sql);
    header("Location:".$adminOpiniiPath);
  }
  
  if(isset($_POST['seteaza_moderare'])){
    $sql = 'PREFIX c: <http://chinde.ro#>
    with c:Admins
    DELETE { 
      c:Admin1 c:ultimulComentariuModerat ?com.
    }    
    INSERT { 
      c:Admin1 c:ultimulComentariuModerat '.$_POST['ultimul_id'].'.
     }
    WHERE  { 
      c:Admin1 c:ultimulComentariuModerat ?com.
    }';
    $client->update($sql);
    header("Location:".$adminOpiniiPath);
  }
?>