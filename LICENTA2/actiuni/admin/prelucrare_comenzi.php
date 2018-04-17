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
  print '<h1>Comenzi</h1>';  

  // comanda onorata
  if(isset($_POST['comanda_onorata'])){
    $sql = "UPDATE tranzactii SET comanda_onorata=1 WHERE id_tranzactie=".$_POST['id_tranzactie'];
    mysqli_query($con, $sql);
    header("Location:".$adminOpiniiPath);
  }

  // comanda anulata
  if(isset($_POST['anuleaza_comanda'])){
    $sqlTranzactii = "DELETE FROM tranzactii WHERE id_tranzactie=".$_POST['id_tranzactie'];
    mysqli_query($con, $sqlTranzactii);

    $sqlCarti = "DELETE FROM vanzari WHERE id_tranzactie=".$_POST['id_tranzactie'];
    mysqli_query($con, $sqlCarti);
    header("Location:".$adminOpiniiPath);
  }

  include($footerAdmin);
?>