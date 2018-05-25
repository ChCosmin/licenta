<?php 
  session_start();
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";
  $connect = $root . '/componente/conectare.php';

  include('../../componente/conectare.php');
  require 'vendor/autoload.php';
  $client = new EasyRdf_Sparql_Client("http://localhost:7200/repositories/librarie_licenta");

  function autorizat() {
    // $sql = "SELECT * FROM admin WHERE admin_nume='".$_SESSION['nume_admin']."' AND admin_parola='".$_SESSION['parola_encriptata']."'";
    $sql = 'PREFIX c: <http://chinde.ro#>
      select * where {
        GRAPH c:Admins {
          ?idAdmin c:adminNume ?numeAdmin.
          ?idAdmin c:adminParola ?parolaAdmin.
          ?idAdmin c:ultimulComentariuModerat ?ultimulComentModerat.
        } filter (?numeAdmin="'.$_SESSION['nume_admin'].'" && ?parolaAdmin="'.$_SESSION['parola_encriptata'].'")
      }';
    
    // $resursa = mysqli_query($con, $sql);
    $resursa=$client->query($sql);
    $rows = 0;
    foreach($resursa as $row){
      $rows += 1;
    }    
    
    if($_SESSION['key_admin'] != session_id() || $rows != 1) {
      return false;
    } else {
      return true;
    }
  }
?>