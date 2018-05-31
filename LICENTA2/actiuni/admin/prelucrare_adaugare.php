<?php
    $path = "/licenta2";
    $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";
    
    $autorizare  = $root . '/admin/componenteAdmin/autorizareAdmin.php';
    $headerAdmin = $root . '/admin/componenteAdmin/headerAdmin.php';
    $footerAdmin    = $root . '/admin/componenteAdmin/footerAdmin.php';
    $adaugare = $path . '/admin/componenteAdmin/adaugare.php';
    
    
    include($autorizare);
    include($headerAdmin);
    
    require '../../vendor/autoload.php';    
    $client = new EasyRdf_Sparql_Client("http://localhost:7200/repositories/librarie_licenta", "http://localhost:7200/repositories/librarie_licenta/statements");
    
    print "<div class='admin-main-content prelucrare-adaugare-content'>";
    if(isset($_POST['adauga_domeniu'])){
      $idDomeniu = ucwords($_POST['domeniu_nou']);      
      if($_POST['domeniu_nou'] == ''){
        print 'Trebuie sa completezi numele de domeniu!<br/> <a href="'.$adaugare.'">Inapoi</a>';
        exit;
      }
      $sql = 'PREFIX c: <http://chinde.ro#>
        select ?idDomeniu ?numeDomeniu where {
          GRAPH c:Domenii {
            ?idDomeniu c:numeDomeniu "'.$idDomeniu.'"
          }
        }';
      $resursa = $client->query($sql);
      $rows = 0;
      foreach($resursa as $row){
        $rows += 1;
      }
      if($rows != 0){
        print "Domeniul <b>".$idDomeniu."</b> exista deja in baza de date!<br> <a href='".$adaugare."'>Inapoi</a>";
        exit;
      }

      $insert = 'PREFIX c: <http://chinde.ro#>
        insert data {
          GRAPH c:Domenii {
            c:'.$idDomeniu.' c:numeDomeniu "'.$idDomeniu.'";
            a c:Domeniu.
          }
        }';
      
      $client->update($insert);
      print "Domeniul <b>".$idDomeniu."</b> a fost adaugat in baza de date!<br/> <a href='".$adaugare."'>Inapoi</a>";
      exit;
    }

    if(isset($_POST['adauga_autor'])){
      if($_POST['autor_nou'] == ''){
        print 'Trebuie sa completezi numele de autor!<br/> <a href="'.$adaugare.'">Inapoi</a>';
        exit;
      }
      $sql = 'PREFIX c: <http://chinde.ro#>
        select ?idAutor ?descriere ?sursaDescriere where {
          GRAPH c:Autori {
            ?idAutor c:numeAutor "'.$_POST['autor_nou'].'";
            OPTIONAL {
              ?idAutor c:descriere ?descriere.
              ?idAutor c:sursaDescriere ?sursaDescriere.
            }
          }
        }';
      $resursa = $client->query($sql);
      $rows = 0;
      foreach($resursa as $row){
        $rows += 1;
      }

      if($rows != 0){
        print "Autorul <b>".$_POST['autor_nou']."</b> exista deja in baza de date!<br> <a href='".$adaugare."'>Inapoi</a>";
        exit;
      }

      $idAutorStr = explode(' ', $_POST['autor_nou']);
      $idAutor = array_pop($idAutorStr);

      if($_POST['autor_descriere_nou'] !== ''){
        $descriere = 'c:descriere "'.$_POST['autor_descriere_nou'].'";';
        $sursaDescriere = 'c:sursaDescriere "'.$_POST['sursa_descriere'].'";';
      } else {
        $descriere = '';
        $sursaDescriere = '';
      }
      
      $sql = 'PREFIX c: <http://chinde.ro#>
        insert data {
          GRAPH c:Autori {
            c:'.$idAutor.'
              c:numeAutor "'.$_POST['autor_nou'].'";
              '.$descriere.'
              '.$sursaDescriere.'
            a c:Autor.
          }
        }';
      $client->update($sql);
      print "Autorul <b>".$_POST['autor_nou']."</b> a fost adaugat in baza de date!<br/> <a href='".$adaugare."'>Inapoi</a>";
      exit;
    }

    if(isset($_POST['adauga_carte'])){
      ChromePhp::log($_POST);
      
      if($_POST['titlu'] == '' || $_POST['pret'] == ''){
        print 'Titlul sau pretul sunt goale!<br/> <a href="'.$adaugare.'">Inapoi</a>';
        exit;
      }
      if(!is_numeric($_POST['pret'])){
        print 'Campul Pret trebuie sa fie de tip numeric! (scrieti <b>1000</b> in loc de <b>1000 lei</b>)<br/><a href="'.$adaugare.'">Inapoi</a>';
        exit;
      }

      $sql = 'PREFIX c: <http://chinde.ro#>
      select ?idCarte ?domeniu ?pret ?data ?descriere where {
        GRAPH c:Carti {
          ?idCarte c:domeniu ?domeniu.
          ?idCarte c:autor c:'.$_POST['id_autor'].'.
          ?idCarte c:titlu "'.$_POST['titlu'].'".
          ?idCarte c:pret ?pret.
          ?idCarte c:data ?data.
          OPTIONAL {?idCarte c:descriere ?descriere}
        }
      }';
      $resursa = $client->query($sql);
      $rows = 0;
      foreach($resursa as $row){
        $rows += 1;
      }
      if($rows != 0){
        print "Aceasta carte exista deja in baza de date!<br> <a href='".$adaugare."'>Inapoi</a>";
        exit;
      }
      $idCarteStr = ucwords($_POST['titlu']);
      $idCarte = str_replace(' ', '', $idCarteStr);
      if($_POST['descriere'] !== ''){
        $descriere = 'c:descriere "'.$_POST['descriere'].'";';
      } else {
        $descriere = '';
      }
      $date = getdate();
      $dd = $date['mday'];
      $mm = $date['mon'];
      $yyyy = $date['year'];

      $insert = 'PREFIX c: <http://chinde.ro#>
      insert data {
        GRAPH c:Carti {
          c:'.$idCarte.'
            c:domeniu c:'.$_POST['id_domeniu'].';
            c:autor c:'.$_POST['id_autor'].';
            c:titlu "'.$_POST['titlu'].'";
            c:pret '.$_POST['pret'].';
            c:data "'.$yyyy.'-'.$mm.'-'.$dd.'";
            '.$descriere.'
            a c:Carte.
        }
      }';
      $client->update($insert);
      print "Cartea a fost adaugat in baza de date!<br/> <a href='".$adaugare."'>Inapoi</a>";
      exit;
    }
    print '</div>';
    include($footerAdmin);
?>