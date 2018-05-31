<?php
// $autorQ = "SELECT id_autor FROM autori WHERE nume_autor='".$row->numeAutor."'";
// $resursaAutor = mysqli_query($con, $autorQ);
// $rowAutor = mysqli_fetch_array($resursaAutor);
// print '<div class="card card-style">';
// $adresaImg = "assets/covers/http://chinde.ro#".$row->idCarte.".jpg";
// if(file_exists($adresaImg)){
//   print '<img class="card-img-top" src="'.$adresaImg.'" alt="book-cover">';
// } else {
//   print '<img class="card-img-top" src="assets/covers/no-cover.jpg" alt="book-cover" />';
// }
// print '
//   <div class="card-body">
//     <h6 class="card-title">'.$row->titlu.'</h6>
//     <p class="card-text">- de <a href="'.$autor.'?id_autor='.$rowAutor["id_autor"].'"><i>'.$row->numeAutor.'</i></a><br>
//     Pret: '.$row->pret.' lei</p>
//     <a class="btn btn-primary firstPage-detalii-btn" href="'.$carte.'?id_carte='.$row->idCarte.'">Detalii</a>
//   </div>
// </div>';
  // $prefixe = new EasyRDF_Namespace();
  // $prefixe->set("","http://expl.ro#");

require 'vendor/autoload.php';
$client = new EasyRdf_Sparql_Client("http://localhost:7200/repositories/librarie_licenta", "http://localhost:7200/repositories/librarie_licenta/statements");

$titlu = ucwords("Fire de tort");
// $pieces = explode($titlu);
$ttl = str_replace(' ','',$titlu);


print $ttl;

// $date = getdate();
// // print getdate();
// $dd = $date['mday'];
// $mm = $date['mon'];
// $yyyy = $date['year'];

// print_r($date);
// print "<br>";
// print $dd.'-'.$mm.'-'.$yyyy;
?>
  