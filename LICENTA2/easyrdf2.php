<?php
  require 'vendor/autoload.php';
  $client = new EasyRdf_Sparql_Client("http://lod.springer.com/sparql");
  $interogate = "describe <http://lod.springer.com/data/conference/semweb2014>";
  $rezultat = $client->query($interogate);
  print $rezultat;
  print "<br/>";
  print $rezultat->dump();
?>

<?php
  require "vendor/autoload.php";
  $graf = new EasyRdf_Graph();
  $graf->load("http://localhost:8080/licenta/exemplu.ttl","turtle");
  $prefixe = new EasyRDF_Namespace();
  $prefixe->setDefault("http://expl.ro#");

  $graf->addResource("Irina","foaf:knows","Petru");
  $graf->addResource("Irina","foaf:knows","Pavel");
  $graf->add("Irina","foaf:age","22");
  
  print $graf->dump();
  $Irina = $graf->resource("Irina");
  $Irina->areSalariu=10000;
  print $graf->dump();
  $graf->delete("Irina","foaf:age");
  print $graf->dump();
  $graf->deleteResource("Irina","foaf:knows",'Pavel');
  print $graf->dump();
  print $graf->serialise('json');
?>
