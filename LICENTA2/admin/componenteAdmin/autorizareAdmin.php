<?php
  $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";
  $connect = $root . '/componente/conectare.php';

  session_start();
  if($_SESSION['key_admin'] != session_id()){
    print 'Acces neautorizat';
    exit;
  }

  include($connect);
  $sql = "SELECT * FROM admin WHERE admin_nume='".$_SESSION['nume_admin']."' AND admin_parola='".$_SESSION['parola_encriptata']."'";
  $resursa = mysqli_query($con, $sql);
  if(mysqli_num_rows($resursa) != 1) {
    print 'Acces neautorizat';
    exit;
  }
?>