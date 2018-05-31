<?php
  $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";

  $autorizare  = $root . '/admin/componenteAdmin/autorizareAdmin.php';
  $headerAdmin = $root . '/admin/componenteAdmin/headerAdmin.php';
  $footerAdmin    = $root . '/admin/componenteAdmin/footerAdmin.php';
  $prelucrareModifcStergere = $path . '/actiuni/admin/prelucrare_modificare_stergere.php';
  
  require '../../vendor/autoload.php';
  $client = new EasyRdf_Sparql_Client("http://localhost:7200/repositories/librarie_licenta");

  include($autorizare);
  include($headerAdmin);

  print '<div class="admin-main-content admin-modif-sterge-content">';

  //modificare nume domeniu
  if(isset($_POST['modifica_domeniu'])){
    $sql = 'PREFIX c: <http://chinde.ro#>
      select ?numeDomeniu where {
        GRAPH c:Domenii {
          c:'.$_POST['id_domeniu'].' c:numeDomeniu ?numeDomeniu
        }
      }';
    $resursa = $client->query($sql);
   
    print "
    <h1>Modifica nume domeniu</h1>
    <form action='".$prelucrareModifcStergere."' method='POST'>
      <input type='text' name='nume_domeniu' value='".$resursa[0]->numeDomeniu."' />
      <input type='hidden' name='id_domeniu' value='".$_POST['id_domeniu']."' />
      <input type='submit' name='modifica_domeniu' value='Modifica' />
    </form>";
  }

  //stergere domeniu
  if(isset($_POST['sterge_domeniu'])){
    $sql = 'PREFIX c: <http://chinde.ro#>
    select ?titlu ?numeAutor where {
        GRAPH c:Carti {
            ?idCarte c:domeniu c:'.$_POST['id_domeniu'].'.
            ?idCarte c:autor ?idAutor.
            ?idCarte c:titlu ?titlu.
        }
        GRAPH c:Autori {
            ?idAutor c:numeAutor ?numeAutor.
        }
    }';
    $sqlNumeDomeniu = 'PREFIX c: <http://chinde.ro#>
      select ?numeDomeniu where {
        GRAPH c:Domenii {
          c:'.$_POST['id_domeniu'].' c:numeDomeniu ?numeDomeniu
        }
      }';
    
    $resursa = $client->query($sql);
    $numeDomeniu = $client->query($sqlNumeDomeniu);
    $rows = 0;
    foreach($resursa as $row){
      $rows += 1;
    }
    if($rows > 0) {      
      print "<h2 class='formModifSterg-item-title'>Avertizare:</h2>
      <p class='italic'>Nu puteti sterge acest domeniu deoarece contine carti. Mutati cartile in alt domeniu sau stergeti-le inainte sa eliminati acest domeniu!</p>
      <p>Sunt ".$rows." carti care apartin domeniului <b>".$numeDomeniu[0]->numeDomeniu."</b>!</p>";      
      foreach($resursa as $row){
        print "<b>".$row->titlu."</b> de ".$row->numeAutor."<br />";
      }
    } else {
        print '
        <div class="formModifSterg-item">
          <h1>Esti sigur ca vrei sa stergi domeniul "<b>'.$numeDomeniu[0]->numeDomeniu.'</b>"?</h1>
          <form action="'.$prelucrareModifcStergere.'" method="POST">
            <input type="hidden" name="id_domeniu" value="'.$_POST['id_domeniu'].'" />
            <input class="btn btn-primary formModifSterg-item-btn" type="submit" name="sterge_domeniu" value="Sterge!" />
          </form>
        </div>';
      }
  }
  
  // modificare autor
  if(isset($_POST['modifica_autor'])){
    $sql = 'PREFIX c: <http://chinde.ro#>
      select ?numeAutor where {
        GRAPH c:Autori {
          c:'.$_POST['id_autor'].' c:numeAutor ?numeAutor
        }
      }';
    $numeAutor = $client->query($sql);
    print '
    <h1>Modifica nume autor</h1>
    <form action="'.$prelucrareModifcStergere.'" method="POST">
      <input type="text" name="nume_autor" value="'.$numeAutor[0]->numeAutor.'" />
      <input type="hidden" name="id_autor" value="'.$_POST['id_autor'].'" />
      <input type="submit" name="modifica_autor" value="Modifica" />
    </form>';

  }

  //stergere autor
  if(isset($_POST['sterge_autor'])){
    $sql = 'PREFIX c: <http://chinde.ro#>
      select ?titlu where {
        GRAPH c:Carti {
          ?idCarte c:titlu ?titlu.
          ?idCarte c:autor c:'.$_POST['id_autor'].'.
        }
      }';
    $sqlNumeAutor = 'PREFIX c: <http://chinde.ro#>
      select ?numeAutor where {
        GRAPH c:Autori {
          c:'.$_POST['id_autor'].' c:numeAutor ?numeAutor
        }
      }';

    $resursa = $client->query($sql);
    $numeAutor = $client->query($sqlNumeAutor);
    $nrCarti = 0;
    foreach($resursa as $row){
      $nrCarti += 1;
    }
    if($nrCarti > 0) {
      print "<p>Sunt ".$nrCarti." carti de acest autor in baza de date!</p>";
      foreach($resursa as $row){
        print $row->titlu."<br />";
      }
      print "<p>Nu puteti sterge acest autor!</p>";
    } else {        
      print '
      <div class="formModifSterg-item">
        <h1>Esti sigur ca vrei sa stergi autorul "<b>'.$numeAutor[0]->numeAutor.'</b>"?</h1>
        <form action="'.$prelucrareModifcStergere.'" method="POST">
          <input type="hidden" name="id_autor" value="'.$_POST['id_autor'].'" />
          <input type="submit" class="btn btn-primary formModifSterg-item-btn" name="sterge_autor" value="Sterge!" />
        </form>
      </div>';
    }
  }

  //modificare carte
  if(isset($_POST['modifica_carte'])){
    $sqlCarte = 'PREFIX c: <http://chinde.ro#>
    select ?idCarte ?descriere ?pret ?data ?idDomeniu where {
      GRAPH c:Carti {
        ?idCarte c:titlu "'.$_POST['titlu'].'".
        ?idCarte c:autor c:'.$_POST['id_autor'].'.
        ?idCarte c:domeniu ?idDomeniu.
        ?idCarte c:pret ?pret.
        ?idCarte c:data ?data
        OPTIONAL { ?idCarte c:descriere ?descriere }
      }
    }';
    $rowCarte = $client->query($sqlCarte);
    $rows = 0;
    foreach($rowCarte as $row){
      $rows += 1;
    }
    if($rows == 0){
      print "Aceasta carte nu exista in baza de date";
    } else {
    ?>
    <div class="formModifSterg-item">
      <h1>Modificare carte "<?= $_POST['titlu'] ?>"</h1>
      <form class="width40 formModifSterg-form" action="<?=$prelucrareModifcStergere?>" method="POST">
        
        <div class="formModifSterg-form-item">
          <label class="width30" for="id_domeniu">Domeniu:</label>            
          <select class="width100" id="id_domeniu" name="id_domeniu">
            <?php
              $sql = 'PREFIX c: <http://chinde.ro#>
                select ?idDomeniu ?numeDomeniu where {
                  GRAPH c:Domenii {
                    ?idDomeniu c:numeDomeniu ?numeDomeniu
                  }
                } order by ?numeDomeniu';
              $resursa = $client->query($sql);
              foreach($resursa as $row){
                $idDomeniu = parse_url($row->idDomeniu)["fragment"];
                if($idDomeniu == parse_url($rowCarte[0]->idDomeniu)["fragment"]){
                  print "<option SELECTED value='".$idDomeniu."'>".$row->numeDomeniu."</option>";
                } else {
                  print "<option value='".$idDomeniu."'>".$row->numeDomeniu."</option>";
                }
              }
            ?>
          </select>
        </div>

        <div class="formModifSterg-form-item">
          <label class="width30" for="id_autor">Autor:</label>      
          <select class="width100" id="id_autor" name="id_autor">
            <?php 
              $sql = 'PREFIX c: <http://chinde.ro#>
                select ?idAutor ?numeAutor ?descriere ?sursaDescriere where {
                  GRAPH c:Autori {
                    ?idAutor c:numeAutor ?numeAutor.
                    OPTIONAL {
                      ?idAutor c:descriere ?descriere.
                      ?idAutor c:sursaDescriere ?sursaDescriere.
                    }
                  }
                } order by ?numeAutor';
              $resursa = $client->query($sql);
              foreach($resursa as $row){
                $idAutor = parse_url($row->idAutor)["fragment"];
                if($idAutor == parse_url($rowCarte[0]->idAutor)["fragment"]) {
                  print "<option SELECTED value='".$idAutor."'>".$row->numeAutor."</option>";
                } else {
                  print "<option value='".$idAutor."'>".$row->numeAutor."</option>";
                }
              } 
            ?>
          </select>          
        </div>

        <div class="formModifSterg-form-item">
          <label class="width30" for="titlu">Titlu:</label>
          <input class="width100" id="titlu" type="text" name="titlu" value="<?=$_POST['titlu']?>" />
        </div>

        <div class="formModifSterg-form-item">
          <?php if(isset($rowCarte[0]->descriere)){ ?>
          <label class="width30" for="descriere">Descriere:</label>
          <textarea class="width100" style="resize: none" id="descriere" name="descriere" rows="8"><?=$rowCarte[0]->descriere?></textarea>
          <?php } else { ?>
            <label class="width30" for="descriere">Descriere:</label>          
            <textarea class="width100" disabled placeholder="No description available"></textarea>
          <?php } ?>
        </div>

        <div class="formModifSterg-form-item">
          <label class="width30" for="pret">Pret:</label>
          <input class="width100" id="pret" type="text" name="pret" value="<?=$rowCarte[0]->pret?>" />
        </div>
        <div class="formModifSterg-form-item">        
          <label class="width30" for="id_carte">Id:</label>        
          <input class="width100" type="text" name="id_carte" id="id_carte" value="<?= parse_url($rowCarte[0]->idCarte)["fragment"]?>" />
        </div>
        <input type="submit" class="btn btn-primary formModifSterg-item-btn" name="modifica_carte" value="Modifica" />
      </form>
    </div>
    <?php 
    }
  }

  //sterge carte
  if(isset($_POST['sterge_carte'])) {
    $sqlCarte = 'PREFIX c: <http://chinde.ro#>
    select ?idCarte ?idAutor ?titlu ?descriere ?pret ?data ?idDomeniu where {
      GRAPH c:Carti {
        ?idCarte c:titlu "'.$_POST['titlu'].'".
        ?idCarte c:autor c:'.$_POST['id_autor'].'.
        ?idCarte c:domeniu ?idDomeniu.
        ?idCarte c:pret ?pret.
        ?idCarte c:data ?data
        OPTIONAL { ?idCarte c:descriere ?descriere }
      }
    }';
    $carte = $client->query($sqlCarte);
    $rows = 0;
    foreach($carte as $row){
      $rows += 1;
    }
    if($rows == 0) {
      print '
      <div class="formModifSterg-item">
        <h1>Sterge carte</h1>
        <i>Aceasta carte nu exista in baza de date</i>
      </div>';
    } else {
      print '
      <div class="formModifSterg-item">
        <h1>Esti sigur ca vrei sa stergi cartea "<b>'.$_POST['titlu'].'</b>"?</h1>
        <form action="'.$prelucrareModifcStergere.'" method="POST">
          <input type="hidden" name="id_carte" value="'.parse_url($carte[0]->idCarte)['fragment'].'" />
          <input type="submit" class="btn btn-primary formModifSterg-item-btn" name="sterge_carte" value="Sterge!" />
        </form>
      </div>';
    }
  }
  print "</div>"; 
  include($footerAdmin);
?>


  