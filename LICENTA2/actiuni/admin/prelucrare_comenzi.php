<?php 
  $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";

  $autorizare  = $root . '/admin/componenteAdmin/autorizareAdmin.php';
  $headerAdmin = $root . '/admin/componenteAdmin/headerAdmin.php';
  $footerAdmin    = $root . '/admin/componenteAdmin/footerAdmin.php';
  $prelucrareOpinii = $path . '/actiuni/admin/prelucrare_moderare_comentarii.php';
  $adminComenziPath = $path . '/admin/componenteAdmin/comenzi.php';

  include($autorizare);
  include($headerAdmin);
 
  require '../../vendor/autoload.php';    
  $client = new EasyRdf_Sparql_Client("http://localhost:7200/repositories/librarie_licenta", "http://localhost:7200/repositories/librarie_licenta/statements");
  
  print '<h1>Comenzi</h1>';  
  // comanda onorata
  if(isset($_POST['comanda_onorata'])){
    $sql = 'PREFIX c: <http://chinde.ro#>
    with c:Tranzactii
    DELETE { c:'.$_POST['id_tranzactie'].' c:onorata ?z }    
    INSERT { c:'.$_POST['id_tranzactie'].' c:onorata 1 }
    WHERE  { c:'.$_POST['id_tranzactie'].' c:onorata ?z}';
    $client->update($sql);
    header("Location:".$adminComenziPath);
  }

  // comanda anulata
  if(isset($_POST['anuleaza_comanda'])){
    $sqlTranzactii = 'PREFIX c: <http://chinde.ro#>
      delete where {
          GRAPH c:Tranzactii {
              c:'.$_POST['id_tranzactie'].' ?y ?z
          } 
      }';
    $client->update($sqlTranzactii);

    $sqlVanzari = 'PREFIX c: <http://chinde.ro#>
    delete where {
        GRAPH c:Vanzari {
            ?x c:idTranz c:'.$_POST['id_tranzactie'].'
        } 
    }';
    $client->update($sqlVanzari);
    header("Location:".$adminComenziPath);
  }

  include($footerAdmin);
?>