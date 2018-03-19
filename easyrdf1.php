<?php
  require 'vendor/autoload.php';
  $graf = new EasyRdf_Graph();
  $graf->load("http://localhost:8080/licenta/exemplu.ttl","turtle");
  $prefixe = new EasyRDF_Namespace();
  $prefixe->set("","http://expl.ro#");

  print "<b>Prefixele inregistrate sunt:</b>";
  print_r($prefixe->namespaces());
  print "<br/><br/>";

  print "<b>Continutul grafului in format N-triples este urmatorul (verificati in View page source!):</b>";
  print $graf->serialise("ntriples");
  print "<br/><br/>";

  print "<b>Continutul grafului in format HTML este urmatorul:</b>";
  print $graf->dump();
?>
<hr>
<hr>
<?php
  require 'vendor/autoload.php';
  $graf = new EasyRdf_Graph();
  $graf->load("http://localhost:8080/licenta/exemplu.ttl","turtle");
  $prefixe = new EasyRDF_Namespace();

  $persoane = $graf->allOfType("foaf:Person");
  print "<b>Persoanele identificate sunt:</b><br/>";
  foreach ($persoane as $persoana){
    print $persoana."<br/>";
  }
  print "<br/>";

  $prefixe->setDefault("http://expl.ro#");
  $studenti = $graf->allOfType("Student");
  print "<b>Studentii identificati sunt:</b><br/>";
  foreach ($studenti as $student){
    print $student."<br/>";
  }

  $tipuriAna = $graf->typesAsResources("Ana");
  print "<b>Lista claselor in care es inclusa Ana:</b><br/>";
  foreach ($tipuriAna as $tip){
    print $tip."<br/>";
  }

  print "<br/><b>Este Ana student?</b><br/>";
  print $graf->isA('Ana','Student');
  print "<br/><b>Ce nume are Endava?</b><br/>";
  print $graf->label("Endava");
  print "<br/><b>Ce nume are Ana?</b><br/>";
  print $graf->label("Ana");

  print "<br/><b>Ce proprietati are Ana?</b><br/>";
  $proprietati = $graf->propertyUris("Ana");
  foreach ($proprietati as $proprietate){
    print $proprietate."<br/>";
  }

  print "<br/><b>Pe cine cunoaste Ana si unde lucreaza cunoscutii sai?</b><br/>";
  $cunoscuti = $graf->allResources("Ana","foaf:knows");
  foreach ($cunoscuti as $cunoscut){
    print $cunoscut;
    if ($cunoscut->hasProperty("lucreazaLa")){
      print " are locul de munca: ".$cunoscut->lucreazaLa;
    } else {
      print " nu are loc de munca declarat.";
    }
    print "<br?>";
  }

  print "<br/>";

  print "<br/><b>Cum ii cheama pe cei cunoscuti de Ana?</b><br/>";
  $toateNumele = $graf->all("Ana","foaf:knows/foaf:name");
  foreach ($toateNumele as $nume){
    print $nume."<br/>";
  }

  print "<br/><b>Ce URI are entitatea cu numele Popescu Andrei?</b><br/>";
  $subiecte = $graf->resourcesMatching("foaf:name","Popescu Andrei");
  foreach ($subiecte as $subiect){
    print $subiect."<br/>";
  }

  print "<br/><b>Cine lucreaza la Endava?</b><br/>";
  $Endava = $graf->resource("Endava");
  $angajati = $Endava->allResources("^lucreazaLa");
  foreach ($angajati as $angajat){
    print $angajat."<br/>";
  }

  print "<br/><b>Ce varsta are Ana?</b><br/>";
  print $graf->getLiteral("Ana","foaf:age");
  print "<br/><b>Unde studiaza Ana?</b><br/>";
  print "URI complet: ".$graf->getResource("Ana","studiazaLa")."<br/>";
  print "URI relativ: ".$graf->getResource("Ana","studiazaLa")->localName()."<br/>";
  print "<br/><b>Care e prefixul lui foaf:name?</b><br/>";
  print $graf->resource("foaf:name")->prefix();

  
?>
