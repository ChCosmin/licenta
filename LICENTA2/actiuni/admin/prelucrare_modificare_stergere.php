<?php 
    $path = "/licenta2";
    $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";
  
    $autorizare  = $root . '/admin/componenteAdmin/autorizareAdmin.php';
    $headerAdmin = $root . '/admin/componenteAdmin/headerAdmin.php';
    $footerAdmin    = $root . '/admin/componenteAdmin/footerAdmin.php';
    $adminModifStergPath = $path . '/admin/componenteAdmin/modificare_stergere.php';

    include($autorizare);
    include($headerAdmin);

    require '../../vendor/autoload.php';    
    $client = new EasyRdf_Sparql_Client("http://localhost:7200/repositories/librarie_licenta", "http://localhost:7200/repositories/librarie_licenta/statements");
    
    // modificare nume domeniu
    if(isset($_POST['modifica_domeniu'])) {
      if($_POST['nume_domeniu'] == '') {
        print "<div class='admin-main-content'>Nu ati introdus numele domeniului!</div>";
      } else {
        $sql = 'PREFIX c: <http://chinde.ro#>
        with c:Domenii
        DELETE { 
          c:'.$_POST['id_domeniu'].' c:numeDomeniu ?numeDomeniu
        }    
        INSERT { 
          c:'.$_POST['id_domeniu'].' c:numeDomeniu "'.$_POST['nume_domeniu'].'"         
        }
        WHERE  { 
          c:'.$_POST['id_domeniu'].' c:numeDomeniu ?numeDomeniu
        }';
        $client->update($sql);
        header("Location:".$adminModifStergPath);
      }
    }

    // sterge domeniu
    if(isset($_POST['sterge_domeniu'])) {
      $sql = 'PREFIX c: <http://chinde.ro#>
      delete where {
        GRAPH c:Domenii {
          c:'.$_POST['id_domeniu'].' ?y ?z
        }
      }';
      $client->update($sql);
      header("Location:".$adminModifStergPath);
    }

    // modificare nume autor
    if(isset($_POST['modifica_autor'])) {
      if($_POST['nume_autor'] == '') {
        print "<div class='admin-main-content'>Nu ati introdus numele autorului!</div>";
      } else {
        $sql = 'PREFIX c: <http://chinde.ro#>
        with c:Autori
        DELETE { 
          c:'.$_POST['id_autor'].' c:numeAutor ?numeAutor
        }    
        INSERT { 
          c:'.$_POST['id_autor'].' c:numeAutor "'.$_POST['nume_autor'].'"         
        }
        WHERE  { 
          c:'.$_POST['id_autor'].' c:numeAutor ?numeAutor
        }';
        $client->update($sql);
        header("Location:".$adminModifStergPath);
      }
    }

    // sterge autor
    if(isset($_POST['sterge_autor'])) {
      $sql = 'PREFIX c: <http://chinde.ro#>
      delete where {
        GRAPH c:Autori {
          c:'.$_POST['id_autor'].' ?y ?z
        }
      }';
      $client->update($sql);
      header("Location:".$adminModifStergPath);
    }

    // modificare carte
    if(isset($_POST['modifica_carte'])){
      if($_POST['titlu'] == ''){
        print "<div class='admin-main-content'>Nu ati introdus titlul!</div>";
      } else if($_POST['pret'] == ''){
        print "<div class='admin-main-content'>Nu ati introdus pretul!</div>";
      } else if(!is_numeric($_POST['pret'])){
        print "<div class='admin-main-content'>Pretul trebuie sa fie numeric! Scrieti <b>1000</b> nu <b>1000 lei</b>.</div>";
      } else {
        $sql = 'PREFIX c: <http://chinde.ro#>
        with c:Carti
        DELETE { 
          c:'.$_POST['id_carte'].' c:domeniu ?idDomeniu.
          c:'.$_POST['id_carte'].' c:autor ?idAutor.
          c:'.$_POST['id_carte'].' c:titlu ?titlu.
          c:'.$_POST['id_carte'].' c:descriere ?descriere.
          c:'.$_POST['id_carte'].' c:pret ?pret.                                        
        }    
        INSERT { 
          c:'.$_POST['id_carte'].' c:domeniu c:'.$_POST['id_domeniu'].'.
          c:'.$_POST['id_carte'].' c:autor c:'.$_POST['id_autor'].'.
          c:'.$_POST['id_carte'].' c:titlu "'.$_POST['titlu'].'".
          c:'.$_POST['id_carte'].' c:descriere "'.$_POST['descriere'].'".
          c:'.$_POST['id_carte'].' c:pret '.$_POST['pret'].'.         
        }
        WHERE  { 
          c:'.$_POST['id_carte'].' c:domeniu ?idDomeniu.
          c:'.$_POST['id_carte'].' c:autor ?idAutor.
          c:'.$_POST['id_carte'].' c:titlu ?titlu.
          c:'.$_POST['id_carte'].' c:descriere ?descriere.
          c:'.$_POST['id_carte'].' c:pret ?pret.
        }';
        $client->update($sql);
        header("Location:".$adminModifStergPath);
      }
    }

    // sterge carte
    if(isset($_POST['sterge_carte'])) {
      $sql = 'PREFIX c: <http://chinde.ro#>
      delete where {
        GRAPH c:Carti {
          c:'.$_POST['id_carte'].' ?y ?z
        }
      }';
      $client->update($sql);
      header("Location:".$adminModifStergPath);
    }
?>

<?php include($footerAdmin); ?>