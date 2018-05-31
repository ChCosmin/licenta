<?php 
  $path = "/licenta2";
  $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";

  $autorizare  = $root . '/admin/componenteAdmin/autorizareAdmin.php';
  $headerAdmin = $root . '/admin/componenteAdmin/headerAdmin.php';
  $footerAdmin    = $root . '/admin/componenteAdmin/footerAdmin.php';
  $prelucrareComenzi = $path . '/actiuni/admin/prelucrare_comenzi.php';

  require '../../vendor/autoload.php';
  $client = new EasyRdf_Sparql_Client("http://localhost:7200/repositories/librarie_licenta");

  include($autorizare);
  include($headerAdmin);

  print '
    <div class="admin-main-content admin-comenzi-content">
      <h1>Comenzi</h1>
      <h4 class="italic">Comenzi onorate</h4>
  ';
  $sqlNrTranzactii = 'PREFIX c: <http://chinde.ro#>
    select * where {
        GRAPH c:Tranzactii {
            ?idTran c:data ?dataTran.
            ?idTran c:numeCumparator ?cumparator.
            ?idTran c:adresaCumparator ?adresaCump.
            ?idTran c:onorata ?comandaOnorata.
        } filter(?comandaOnorata = 0)
    }';
  $resursaNrTranzactii=$client->query($sqlNrTranzactii);
  $rows = 0;

  foreach($resursaNrTranzactii as $nrTranzactii) {
    $rows += 1;
  }

  if($rows === 0){
    print "<em>Momentan nu exista comenzi neonorate!</em>";
  }

  $sqlTranzactii = 'PREFIX c: <http://chinde.ro#>
    select ?idTranzactie ?dataTranzactie ?numeCumparator ?adresaCumparator where {
      GRAPH c:Tranzactii {
        ?idTranzactie c:data ?dataTranzactie.
        ?idTranzactie c:numeCumparator ?numeCumparator.
        ?idTranzactie c:adresaCumparator ?adresaCumparator.
        ?idTranzactie c:onorata 0.
      } 
    }';
  $resursaTranzactii=$client->query($sqlTranzactii);
  
  foreach($resursaTranzactii as $rowTranzactie){
    $idTranzactie = parse_url($rowTranzactie->idTranzactie)["fragment"];
  ?>
  <form class="comenzi-form" action="<?=$prelucrareComenzi?>" method="POST">
    <p class="no-margin"><em>Data comenzii:</em> <b><?=$rowTranzactie->dataTranzactie?></b></p>
    <p class="no-margin"><em>Client:</em> <b><?=$rowTranzactie->numeCumparator?></b></p> 
    <p class="no-margin"><em>Adresa client:</em> <b><?=$rowTranzactie->adresaCumparator?></b></p>
    <div class="comenzi-table">
      <div class="comenzi-table-row">
        <p class="width70 no-margin bold">Titlu / Autor</p>
        <p class="width10 no-margin bold center-text">Nr. buc</p>
        <p class="width10 no-margin bold center-text">Pret</p>
        <p class="width10 no-margin bold center-text">Total</p>
      </div>
      <?php 
        $sqlCarti = 'PREFIX c: <http://chinde.ro#>
        select ?titlu ?numeAutor ?pret ?nrBuc ((?pret * ?nrBuc) as $total) where {
            GRAPH c:Vanzari {
                ?idV c:carte ?idCarte.
                ?idV c:bucati ?nrBuc.
                ?idV c:idTranz c:'.$idTranzactie.'.
            }
            GRAPH c:Carti {
                ?idCarte c:titlu ?titlu.
                ?idCarte c:autor ?idAutor.
                ?idCarte c:pret ?pret.
                
            }
            GRAPH c:Autori {
                ?idAutor c:numeAutor ?numeAutor.
            }
        }';
        $sqlTotalGeneral = 'PREFIX c: <http://chinde.ro#>
        select (sum(?total) as ?totalGeneral) where {
            select ?titlu ?numeAutor ?pret ?nrBuc ((?pret * ?nrBuc) as $total) where 	 {
                GRAPH c:Vanzari {
                    ?idV c:carte ?idCarte.
                    ?idV c:bucati ?nrBuc.
                    ?idV c:idTranz c:'.$idTranzactie.'.
                }
                GRAPH c:Carti {
                    ?idCarte c:titlu ?titlu.
                    ?idCarte c:autor ?idAutor.
                    ?idCarte c:pret ?pret.
        
                }
                GRAPH c:Autori {
                    ?idAutor c:numeAutor ?numeAutor.
                }
            }    
        }';
        $resursaCarti = $client->query($sqlCarti);
        $totalGeneral = $client->query($sqlTotalGeneral);
        
        foreach($resursaCarti as $rowCarte){
          print '
            <div class="comenzi-table-row">
              <p class="width70 no-margin">'.$rowCarte->titlu.' de '.$rowCarte->numeAutor.' </p>
              <p class="width10 no-margin center-text">'.$rowCarte->nrBuc.'</p>
              <p class="width10 no-margin center-text">'.$rowCarte->pret.'</p>
          ';
          print '<p class="width10 no-margin center-text">'.$rowCarte->total.'</p>
            </div>';
        }
      ?>
      <div class="comenzi-table-row">
        <input type="hidden" name="id_tranzactie" value="<?=$idTranzactie?>" />
        <input type="submit" class="btn btn-primary comenzi-btn" name="comanda_onorata" value="Comanda onorata" />
        <input type="submit" class="btn btn-primary comenzi-btn" name="anuleaza_comanda" value="Anuleaza comanda" />  
        <p class="comenzi-totalComanda no-margin width100 bold">Total comanda: <?=$totalGeneral[0]->totalGeneral?> lei</p>
      </div>
    </div>   
  </form>
<?php } include($footerAdmin); ?>