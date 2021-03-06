<?php 
  $path = '/licenta2';
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2"; 
  
  $domeniuPath = $path . '/componente/domeniu.php';
  $vendor = $root . '/vendor/autoload.php';

  include($vendor);
  $client = new EasyRdf_Sparql_Client("http://localhost:7200/repositories/librarie_licenta");
?>

<ul class="navbar-nav mr-auto unselectable owl-carousel owl-theme">
  <?php 
    $domenii = 'PREFIX c: <http://chinde.ro#>
    select distinct ?idDomeniu ?numeDomeniu where { 
      GRAPH c:Domenii { 
        ?idDomeniu c:numeDomeniu ?numeDomeniu 
      }
    } order by ?numeDomeniu';
  
    $rezultatDomenii = $client->query($domenii);    
    foreach($rezultatDomenii as $row){
      $idDomeniu = parse_url($row->idDomeniu)['fragment'];    
      print '<li class="nav-item "><a class="nav-link unselectable" href="'.$domeniuPath.'?id_domeniu='.$idDomeniu.'">'.$row->numeDomeniu.'</a></li>';
    }
  ?>
</ul>
   