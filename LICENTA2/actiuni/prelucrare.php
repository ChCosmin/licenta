<?php
  $path = "/licenta2";
  // $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";

  // $connect   = $root . '/componente/conectare.php';
  $cos = $path . '/componente/cos.php';
  $multumim = $path . '/componente/multumim.php';

  require '../vendor/autoload.php';
  $client = new EasyRdf_Sparql_Client("http://localhost:7200/repositories/librarie_licenta", "http://localhost:7200/repositories/librarie_licenta/statements");
  
  // include($connect);
  session_start();

  if($_POST['nume'] === '') {
    print 'Trebuie sa completati numele! <a href="'.$cos.'">Inapoi</a>';
    exit();
  }
  if($_POST['adresa'] === '') {
    print 'Trebuie sa completati adresa! <a href="'.$cos.'">Inapoi</a>';
    exit();
  }
  
  $nrCarti = array_sum($_SESSION['nr_buc']);

  if($nrCarti == 0) {
    print 'Trebuie sa cumparazi cel putin o carte! <a href="'.$cos.'">Inapoi</a>';
    exit();
  }

  // include($connect);
  $lastTranzIdSql = 'PREFIX c: <http://chinde.ro#>
  select (max(?valId)+1 as ?lastId) where {
    GRAPH c:Tranzactii { ?idTranz c:id ?valId }
  }';
  $lastTranzId = $client->query($lastTranzIdSql);
  $idTranz = $lastTranzId[0]->lastId;
  $date = getdate();
  $dd = $date['mday'];
  $mm = $date['mon'];
  $yyyy = $date['year'];

  $sqlTranzactie = 'PREFIX c: <http://chinde.ro#>
    insert data {
      GRAPH c:Tranzactii {
        c:T'.$idTranz.'
          c:id '.$idTranz.';
          c:data "'.$dd.'-'.$mm.'-'.$yyyy.'"^^xsd:date;
          c:numeCumparator "'.$_POST['nume'].'";
          c:adresaCumparator "'.$_POST['adresa'].'";
          a c:Tranzactie.
      }
    }';
  
  $client->update($sqlTranzactie);

  for ($i=0; $i<count($_SESSION['id_carte']); $i++) {
    if($_SESSION['nr_buc'][$i] > 0) {
      $lastVanzIdSql = 'PREFIX c: <http://chinde.ro#>
      select (max(?valId)+1 as ?lastId) where {
        GRAPH c:Vanzari { ?idVanz c:id ?valId }
      }';
      $lastVanzId = $client->query($lastVanzIdSql);
      $idVanz = $lastVanzId[0]->lastId;

      $sqlVanzare = 'PREFIX c: <http://chinde.ro#>
      insert data {
        GRAPH c:Vanzari {
          c:V'.$idVanz.'
            c:id '.$idVanz.';
            c:idTranz c:T'.$idTranz.';
            c:carte c:'.$_SESSION['id_carte'][$i].';
            c:bucati '.$_SESSION['nr_buc'][$i].';
            a c:Vanzare.
        }
      }';
      $client->update($sqlVanzare);
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