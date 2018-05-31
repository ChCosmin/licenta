<?php
  // $path = "/licenta2";
  // $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";
  // $connect = $root . '/componente/conectare.php';

  require '../../vendor/autoload.php';
  $client = new EasyRdf_Sparql_Client("http://localhost:7200/repositories/librarie_licenta");

  session_start();
  if($_SESSION['key_admin'] != session_id()){
    print 'Acces neautorizat';
    exit;
  }

  // include($connect);
  $sql = 'PREFIX c: <http://chinde.ro#>
  select * where {
      GRAPH c:Admins {
        ?idAdmin c:adminNume ?adminNume.
        ?idAdmin c:adminParola ?adminParola. 
      }
  }';
  $resursa=$client->query($sql);
  $rows = 0;

  foreach($resursa as $row){
    $rows += 1;
  }  

  if($rows != 1) {
    print 'Acces neautorizat';
    exit;
  }
?>