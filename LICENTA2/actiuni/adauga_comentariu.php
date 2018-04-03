<?php
  include("../componente/conectare.php");
  $path = "/licenta2";

  $numeFaraTags = strip_tags($_POST['nume_utilizator']);
  $emailFaraTags = strip_tags($_POST['adresa_email']);
  $comentariuFaraTags = strip_tags($_POST['comentariu']);
  if($numeFaraTags && $emailFaraTags && $comentariuFaraTags){
    $insert = "INSERT INTO comentarii(id_carte, nume_utilizator, adresa_email, comentariu) VALUES (".$_POST['id_carte'].",'".$numeFaraTags."','".$emailFaraTags."','".$comentariuFaraTags."');";
    mysqli_query($con, $insert);
    $inapoi = $path . "/componente/carte.php?id_carte=".$_POST['id_carte'];
    header("Location: $inapoi");
  } else {
    $inapoi = $path . "/componente/carte.php?id_carte=".$_POST['id_carte'];
    header("Location: $inapoi");
  }  
?>