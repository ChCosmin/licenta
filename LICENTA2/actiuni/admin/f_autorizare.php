<?php 
  session_start();
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";
  $connect = $root . '/componente/conectare.php';

  include('../../componente/conectare.php');
  function autorizat() {
    $sql = "SELECT * FROM admin WHERE admin_nume='".$_SESSION['nume_admin']."' AND admin_parola='".$_SESSION['parola_encriptata']."'";
    $resursa = mysqli_query($con, $sql);
    if($_SESSION['key_admin'] != session_id() || mysqli_num_rows($resursa) != 1) {
      return false;
    } else {
      return true;
    }
  }
?>