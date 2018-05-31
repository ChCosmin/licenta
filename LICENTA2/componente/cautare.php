<?php 
  $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";

  // $connect   = $root . '/componente/conectare.php';
  $header    = $root . '/componente/header.php';
  $footer    = $root . '/componente/footer.php';

  $carte = $path . '/componente/carte.php';
  $autor = $path . '/componente/autor.php';


  session_start();
  // include($connect);
  include($header);
  $cuvant = $_GET['cuvant'];
  
  require '../vendor/autoload.php';
  $client = new EasyRdf_Sparql_Client("http://localhost:7200/repositories/librarie_licenta");
?>
<div class="main-content cautare-content">
  <h2 class="width100 cautare-titlu">Rezultatele cautarii</h2>
  <p class="width100">Textul cautat: <b><?php echo $cuvant ?></b></p>
  <h6 class="width100 bold">Autori:</h6>
  <div class="cautare-list">
    <blockquote class="cautare-blockquote">
      <?php 
        $sql = 'PREFIX c: <http://chinde.ro#>
          select ?idAutor ?numeAutor where {
              GRAPH c:Autori { 
                ?idAutor c:numeAutor ?numeAutor. 
                filter regex(?numeAutor, "'.$cuvant.'" , "i")
              }
          }';
        $resursa=$client->query($sql);
        $rows = 0;
        foreach($resursa as $row){
          $rows += 1;
        };
        if($rows === 0){
          print '<i>Nici un rezultat</i>';
        }
        foreach($resursa as $row){
          $idAutor = parse_url($row->idAutor)["fragment"];
          print "<a href='".$autor."?id_autor=".$idAutor."'>".$row->numeAutor."</a><br/>";
        }
      ?>
    </blockquote>
  </div>
  <hr class="my-2">

  <h6 class="width100 bold">Titluri:</h6>
  <div class="cautare-list">
    <blockquote class="cautare-blockquote">
      <?php 
        $sql2 = 'PREFIX c: <http://chinde.ro#>
          select ?idCarte ?titlu where {
              GRAPH c:Carti { 
                ?idCarte c:titlu ?titlu. 
                filter regex(?titlu, "'.$cuvant.'", "i")
              }
          }';
        $resursa2=$client->query($sql2);
        $rows = 0;
        foreach($resursa2 as $row){
          $rows += 1;
        }
        if($rows === 0){
          print '<i>Nici un rezultat</i>';
        }
        foreach($resursa2 as $row){
          $idCarte = parse_url($row->idCarte)["fragment"];
          print "<a href='".$carte."?id_carte=".$idCarte."'>".$row->titlu."</a><br/>";
        }
      ?>
    </blockquote>
  </div>
  <hr class="my-2">

  <h6 class="width100 bold">Descrieri:</h6>
  <div class="cautare-list">
    <blockquote class="cautare-blockquote">
      <?php 
        $sql3 = 'PREFIX c: <http://chinde.ro#>
          select ?idCarte ?titlu ?descriere where {
              GRAPH c:Carti { 
                ?idCarte c:titlu ?titlu. 
                OPTIONAL{ ?idCarte c:descriere ?descriere. }
                filter regex(?descriere, "'.$cuvant.'", "i")}
          }';
        $resursa3=$client->query($sql3);
        $rows = 0;
        foreach($resursa3 as $row){
          $rows += 1;
        }
        if($rows == 0){
          print '<i>Nici un rezultat</i>';
        }
        foreach($resursa3 as $row){
          $idCarte = parse_url($row->idCarte)["fragment"];
          print "<div class='width100 cautare-descriere'><a href='".$carte."?id_carte=".$idCarte."'>".$row->titlu."</a><i>".$row->descriere."</i></div></br>";
        }
      ?>
    </blockquote>
  </div>

</div>

<?php include($footer); ?>