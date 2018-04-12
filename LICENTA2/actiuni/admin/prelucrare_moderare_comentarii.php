<?php 
  $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";

  $autorizare  = $root . '/admin/componenteAdmin/autorizareAdmin.php';
  $headerAdmin = $root . '/admin/componenteAdmin/headerAdmin.php';
  $footerAdmin    = $root . '/admin/componenteAdmin/footerAdmin.php';
  $adminOpiniiPath = $path . '/admin/componenteAdmin/opinii.php';

  include($autorizare);
  include($headerAdmin);

  // modificare comentariu
  if(isset($_POST['modifica'])){
    if($_POST['nume_utilizator'] == ''){
      print '<div class="admin-main-content"><p>Nu ai completat numele de utilizator</p></div>';
    } else if($_POST['adresa_email'] == '') {
      print '<div class="admin-main-content"><p>Nu ai completat adresa de email</p></div>';
    } else if($_POST['comentariu'] == ''){
      print '<div class="admin-main-content"><p>Campul Comentariu este gol</p></div>';
    } else {
      $sql = "UPDATE comentarii SET nume_utilizator='".$_POST['nume_utilizator']."', adresa_email='".$_POST['adresa_email']."', comentariu='".$_POST['comentariu']."' WHERE id_comentariu=".$_POST['id_comentariu'];
      mysqli_query($con, $sql);
      header("Location:".$adminOpiniiPath);
    }
  }

  // sterge comentariu
  if(isset($_POST['sterge'])){
    $sql = "DELETE FROM comentarii WHERE id_comentariu=".$_POST['id_comentariu'];
    mysqli_query($con, $sql);
    header("Location:".$adminOpiniiPath);
  }

  if(isset($_POST['seteaza_moderare'])){
    $sql = "UPDATE admin SET ultimul_comentariu_moderat=".$_POST['ultimul_id'];
    mysqli_query($con, $sql);
    header("Location:".$adminOpiniiPath);
  }
?>