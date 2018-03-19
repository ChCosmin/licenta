<?php
  if($_POST['nume_utilizator'] == '' || $_POST['adresa_email'] == '' || $_POST['comentariu'] == '') {
    print "Trebuie sa completezi toate campruile!";
    exit;
  }
  include("../componente/conectare.php");
  $numeFaraTags = strip_tags($_POST['nume_utilizator']);
  $emailFaraTags = strip_tags($_POST['adresa_email']);
  $comentariuFaraTags = strip_tags($_POST['comentariu']);
  $insert = "INSERT INTO comentarii(id_carte, nume_utilizator, adresa_email, comentariu) VALUES (".$_POST['id_carte'].",'".$numeFaraTags."','".$emailFaraTags."','".$comentariuFaraTags."')";
  mysqli_query($con, $insert);
  $inapoi = "../carte.php?id_carte=".$_POST['id_carte'];
  header("location: $inapoi");
?>
