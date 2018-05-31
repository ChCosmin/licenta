<?php
  $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2"; 

  // $connect    = $root . '/componente/conectare.php';
  $header     = $root . '/componente/header.php';
  $footer     = $root . '/componente/footer.php';
  $autor = $path . '/componente/autor.php';
  $vendor = $root . '/vendor/autoload.php';
  $faraCoperta = $path . '/assets/covers';
  session_start(); 
  
  
  function mysqli_result($res, $row, $field=0) {     
    $res->data_seek($row); 
    $datarow = $res->fetch_array(); 
    return $datarow[$field]; 
  }
  
  // include($connect);
  include($header);
  include('../assets/Zebra_Pagination.php');
  
  include($vendor);
  $client = new EasyRdf_Sparql_Client("http://localhost:7200/repositories/librarie_licenta");
  
  
  $id_domeniu = $_GET['id_domeniu'];
  $selectDomeniu = 'PREFIX c: <http://chinde.ro#>
  select ?numeDomeniu where {
      GRAPH c:Domenii { c:'.$id_domeniu.' c:numeDomeniu ?numeDomeniu }
  }'; 
  $resursaDomeniu = $client->query($selectDomeniu);    
  

  //PAGINATION
    // how many records should be displayed on a page?
    $records_per_page = 12;

    // instantiate the pagination object
    $pagination = new Zebra_Pagination();

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
          ?idCarte c:domeniu c:'.$id_domeniu.'.
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

    // execute the MySQL query
    // $result = mysqli_query($con, $sql) or die(mysqli_error($con));
    $result = $client->query($sql);    
    // fetch the total number of records in the table
    $rows = 0;
    foreach($result as $row){
      $rows +=1;
    }

    // pass the total number of records to the pagination class
    $pagination->records($rows);

    // records per page
    $pagination->records_per_page($records_per_page);

?>
<div class="main-content domeniu-content">
  <div class="domeniu-titlu_pagination">
    <h4 class="bold width50 domeniu-titlu">Carti in domeniul <u><i><?=$resursaDomeniu[0]->numeDomeniu?></i></u>:</h4> <?php $pagination->render(); ?> 
  </div>
  <div class="container-carti-domeniu">
    <?php 
    $index = 0; 
    foreach($result as $row){
    $idCarte = parse_url($row->idCarte)["fragment"];
    ?>    
    <div class="card card-style card-style-domeniu">
      <?php 
        $adresaImg = '../assets/covers/'.$idCarte.'.jpg'; 
        if(file_exists($adresaImg)){
          print '<img class="card-img-top" src="'.$adresaImg.'" alt="book-cover" />';
        } else {
          print '<img class="card-img-top" src="'.$faraCoperta.'/no-cover.jpg" alt="book-cover" />';
        }
        $autorQ = "PREFIX c: <http://chinde.ro#>
          select ?idAutor where {
            GRAPH c:Autori {
              ?idAutor c:numeAutor '".$row->numeAutor."'
            }
          }
        ";
        $resursaAutor = $client->query($autorQ);    
        $idAutor = parse_url($resursaAutor[0]->idAutor)["fragment"];
      ?>
      <div class="card-body">
        <h5 class="card-title"><?php echo $row->titlu ?></h5>
        <p class="card-text">- de <a href="<?=$autor?>?id_autor=<?=$idAutor?>"><?php echo $row->numeAutor ?></a><br>Pret: <?php echo $row->pret ?> lei</p>
        <a class="btn btn-primary domeniu-detalii-btn" href="carte.php?id_carte=<?=$idCarte?>">Detalii</a>
      </div>
    </div>
        <?php } ?>
  </div> 
</div>

<?php include($footer); ?>
