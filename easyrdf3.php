<?php 
  require "vendor/autoload.php";
  $client = new EasyRdf_Sparql_Client("http://localhost:7200/repositories/grafuri");
  $interogare="prefix : <http://expl.ro#> describe :Alin";
  $rezultat = $client->query($interogare);
  print $rezultat->dump();

  $prefixe = new EasyRdf_Namespace();
  $prefixe->setDefault("http://expl.ro#");
  $cunoscuti = $rezultat->allResources("Ana","foaf:knows");
  foreach ($cunoscuti as $cunoscut){
    print "<br/>".$cunoscut."</br>";
  }
?>

<hr size="5" style="background-color:red; margin: 10px 0;">

<?php 
  require "vendor/autoload.php";
  $client = new EasyRdf_Sparql_Client("http://localhost:7200/repositories/grafuri");
  $interogare = "prefix : <http://expl.ro#> construct {?x :cunoastePe ?y} where {{?x foaf:knows ?y} union {?y foaf:knows ?x}}";
  $reteaCunoscuti = $client->query($interogare);
  print $reteaCunoscuti->dump();
?>

<hr size="5" style="background-color:red; margin: 10px 0;">

<?php
  require "vendor/autoload.php";
  $client = new EasyRdf_Sparql_Client("http://localhost:7200/repositories/grafuri");
  print "<b>Lista subiectelor si numelor: </b><br/>";
  $interogare = "select ?subiect ?nume where {?subiect foaf:name ?nume}";
  $rezultate = $client->query($interogare);
  foreach ($rezultate as $rezultat){
    print "Subiectul ".$rezultat->subiect." are numele ".$rezultat->nume."<br/>";
  }
  print "<b>Lista tipurilor din graful persoanelor: </b><br/>";
  $interogare = "select distinct ?tip where {graph <http://expl.ro#grafPersoane> {?subiect a ?tip}}";
  $rezultate = $client->query($interogare);
  foreach ($rezultate as $rezultat){
    print $rezultat->tip."<br/>";
  }
  print "<b>Lista grafurilor:</b></br>";
  $grafuri = $client->listNamedGraphs();
  foreach ($grafuri as $graf){
    print "Am gasit graful ".$graf."</br>";
  }
?>

<hr size="5" style="background-color:red; margin: 10px 0;">

<?php
  require "vendor/autoload.php";
  $client = new EasyRdf_Sparql_Client("http://localhost:7200/repositories/grafuri/statements");
  $interogare = "prefix : <http://expl.ro#> insert data {graph :grafNou {:Andreea :lucreazaLa :ANAF}}";
  print $client->update($interogare)."<br/>";

  $graf = new EasyRdf_Graph("http://expl.ro#grafNou2");
  $prefixe = new EasyRdf_Namespace();
  $prefixe->setDefault("http://expl.ro#");
  $graf->addResource("Irina","foaf:knows","Petru");
  $graf->addResource("Irina","foaf:knows","Pavel");
  $graf->add("Irina","foaf:age","22");
  $client = new EasyRdf_Sparql_Client("http://localhost:7200/repositories/grafuri/statements");
  print $client->insert($graf,"http://expl.ro#grafNou2");
?>

