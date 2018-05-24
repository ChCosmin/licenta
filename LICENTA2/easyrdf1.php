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

  include('assets/Zebra_Pagination.php');
  require 'vendor/autoload.php';
  $client = new EasyRdf_Sparql_Client("http://localhost:7200/repositories/librarie_licenta");
 //PAGINATION
    // how many records should be displayed on a page?
    $records_per_page = 12;

    // instantiate the pagination object
    $pagination = new Zebra_Pagination();
    $id_domeniu="Poezii";
    // the MySQL statement to fetch the rows
    // note how we build the LIMIT
    // also, note the "SQL_CALC_FOUND_ROWS"
    // this is to get the number of rows that would've been returned if there was no LIMIT
    // $sql = '
    //     SELECT
    //         SQL_CALC_FOUND_ROWS
    //         id_carte, titlu, carti.descriere, pret, nume_autor 
    //     FROM
    //         carti, autori, domenii
    //     WHERE
    //         carti.id_domeniu=domenii.id_domeniu AND 
    //         carti.id_autor=autori.id_autor AND 
    //         domenii.id_domeniu='.$id_domeniu.'
    //     LIMIT
    //         ' . (($pagination->get_page() - 1) * $records_per_page) . ', ' . $records_per_page . '
    // ';
    $offset = ($pagination->get_page() - 1) * $records_per_page;
    $sql = 'PREFIX c: <http://chinde.ro#>
      select ?idCarte ?titlu ?descriereCarte ?pret ?numeAutor ?numeDomeniu where {
        GRAPH c:Carti {
          ?idCarte c:titlu ?titlu.
          ?idCarte c:pret ?pret.
          ?idCarte c:autor ?idAutor.
          ?idCarte c:domeniu ?idDomeniu.
          OPTIONAL {?idCarte c:descriere ?descriereCarte.}
        }
        GRAPH c:Autori {
          ?idAutor c:numeAutor ?numeAutor.
        }
        GRAPH c:Domenii {
          c:'.$id_domeniu.' c:numeDomeniu ?numeDomeniu.
        }
      } LIMIT '. $records_per_page . '
        OFFSET '. $offset . '
    ';

    $sqlNoLimit = 'PREFIX c: <http://chinde.ro#>
      select ?idCarte ?titlu ?descriereCarte ?pret ?numeAutor where {
      GRAPH c:Carti {
        ?idCarte c:titlu ?titlu.
        ?idCarte c:descriere ?descriereCarte.
        ?idCarte c:pret ?pret.
        ?idCarte c:autor ?idAutor.
        ?idCarte c:domeniu ?idDomeniu
      }
      GRAPH c:Autori {
        ?idAutor c:numeAutor ?numeAutor.
      }
      GRAPH c:Domenii {
        c:'.$id_domeniu.' c:numeDomeniu ?numeDomeniu.
      }
    }';

    // execute the MySQL query
    // $result = mysqli_query($con, $sql) or die(mysqli_error($con));
    $result = $client->query($sql); 
    // $resultNoLimit = $client->query($sqlNoLimit);
    // fetch the total number of records in the table
    // $rows = mysqli_fetch_assoc(mysqli_query($con, 'SELECT FOUND_ROWS() AS rows'));
    // $rows = 0;
    // print $resultNoLimit;
    // foreach($resultNoLimit as $row){
    //   $rows +=1;
    // }
    $rows = 0;
    foreach($result as $row){
      $rows +=1;
      print 'Id:'.$row->idCarte.' Titlu:'.$row->titlu.' Descriere:'.$row->descriereCarte.' Pret:'.$row->pret.' Autor:'.$row->numeAutor.' Domeniu:'.$row->numeDomeniu.'<br>';
    }
    print "TOTAL rows should be".$rows;
    // print $rows;
    // pass the total number of records to the pagination class
    $pagination->records($rows);

    // records per page
    $pagination->records_per_page($records_per_page);

    // foreach($result as $row){

    // }
  













  
  // foreach($resursa as $row){
  //   print $row->titlu;
  // }
  //   // print $url["fragment"]; 
  //   print $row->bucatiVandute;
  // }

// we look for the individuals that Ana knows, but ONLY in the result of DESCRIBE, not in the entire database!
// only Alin should be found
  // $graf = new EasyRdf_Graph();
  // $graf->load("http://localhost/licenta2/exemplu.ttl","turtle");
  // $prefixe = new EasyRDF_Namespace();

  // $grafCarti = new EasyRdf_Graph();
  // $client = new EasyRdf_Sparql_Client('http://localhost:7200/sparql');
  // $grafCarti->load("http://localhost/licenta2/librarie_licenta.ttl", "turtle");


  // $persoane = $graf->allOfType("foaf:Person");
  // print "<b>Persoanele identificate sunt:</b><br/>";
  // foreach ($persoane as $persoana){
  //   print $persoana."<br/>";
  // }
  // print "<br/>";

  // $x->set("http://chinde.ro#");
  // $carti = $grafCarti->allOfType("c:Carte");

  // $prefixe->setDefault("http://expl.ro#");
  // $studenti = $graf->allOfType("Student");
  // print "<b>Studentii identificati sunt:</b><br/>";
  // foreach ($studenti as $student){
  //   print $student."<br/>";
  // }

  // $tipuriAna = $graf->typesAsResources("Ana");
  // print "<b>Lista claselor in care es inclusa Ana:</b><br/>";
  // foreach ($tipuriAna as $tip){
  //   print $tip."<br/>";
  // }

  // print "<br/><b>Este Ana student?</b><br/>";
  // print $graf->isA('Ana','Student');
  // print "<br/><b>Ce nume are Endava?</b><br/>";
  // print $graf->label("Endava");
  // print "<br/><b>Ce nume are Ana?</b><br/>";
  // print $graf->label("Ana");

  // print "<br/><b>Ce proprietati are Ana?</b><br/>";
  // $proprietati = $graf->propertyUris("Ana");
  // foreach ($proprietati as $proprietate){
  //   print $proprietate."<br/>";
  // }

  // print "<br/><b>Pe cine cunoaste Ana si unde lucreaza cunoscutii sai?</b><br/>";
  // $cunoscuti = $graf->allResources("Ana","foaf:knows");
  // foreach ($cunoscuti as $cunoscut){
  //   print $cunoscut;
  //   if ($cunoscut->hasProperty("lucreazaLa")){
  //     print " are locul de munca: ".$cunoscut->lucreazaLa;
  //   } else {
  //     print " nu are loc de munca declarat.";
  //   }
  //   print "<br/>";
  // }

  // print "<br/>";

  // print "<br/><b>Cum ii cheama pe cei cunoscuti de Ana?</b><br/>";
  // $toateNumele = $graf->all("Ana","foaf:knows/foaf:name");
  // foreach ($toateNumele as $nume){
  //   print $nume."<br/>";
  // }

  // print "<br/><b>Ce URI are entitatea cu numele Popescu Andrei?</b><br/>";
  // $subiecte = $graf->resourcesMatching("foaf:name","Popescu Andrei");
  // foreach ($subiecte as $subiect){
  //   print $subiect."<br/>";
  // }

  // print "<br/><b>Cine lucreaza la Endava?</b><br/>";
  // $Endava = $graf->resource("Endava");
  // $angajati = $Endava->allResources("^lucreazaLa");
  // foreach ($angajati as $angajat){
  //   print $angajat."<br/>";
  // }

  // print "<br/><b>Ce varsta are Ana?</b><br/>";
  // print $graf->getLiteral("Ana","foaf:age");
  // print "<br/><b>Unde studiaza Ana?</b><br/>";
  // print "URI complet: ".$graf->getResource("Ana","studiazaLa")."<br/>";
  // print "URI relativ: ".$graf->getResource("Ana","studiazaLa")->localName()."<br/>";
  // print "<br/><b>Care e prefixul lui foaf:name?</b><br/>";
  // print $graf->resource("foaf:name")->prefix();
 
?>
