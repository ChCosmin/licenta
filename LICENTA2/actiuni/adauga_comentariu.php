<?php
  // include("../componente/conectare.php");
  $path = "/licenta2";
  
  require '../vendor/autoload.php';
  $client = new EasyRdf_Sparql_Client("http://localhost:7200/repositories/librarie_licenta", "http://localhost:7200/repositories/librarie_licenta/statements");
  
  $numeFaraTags = strip_tags($_POST['nume_utilizator']);
  $emailFaraTags = strip_tags($_POST['adresa_email']);
  $comentariuFaraTags = strip_tags($_POST['comentariu']);

  if($numeFaraTags && $emailFaraTags && $comentariuFaraTags){
    $lastComIdSql = 'PREFIX c: <http://chinde.ro#>
    select (max(?valId)+1 as ?lastId) where {
      GRAPH c:Comentarii { ?idCom c:id ?valId }
    }';
    $lastComId = $client->query($lastComIdSql);
    $id = $lastComId[0]->lastId;
    
    $insert = 'PREFIX c: <http://chinde.ro#>
    insert data {
      GRAPH c:Comentarii {
        c:Com'.$id.' 
          c:id '.$id.';
          c:carte c:'.$_POST['id_carte'].';
          c:utilizator "'.$numeFaraTags.'";
          c:emailUtilizator <mailto:'.$emailFaraTags.'>;
          c:comentariu "'.$comentariuFaraTags.'";
          a c:Comentariu.
      }
    }';
    $client->update($insert);
    $inapoi = $path . "/componente/carte.php?id_carte=".$_POST['id_carte'];
    header("Location: $inapoi");
  } else {
    $inapoi = $path . "/componente/carte.php?id_carte=".$_POST['id_carte'];
    header("Location: $inapoi");
  }  
?>