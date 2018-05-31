<?php 
  $path = "/licenta2";
  // $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";
  
  // $connect = $root . '/componente/conectare.php';
  $inapoi = $path . '/admin/indexAdmin.php';
  $admin = $path . '/admin/componenteAdmin/admin.php';
  session_start();
  
  require '../../vendor/autoload.php';
  $client = new EasyRdf_Sparql_Client("http://localhost:7200/repositories/librarie_licenta");


  if($_POST['nume'] == '' || $_POST['parola'] == '') {
    $mesajError = "Trebuie completate toate campurile";
    echo "<script type='text/javascript'>";
    echo "alert('".$mesajError."');";
    echo "window.location= '".$inapoi."';";
    echo "</script>";
    exit;
  }

  // include($connect);
  $parolaEcriptata = md5($_POST['parola']);
  $sql = 'PREFIX c: <http://chinde.ro#>
    select * where {
      GRAPH c:Admins {
        ?idAdmin c:adminNume ?numeAdmin.
        ?idAdmin c:adminParola ?parolaAdmin.
        ?idAdmin c:ultimulComentariuModerat ?ultimulComentModerat.
      } filter (?numeAdmin="'.$_POST['nume'].'" && ?parolaAdmin="'.$parolaEcriptata.'")
    }';

  $resursa=$client->query($sql);
  $rows = 0;
  foreach($resursa as $row){
    $rows += 1;
  }

  if($rows != 1) {
    $mesajError = "Nume sau parola gresite!";
    echo "<script type='text/javascript'>";
    echo "alert('".$mesajError."');";
    echo "window.location= '".$inapoi."';";
    echo "</script>";
    exit;
  }

  $_SESSION['nume_admin'] = $_POST['nume'];
  $_SESSION['parola_encriptata'] = $parolaEcriptata;
  $_SESSION['key_admin'] = session_id();
  header("Location:" . $admin);
?>