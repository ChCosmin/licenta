<?php 
  $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";

  $carte = $path . '/componente/carte.php';
  $autor = $path . '/componente/autor.php';

  require 'vendor/autoload.php';
  $client = new EasyRdf_Sparql_Client("http://localhost:7200/repositories/librarie_licenta");

?>

<main class="main-content">  
  <section class="left-section">
    <h4 class="section-name">Cele mai noi carti</h4>
    <div class="new-books">
      <?php
        // $select = "SELECT id_carte, titlu, nume_autor, pret FROM carti, autori WHERE carti.id_autor=autori.id_autor ORDER BY data LIMIT 0,8";
        $select="PREFIX c: <http://chinde.ro#>
        select distinct ?idCarte ?titlu ?numeAutor ?pret where { 
            GRAPH c:Carti { 
                ?idCarte c:pret ?pret. 
                ?idCarte c:titlu ?titlu. 
                ?idCarte c:autor ?x.
                ?idCarte c:data ?data
            }
            GRAPH c:Autori { ?x c:numeAutor ?numeAutor}
        } order by ?data limit 8";        
        // $resursa = mysqli_query($con, $select);
        $resursa = $client->query($select);
        // while($row = mysqli_fetch_array($resursa)){
        foreach ($resursa as $row) {
          $idCarteVanduta = parse_url($row->idCarte)["fragment"];
          // $autorQ = "SELECT id_autor FROM autori WHERE nume_autor='".$row->numeAutor."'";
          $autorQ = 'PREFIX c: <http://chinde.ro#>
            select ?idAutor where { 
                GRAPH c:Autori {?idAutor ?y "'.$row->numeAutor.'"}
            }';
          // $resursaAutor = mysqli_query($con, $autorQ);
          $resursaAutor = $client->query($autorQ);    
          // to obtain keyword after #
          $idAutor = parse_url($resursaAutor)["fragment"];  
          $find = array(" ","|","+","-","_"); 
          $replace = array(""); 
          $arr = $idAutor;
          $actualIdAutor = str_replace($find, $replace, $arr);   

          // $rowAutor = mysqli_fetch_array($resursaAutor);
          print '<div class="card card-style">';
          $imgId = parse_url($row->idCarte)["fragment"];
          $adresaImg = "assets/covers/".$imgId.".jpg";
          if(file_exists($adresaImg)){
            print '<img class="card-img-top" src="'.$adresaImg.'" alt="book-cover">';
          } else {
            print '<img class="card-img-top" src="assets/covers/no-cover.jpg" alt="book-cover" />';
          }
          print '
            <div class="card-body">
              <h6 class="card-title">'.$row->titlu.'</h6>
              <p class="card-text">- de <a href="'.$autor.'?id_autor='.$actualIdAutor.'"><i>'.$row->numeAutor.'</i></a><br>
              Pret: '.$row->pret.' lei</p>
              <a class="btn btn-primary firstPage-detalii-btn" href="'.$carte.'?id_carte='.$idCarteVanduta.'">Detalii</a>
            </div>
          </div>';        
        }      
      ?>
    </div> 
  </section>  
    
  <section class="right-section">
    <h4 class="section-name">Cele mai populare carti</h4>
    <div class="popular-books">
      <?php
        // $selectVanzari = "SELECT id_carte, sum(nr_buc) AS bucatiVandute FROM vanzari GROUP BY id_carte ORDER BY bucatiVandute DESC LIMIT 0,6";
        $selectVanzari = 'PREFIX c: <http://chinde.ro#>
        select distinct ?idCarte (sum(?nrBuc) as ?bucatiVandute) where {
          GRAPH c:Vanzari { 
            ?idVanzare c:bucati ?nrBuc.
            ?idVanzare c:carte ?idCarte
          }
        } group by ?idCarte order by desc(?bucatiVandute) limit 6';
        // $resursaVanzari = mysqli_query($con, $selectVanzari);
        $resursaVanzari = $client->query($selectVanzari);    
        
        // while($rowVanzari = mysqli_fetch_array($resursaVanzari)){
        foreach($resursaVanzari as $rowVanzari){
          $idCarteVanduta = parse_url($rowVanzari->idCarte)["fragment"];
          // $selectCarte = "SELECT titlu, nume_autor, pret FROM carti, autori WHERE carti.id_autor=autori.id_autor AND id_carte=".$rowVanzari->idCarte;
          $selectCarte = 'PREFIX c: <http://chinde.ro#>
            select ?titlu ?numeAutor ?pret where {
                GRAPH c:Carti { 
                  ?idCarte c:titlu ?titlu. 
                  ?idCarte c:pret ?pret. 
                  ?idCarte c:autor ?idAutor }
                GRAPH c:Autori { ?idAutor c:numeAutor ?numeAutor }
                filter(?idCarte=c:'.$idCarteVanduta.')
            }';
          // $resursaCarte = mysqli_query($con, $selectCarte);
          $resursaCarte = $client->query($selectCarte);    
          
          // while($rowCarte = mysqli_fetch_array($resursaCarte)){
          foreach($resursaCarte as $rowCarte){
            // $autorQ = "SELECT id_autor FROM autori WHERE nume_autor='".$rowCarte->numeAutor."'";
            $autorQ = 'PREFIX c: <http://chinde.ro#>
              select ?idAutor where {
                  GRAPH c:Autori { ?idAutor c:numeAutor "'.$rowCarte->numeAutor.'"}
              }';
            // $resursaAutor = mysqli_query($con, $autorQ);
            $resursaAutor = $client->query($autorQ); 
            $idAutor = parse_url($resursaAutor)["fragment"];  
            $find = array(" ","|","+","-","_"); 
            $replace = array(" "); 
            $arr = $idAutor;
            $actualIdAutor = str_replace($find, $replace, $arr);                  
            // $rowAutor = mysqli_fetch_array($resursaAutor);
            print '<div class="card card-style">';          
            $adresaImg2 = "assets/covers/".$idCarteVanduta.".jpg";
            if(file_exists($adresaImg2)){
              print '<img class="card-img-top" src="'.$adresaImg2.'" alt=>';   
            } else {
              print '<img class="card-img-top" src="assets/covers/no-cover.jpg" alt="book-cover" />';
            }
            print '
              <div class="card-body">
                <h6 class="card-title">'.$rowCarte->titlu.'</h6>
                <p class="card-text">- de <a href="'.$autor.'?id_autor='.$actualIdAutor.'"><i>'.$rowCarte->numeAutor.'</i></a><br>
                Pret: '.$rowCarte->pret.' lei</p>
                <a class="btn btn-primary firstPage-detalii-btn" href="'.$carte.'?id_carte='.$idCarteVanduta.'">Detalii</a>
              </div>
            </div>';
          }
        }                 
      ?>
    </div>
  </section>
</main>
