<?php
  include("../componente/conectare.php");
  include('../assets/ChromePhp.php');

  $numeFaraTags = strip_tags($_POST['nume_utilizator']);
  $emailFaraTags = strip_tags($_POST['adresa_email']);
  $comentariuFaraTags = strip_tags($_POST['comentariu']);
  ChromePhp::log('dadasdasdas');

  $insert = "INSERT INTO comentarii(id_carte, nume_utilizator, adresa_email, comentariu) VALUES (".$_POST['id_carte'].",'".$numeFaraTags."','".$emailFaraTags."','".$comentariuFaraTags."');";
  mysqli_query($con, $insert);
  $inapoi = "../componente/carte.php?nume_utilizator=&adresa_email=&comentariu=&id_carte=".$_POST['id_carte'];
  ChromePhp::log($inapoi);
  header("location: $inapoi");
?>