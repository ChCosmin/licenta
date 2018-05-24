<?php
  $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2"; 

  $connect    = $root . '/componente/conectare.php';
  $header     = $root . '/componente/header.php';
  $footer     = $root . '/componente/footer.php';
  $autor = $path . '/componente/autor.php';
  $vendor = $root . '/vendor/autoload.php';
  $faraCoperta = $path . '/assets/covers';
  session_start(); 
  
  // require '../vendor/autoload.php';
  
  function mysqli_result($res, $row, $field=0) {     
    $res->data_seek($row); 
    $datarow = $res->fetch_array(); 
    return $datarow[$field]; 
  }
  
  include($connect);
  include($header);
  include('../assets/Zebra_Pagination.php');
  include($vendor);
  $client = new EasyRdf_Sparql_Client("http://localhost:7200/repositories/librarie_licenta");
  
  
  $id_domeniu = $_GET['id_domeniu'];
  // $selectDomeniu = "SELECT nume_domeniu FROM domenii WHERE id_domeniu=".$id_domeniu;
  $selectDomeniu = 'PREFIX c: <http://chinde.ro#>
  select ?numeDomeniu where {
      GRAPH c:Domenii { c:'.$id_domeniu.' c:numeDomeniu ?numeDomeniu }
  }'; 
  // $resursaDomeniu = mysqli_query($con, $selectDomeniu);
  $resursaDomeniu = $client->query($selectDomeniu);    
  
  // $numeDomeniu = mysqli_result($resursaDomeniu, 0, "nume_domeniu");

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

    $sql = 'PREFIX c: <http://chinde.ro#>
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
      } LIMIT
      ' . (($pagination->get_page() - 1) * $records_per_page) . ', ' . $records_per_page . '
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
    // $result = $client->query($sql);    
    $resultNoLimit = $client->query($sqlNoLimit);
    // fetch the total number of records in the table
    // $rows = mysqli_fetch_assoc(mysqli_query($con, 'SELECT FOUND_ROWS() AS rows'));
    $rows = 0;
    print $resultNoLimit;
    // foreach($resultNoLimit as $row){
    //   $rows +=1;
    // }

    print $rows;
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
    while ($row = mysqli_fetch_assoc($result)):?>    
    <div class="card card-style card-style-domeniu">
      <?php 
        $adresaImg = '../assets/covers/coperte'.$row['id_carte'].'.jpg'; 
        if(file_exists($adresaImg)){
          print '<img class="card-img-top" src="'.$adresaImg.'" alt="book-cover" />';
        } else {
          print '<img class="card-img-top" src="'.$faraCoperta.'/no-cover.jpg" alt="book-cover" />';
        }
        // $autorQ = "SELECT id_autor FROM autori WHERE nume_autor='".$row['nume_autor']."'";
        $autorQ = "PREFIX c: <http://chinde.ro#>
          select ?idAutor where {
            GRAPH c:Autori {
              ?idAutor c:numeAutor '".$row['nume_autor']."'
            }
          }
        ";
        // $resursaAutor = mysqli_query($con, $autorQ);
        $resursaAutor = $client->query($autorQ);    
        $idAutor = parse_url($resursaAutor[0]->idAutor)["fragment"];
        // $rowAutor = mysqli_fetch_array($resursaAutor);
      ?>

      <div class="card-body">
        <h5 class="card-title"><?php echo $row['titlu'] ?></h5>
        <p class="card-text">- de <a href="<?=$autor?>?id_autor=<?=$idAutor?>"><?php echo $row['nume_autor'] ?></a><br>Pret: <?php echo $row['pret'] ?> lei</p>
        <a class="btn btn-primary domeniu-detalii-btn" href="carte.php?id_carte=<?php echo $row['id_carte'] ?>">Detalii</a>
      </div>
    </div>
    <?php endwhile; ?>
  </div> 
</div>

<?php include($footer); ?>
