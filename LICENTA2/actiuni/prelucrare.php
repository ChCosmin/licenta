<?php
  $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";

  $connect   = $root . '/componente/conectare.php';
  $cos = $path . '/componente/cos.php';
  $multumim = $path . '/componente/multumim.php';

  include($connect);
  session_start();

  if($_POST['nume'] === '') {
    print 'Trebuie sa completati numele! <a href="'.$cos.'">Inapoi</a>';
    exit();
  }
  if($_POST['adresa'] === '') {
    print 'Trebuie sa completati adresa! <a href="'.$cos.'">Inapoi</a>';
    exit();
  }
  include('../assets/ChromePhp.php');
  
  $nrCarti = array_sum($_SESSION['nr_buc']);

  if($nrCarti == 0) {
    print 'Trebuie sa cumparazi cel putin o carte! <a href="'.$cos.'">Inapoi</a>';
    exit();
  }

  include($connect);
  $sqlTranzactie = 'INSERT INTO tranzactii (nume_cumparator, adresa_cumparator) VALUES ("'.$_POST['nume'].'","'.$_POST['adresa'].'")';
  $resursaTranzactie = mysqli_query($con, $sqlTranzactie);
  $id_tranzactie = mysqli_insert_id($con);

  for ($i=0; $i<count($_SESSION['id_carte']); $i++) {
    if($_SESSION['nr_buc'][$i] > 0) {
      $sqlVanzare = "INSERT INTO vanzari VALUES ('".$id_tranzactie."', '".$_SESSION['id_carte'][$i]."', '".$_SESSION['nr_buc'][$i]."')";
      mysqli_query($con, $sqlVanzare);
    }
  }

  $emailDestinatar = $_POST['email'];
  $subiect = "O noua comanda Librarium";
  $totalGeneral = 0;
  $mesaj = "O noua comanda de la <b>".$_POST['nume']."</b><br/>";
  $mesaj .= "Adresa: ".$_POST['adresa']."<br/>";
  $mesaj .= "Cartile comandate: <br/><br/>";
  $mesaj .= "<table border='1' cellspacing='0' cellpadding='4'>";
  for($i=0; $i<count($_SESSION['id_carte']); $i++){
    if($_SESSION['nr_buc'][$i]){
      $mesaj .= "<tr><td>".$_SESSION['titlu'][$i]." de ".$_SESSION['nume_autor'][$i]."</td></tr>";
      $totalGeneral = $totalGeneral + ($_SESSION['nr_buc'][$i] * $_SESSION['pret'][$i]);
    }
  }
  $mesaj .= "</table";
  $mesaj .= "Total: <b>".$totalGeneral."</b>";

  $headers = "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso-8859-2\r\n";
    $_SESSION['titlu']=[];
    $_SESSION['id_carte']=[];
    $_SESSION['nume_autor']=[];
    $_SESSION['pret']=[];
    $_SESSION['nr_buc']=[];

  header('Location: '. $multumim);
?>