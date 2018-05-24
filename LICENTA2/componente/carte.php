<?php 
  $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";

  $connect      = $root . '/componente/conectare.php';
  $header       = $root . '/componente/header.php';
  $footer       = $root . '/componente/footer.php';
  $adaugaComent = $root . '/actiuni/adauga_comentariu.php';
  $cartePath    = $root . '/componente/carte.php';
  session_start();
  include($connect);
  include($header); 

  require '../vendor/autoload.php';
  $client = new EasyRdf_Sparql_Client("http://localhost:7200/repositories/librarie_licenta");

  $id_carte = $_GET['id_carte'];
  // $select = "SELECT titlu, nume_autor, carti.descriere, pret FROM carti, autori WHERE id_carte=".$id_carte." AND carti.id_autor=autori.id_autor";
  $select = 'PREFIX c: <http://chinde.ro#>
  select ?titlu ?numeAutor ?descriereCarte ?pret where {
      GRAPH c:Carti { 
          ?idCarte c:titlu ?titlu. 
          ?idCarte c:autor ?idAutor. 
          ?idCarte c:descriere ?descriereCarte. 
          ?idCarte c:pret ?pret
          filter (?idCarte=c:'.$id_carte.') 
      }
      GRAPH c:Autori { ?idAutor c:numeAutor ?numeAutor }
  }';
  // $resursa = mysqli_query($con, $select);
  $resursa=$client->query($select);

  // $row = mysqli_fetch_array($resursa);
  //pusca deoarece unele carti nu au c:descriere
  ?>

<div class="main-content carte-content">
 
  <section class="carte-section-left">
    <div class="carte">
      <?php
        $adresaImg = "../assets/covers/".$id_carte.".jpg";
        $faraCoperta = "../assets/covers/no-cover.jpg";

        if(file_exists($adresaImg)){
          print '<img class="carte-coperta" src="'.$adresaImg.'" alt="book-cover" />';
        } else {
          print '<img class="carte-coperta" src="'.$faraCoperta.'" alt="book-cover" />';
        }
      ?>
      <div class="carte-detalii">
        <h2 class="carte-titlu italic"><?=$resursa[0]->titlu?></h2>
        <i>de <b><?=$resursa[0]->numeAutor?></b></i>
        <?php 
          if($resursa[0]->descriereCarte){
            print '<p class="carte-descriere"><b>"</b>'.$resursa[0]->descriereCarte.'<b>"</b></p>';
          } else {
            print '<p class="italic carte-descriere">Nici o descriere gasita</p>';
          }
        ?>      
        <form class="carte-cumpara" action="cos.php" method="POST">
          <input type="hidden" name="id_carte"   value="<?=$id_carte?>">
          <input type="hidden" name="titlu"      value="<?=$resursa[0]->titlu?>">
          <input type="hidden" name="nume_autor" value="<?=$resursa[0]->numeAutor?>">
          <input type="hidden" name="pret"       value="<?=$resursa[0]->pret?>">
          <input type="hidden" name="actiune"    value="adauga" />
          <h5 class="carte-pret italic">Pret: <?=$resursa[0]->pret?> lei</h5>
          <input class="btn btn-primary carte-cumpara-btn " type="submit" value="Cumpara acum!">
        </form>
      </div>
    </div>
    <div class="carte-adauga-coment">
      <h5 class="bold italic adauga-coment-titlu">Adauga opinia ta:</h5>
      <form class="carte-coment-box" action="../actiuni/adauga_comentariu.php" method="POST" id="x">
        <input id="nume_utilizator" class="coment-box-input" type="text" name="nume_utilizator" placeholder="Nume">
        <input id="adresa_email" class="coment-box-input" type="email" name="adresa_email" placeholder="Email">

        <span id="numeErr"class="width50 error"></span>
        <span id="emailErr" class="width50 error"></span>

        <textarea id="comentariu" class="width100 coment-box-textarea" name="comentariu" cols="45" placeholder="Adauga opinia ta despre carte" maxlength="1000"></textarea>
        <span id="comentErr" class="width100 error"></span>

        <input id="id_carte" type="hidden" name="id_carte" value="<?=$id_carte?>">
        <input id="submitComent" class="btn btn-primary coment-box-btn" type="submit" value="Adauga">
      </form>
    </div>
  </section>

  <section class="carte-section-right">
    <div class="comentarii">
      <h5 class="comentarii-titlu bold italic">Opiniile cititorilor</h5 >
      <?php
        // $selectComentarii = "SELECT * FROM comentarii WHERE id_carte=".$id_carte;
        $selectComentarii = 'PREFIX c: <http://chinde.ro#>
        select ?idComent ?idCarte ?numeUtilizator ?email ?coment where {
            GRAPH c:Comentarii {
                ?idComent c:carte ?idCarte.
                ?idComent c:utilizator ?numeUtilizator.
                ?idComent c:emailUtilizator ?email.
                ?idComent c:comentariu ?coment.
                filter(?idCarte=c:'.$id_carte.')
            }
        }';
        // $resursaComentarii = mysqli_query($con, $selectComentarii);
        $resursaComentarii=$client->query($selectComentarii);
        
        // while($row = mysqli_fetch_array($resursaComentarii)){
        foreach($resursaComentarii as $row){
          print '<div class="comentariu">
            <a class="bold comentariu-user" href="mailto:'.$row->email.'">'.$row->numeUtilizator.'</a>
            <p class="comentariu-text">'.$row->coment.'</p>
          </div> ';
        }
      ?>
    </div>
  </section> 
</div>

<?php include($footer); ?>
