<?php 
  $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";

  $connect      = $root . '/componente/conectare.php';
  $header       = $root . '/componente/header.php';
  $footer       = $root . '/componente/footer.php';
  $adaugaComent = $root . '/actiuni/adauga_comentariu.php';
  $cartePath    = $path . '/componente/carte.php';

  
  session_start();
  include($connect);
  include($header); 

  require '../vendor/autoload.php';
  $client = new EasyRdf_Sparql_Client("http://localhost:7200/repositories/librarie_licenta");

  $id_autor = $_GET['id_autor'];

  // $selectAutor = "SELECT nume_autor, descriere, sursa_descriere FROM autori WHERE id_autor=".$id_autor;
  $selectAutor ='PREFIX c: <http://chinde.ro#>
  select ?numeAutor ?descriere ?sursaDescriere where {
      GRAPH c:Autori {
          ?idAutor c:numeAutor ?numeAutor.
          OPTIONAL{?idAutor c:descriere ?descriere.
          ?idAutor c:sursaDescriere ?sursaDescriere}
      }
      filter(?idAutor=c:'.$id_autor.')
  }';

  // $resursaAutor = mysqli_query($con, $selectAutor);
  $resursaAutor = $client->query($selectAutor);
  
  // $rowAutor = mysqli_fetch_array($resursaAutor);

  // $selectCarti = "SELECT id_carte, titlu, pret, nume_autor FROM carti, autori WHERE carti.id_autor=".$id_autor." AND carti.id_autor=autori.id_autor";
  $selectCarti ='PREFIX c: <http://chinde.ro#>
  select ?idCarte ?titlu ?pret ?numeAutor where {
      GRAPH c:Autori {
          ?idAutor c:numeAutor ?numeAutor.
      }
      GRAPH c:Carti {
          ?idCarte c:titlu ?titlu.
          ?idCarte c:pret ?pret.
          ?idCarte c:autor ?idAutor.
          filter(?idAutor=c:'.$id_autor.')
      }
  }';
  // $resursaCarti = mysqli_query($con, $selectCarti);
  $resursaCarti = $client->query($selectCarti);  
?>

<div class="main-content autor-content">
  <section class="width40 autor-section-left">
    <?php
      $adresaImgAutor = "../assets/autori/autor".$id_autor.".jpg";
      $faraImgAutor = "../assets/autori/no-img.jpg";

      if(file_exists($adresaImgAutor)){
        print '<img class="autor-imagine" src="'.$adresaImgAutor.'" alt="imagine autor" />';
      } else {
        print '<img class="autor-imagine" src="'.$faraImgAutor.'" alt="imagine autor" />';
      }
    ?>
    <h2 class="autor-nume"><?=$resursaAutor[0]->numeAutor?></h2>
    <?php 
      if(isset($resursaAutor[0]->descriere)){
        print '<p class="autor-descriere">'.$resursaAutor[0]->descriere.'</p>';
      } else {
        print '<p class="italic autor-descriere">Nici o descriere gasita</p>';
      }
    ?>
    <?php
      if(isset($resursaAutor[0]->sursaDescriere)){
        print '<h5><a class="italic autor-detalii" target="_blank" href="'.$resursaAutor[0]->sursaDescriere.'">Click pentru mai multe detalii</a></h5>';
      }      
    ?>
  </section>
  <section class="width60 autor-section-right">
      <?php
        // while($rowCarti = mysqli_fetch_array($resursaCarti)){
        foreach($resursaCarti as $rowCarti){
          $idCarte = parse_url($rowCarti->idCarte)["fragment"];
          print '<div class="card card-style">';
          $adresaImg = "../assets/covers/".$idCarte.".jpg";
          $faraImg = "../assets/covers/no-cover.jpg";
          if(file_exists($adresaImg)){
            print '<img class="card-img-top" src="'.$adresaImg.'" alt="book-cover">';
          } else {
            print '<img class="card-img-top" src="'.$faraImg.'" alt="book-cover" />';
          }
          print '
            <div class="card-body">
              <h6 class="card-title">'.$rowCarti->titlu.'</h6>
              <p class="card-text">- de <i>'.$rowCarti->numeAutor.'</i><br>
              Pret: '.$rowCarti->pret.' lei</p>
              <a class="btn btn-primary firstPage-detalii-btn" href="'.$cartePath.'?id_carte='.$idCarte.'">Detalii</a>
            </div>
          </div>';
        }
      ?>
  </section>

</div>

<?php include($footer); ?>
