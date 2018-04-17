<?php 
  $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";
  
  $connect = $root . '/componente/conectare.php';
  $inapoi = $path . '/admin/indexAdmin.php';
  $admin = $path . '/admin/componenteAdmin/admin.php';

  if($_POST['nume'] == '' || $_POST['parola'] == '') {
    $mesajError = "Trebuie completate toate campurile";
    echo "<script type='text/javascript'>";
    echo "alert('".$mesajError."');";
    echo "window.location= '".$inapoi."';";
    echo "</script>";
    exit;
  }

  include($connect);
  $parolaEcriptata = md5($_POST['parola']);
  $sql = "SELECT * FROM admin WHERE admin_nume='".$_POST['nume']."' AND admin_parola='".$parolaEcriptata."'";
  $resursa = mysqli_query($con, $sql);
  if(mysqli_num_rows($resursa) != 1) {
    $mesajError = "Nume sau parola gresite!";
    echo "<script type='text/javascript'>";
    echo "alert('".$mesajError."');";
    echo "window.location= '".$inapoi."';";
    echo "</script>";
    exit;
  }

  session_start();
  $_SESSION['nume_admin'] = $_POST['nume'];
  $_SESSION['parola_encriptata'] = $parolaEcriptata;
  $_SESSION['key_admin'] = session_id();
  header("Location:" . $admin);
?>