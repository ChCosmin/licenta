<?php 
<!-- actiuni/admin/f_autorizare.php -->
$sql = "SELECT * FROM admin WHERE admin_nume='".$_SESSION['nume_admin']."' AND admin_parola='".$_SESSION['parola_encriptata']."'";

<!-- actiuni/admin/login.php -->
$sql = "SELECT * FROM admin WHERE admin_nume='".$_POST['nume']."' AND admin_parola='".$parolaEcriptata."'";

<!-- actiuni/admin/prelucrare_adaugare.php -->
$sql = "SELECT * FROM domenii WHERE nume_domeniu='".$_POST['domeniu_nou']."'";
$sql = "INSERT INTO domenii (nume_domeniu) VALUES ('".$_POST['domeniu_nou']."')";

$sql = "SELECT * FROM autori WHERE nume_autor='".$_POST['autor_nou']."'";
$sql = "INSERT INTO autori (nume_autor, descriere, sursa_descriere) VALUES ('".$_POST['autor_nou']."','".$_POST['autor_descriere_nou']."','".$_POST['sursa_descriere']."')";

$sql = "SELECT * FROM carti WHERE id_autor='".$_POST['id_autor']."' AND titlu='".$_POST['titlu']."'";
$sql = "INSERT INTO carti (id_domeniu, id_autor, titlu, descriere, pret) VALUES ('".$_POST['id_domeniu']."','".$_POST['id_autor']."','".$_POST['titlu']."','".$_POST['descriere']."','".$_POST['pret']."')";

<!-- actiuni/admin/prelucrare_comenzi.php -->
$sql = "UPDATE tranzactii SET comanda_onorata=1 WHERE id_tranzactie=".$_POST['id_tranzactie'];
$sqlTranzactii = "DELETE FROM tranzactii WHERE id_tranzactie=".$_POST['id_tranzactie'];
$sqlCarti = "DELETE FROM vanzari WHERE id_tranzactie=".$_POST['id_tranzactie'];

<!-- actiuni/admin/prelucrare_moderare_comentarii.php -->
$sql = "UPDATE comentarii SET nume_utilizator='".$_POST['nume_utilizator']."', adresa_email='".$_POST['adresa_email']."', comentariu='".$_POST['comentariu']."' WHERE id_comentariu=".$_POST['id_comentariu'];
$sql = "DELETE FROM comentarii WHERE id_comentariu=".$_POST['id_comentariu'];
$sql = "UPDATE admin SET ultimul_comentariu_moderat=".$_POST['ultimul_id'];

<!-- actiuni/admin/prelucrare_modificare_stergere.php -->
$sql = "UPDATE domenii SET nume_domeniu='".$_POST['nume_domeniu']."' WHERE id_domeniu=".$_POST['id_domeniu'];
$sql = "DELETE FROM domenii WHERE id_domeniu=".$_POST['id_domeniu'];
$sql = "UPDATE autori SET nume_autor='".$_POST['nume_autor']."' WHERE id_autor=".$_POST['id_autor'];
$sql = "DELETE FROM autori WHERE id_autor=".$_POST['id_autor'];
$sql = "UPDATE carti SET id_domeniu=".$_POST['id_domeniu'].", id_autor=".$_POST['id_autor'].", titlu=".$_POST['titlu'].", descriere=".$_POST['descriere'].", pret=".$_POST['pret']." WHERE id_carte=".$_POST['id_carte'];
$sql = "DELETE FROM domenii WHERE id_carte=".$_POST['id_carte'];

<!-- actiuni/adauga_comentariu.php -->
$insert = "INSERT INTO comentarii(id_carte, nume_utilizator, adresa_email, comentariu) VALUES (".$_POST['id_carte'].",'".$numeFaraTags."','".$emailFaraTags."','".$comentariuFaraTags."');";


// actiuni/prelucrare.php 
    $sqlTranzactie = 'INSERT INTO tranzactii (nume_cumparator, adresa_cumparator) VALUES ("'.$_POST['nume'].'","'.$_POST['adresa'].'")';
    $sqlVanzare = "INSERT INTO vanzari VALUES ('".$id_tranzactie."', '".$_SESSION['id_carte'][$i]."', '".$_SESSION['nr_buc'][$i]."')";
  // -------------------------------
    $sqlTranzactie = 'PREFIX c: <http://chinde.ro#>
    insert data {
        GRAPH c:Tranzactii {
            c:T3
                c:data "10-10-2010"^^xsd:date;
                c:numeCumparator "AAA BBB CCC";
                c:adresaCumparator "str. Ciocarliei, Cluj";
                c:onorata 0;
                a c:Tranzactie.
        }
    }';
//  admin/componenteAdmin/adaugare.php
    $sql = "SELECT * FROM domenii ORDER BY nume_domeniu ASC";
    $sql = "SELECT * FROM autori ORDER BY nume_autor ASC";
  // -------------------------------
// admin/componenteAdmin/autorizareAdmin.php 
    $sql = "SELECT * FROM admin WHERE admin_nume='".$_SESSION['nume_admin']."' AND admin_parola='".$_SESSION['parola_encriptata']."'";
  // -------------------------------
//  admin/componenteAdmin/comenzi.php 
    $sqlNrTranzactii = "SELECT * FROM tranzactii WHERE comanda_onorata=0";
    $sqlTranzactii = "SELECT id_tranzactie, date_format(data_tranzactie,'%d-%n-%Y') as data_tranzactie, nume_cumparator, adresa_cumparator from tranzactii where comanda_onorata=0";
    $sqlCarti = "SELECT titlu, nume_autor, pret, nr_buc FROM vanzari, carti, autori WHERE carti.id_carte=vanzari.id_carte AND carti.id_autor=autori.id_autor AND id_tranzactie=".$rowTranzactie['id_tranzactie'];
  // -------------------------------
    $sqlNrTranzactii = '';
    $sqlTranzactii = 'PREFIX c: <http://chinde.ro#>
    select ?idTranzactie ?dataTranzactie ?numeCumparator ?adresaCumparator where {
        GRAPH c:Tranzactii { 
            ?idTranzactie c:data ?dataTranzactie.
            ?idTranzactie c:numeCumparator ?numeCumparator.
            ?idTranzactie c:adresaCumparator ?adresaCumparator.
            ?idTranzactie c:onorata 0
        }
    }';
    $sqlCarte = 'PREFIX c: <http://chinde.ro#>
    select ?titlu ?numeAutor ?pret ?nrBuc where {
        GRAPH c:Vanzari { 
            ?idVanzare c:carte ?idCarte.
            ?idVanzare c:bucati ?nrBuc
        }
        GRAPH c:Carti { 
            ?idCarte c:titlu ?titlu. 
            ?idCarte c:autor ?idAutor.
            ?idCarte c:pret ?pret.
        }
        GRAPH c:Autori { ?idAutor c:numeAutor ?numeAutor }
    }';
// admin/componenteAdmin/formulare_moderare_opinii.php
    $sql = "SELECT * FROM comentarii WHERE id_comentariu=".$_POST['id_comentariu'];
  // -------------------------------
    $sql = '';
// admin/componenteAdmin/formulare_modificare_stergere.php 
    $sql = "SELECT nume_domeniu FROM domenii WHERE id_domeniu='".$_POST['id_domeniu']."'";
    $sql = "SELECT titlu, nume_autor FROM carti, autori, domenii WHERE carti.id_domeniu=domenii.id_domeniu AND carti.id_autor=autori.id_autor AND domenii.id_domeniu=".$_POST['id_domeniu'];
    $sqlNumeDomeniu = "SELECT nume_domeniu FROM domenii where id_domeniu=".$_POST['id_domeniu'];
    
    $sql = "SELECT nume_autor FROM autori WHERE id_autor='".$_POST['id_autor']."'";
    $sql = "SELECT titlu FROM carti, autori WHERE carti.id_autor=autori.id_autor AND carti.id_autor=".$_POST['id_autor'];
    $sqlNumeAutor = "SELECT nume_autor FROM autori WHERE id_autor=".$_POST['id_autor'];
    
    $sqlCarte = "SELECT * FROM carti WHERE titlu='".$_POST['titlu']."' AND id_autor=".$_POST['id_autor'];
  // -------------------------------
    $sql = 'PREFIX c: <http://chinde.ro#>
    select ?numeDomeniu where {
        GRAPH c:Domenii { ?idDomeniu c:numeDomeniu ?numeDomeniu. filter (?idDomeniu=c:Poezii) }
    }';
    $sql = 'PREFIX c: <http://chinde.ro#>
    select ?titlu ?numeAutor where {
        GRAPH c:Carti { 
            ?idCarte c:domeniu ?idDomeniu. 
            ?idCarte c:autor ?idAutor.
            ?idCarte c:titlu ?titlu.
        }
        GRAPH c:Autori { ?idAutor c:numeAutor ?numeAutor }
        GRAPH c:Domenii { ?idDomeniu c:numeDomeniu ?numeDomeniu. filter(?idDomeniu=c:Poezii)}
    }';
    $sqlNumeDomeniu = 'PREFIX c: <http://chinde.ro#>
    select ?numeDomeniu where {
        GRAPH c:Domenii { ?idDomeniu c:numeDomeniu ?numeDomeniu. filter (?idDomeniu=c:Poezii) }
    }';
    $sql = 'PREFIX c: <http://chinde.ro#>
    select ?numeAutor where {
        GRAPH c:Autori { ?idAutor c:numeAutor ?numeAutor. filter(?idAutor=c:Eminescu) }
    }';
    $sql = 'PREFIX c: <http://chinde.ro#>
    select ?titlu {
        GRAPH c:Carti { 
            ?idCarte c:titlu ?titlu. 
            ?idCarte c:autor ?idAutor.
            filter (?idCarte=c:Poezii)
        }
        GRAPH c:Autori { ?idAutor c:numeAutor ?numeAutor }
    }';
// admin/componenteAdmin/modificare_stergere.php
    $sql = "SELECT * FROM domenii ORDER BY nume_domeniu ASC";
    $sql = "SELECT * FROM autori ORDER BY nume_autor ASC";
  // -------------------------------
    $sql = 'PREFIX c: <http://chinde.ro#>
    select distinct * where {
        GRAPH c:Domenii { ?idDomeniu c:numeDomeniu ?numeDomeniu }
    }  order by ?numeDomeniu';
    $sql = '';
    // nu stiu cum sa selecte * 
// admin/componenteAdmin/opinii.php
    $sql = "SELECT * FROM comentarii, admin, carti, autori WHERE id_comentariu>admin.ultimul_comentariu_moderat AND carti.id_carte=comentarii.id_carte AND carti.id_autor=autori.id_autor ORDER BY id_comentariu ASC";
  // -------------------------------
    // nu stiu cum sa select * 
//  componente/admin.php 
    $selectAutor = "SELECT nume_autor, descriere, sursa_descriere FROM autori WHERE id_autor=".$id_autor;
    $selectCarti = "SELECT id_carte, titlu, pret, nume_autor FROM carti, autori WHERE carti.id_autor=".$id_autor." AND carti.id_autor=autori.id_autor";
  // -------------------------------
    $selectAutor = 'PREFIX c: <http://chinde.ro#>
    select ?numeAutor ?descriere ?sursaDescriere where {
        GRAPH c:Autori { 
            ?x c:numeAutor ?numeAutor. 
            ?x c:descriere ?descriere. 
            ?x c:sursaDescriere ?sursaDescriere. 
            filter (?x = c:Eminescu) 
        }
    }';
    // c:Eminescu ii variabila, nu stiu cum sa afisez pt unul care nu are c:descriere
    $selectCarti = 'PREFIX c: <http://chinde.ro#>
    select ?idCarte ?titlu ?pret ?numeAutor where {
        GRAPH c:Carti { 
            ?idCarte c:titlu ?titlu. 
            ?idCarte c:pret ?pret.
            ?idCarte c:autor ?z
            filter (?z = c:Eminescu)
        }
        GRAPH c:Autori { ?z c:numeAutor ?numeAutor }
    }';
    // c:Emnescu ii variabila
// componente/carte.php
    $select = "SELECT titlu, nume_autor, carti.descriere, pret FROM carti, autori WHERE id_carte=".$id_carte." AND carti.id_autor=autori.id_autor";
    $selectComentarii = "SELECT * FROM comentarii WHERE id_carte=".$id_carte;
  // -------------------------------
    $select = 'PREFIX c: <http://chinde.ro#>
    select ?titlu ?numeAutor ?descriereCarte ?pret where {
        GRAPH c:Carti { 
            ?x c:titlu ?titlu. 
            ?x c:autor ?z. 
            ?x c:descriere ?descriereCarte. 
            ?x c:pret ?pret. 
            filter ( ?x = c:Poezii2) 
        }
        GRAPH c:Autori { ?z c:numeAutor ?numeAutor }
    }';
    // c:Poezii2 ii variabila

    $selectComentarii = '';
//  componente/cautare.php
    $sql = "SELECT id_autor, nume_autor FROM autori WHERE nume_autor LIKE '%".$cuvant."%'";
    $sql2 = "SELECT id_carte, titlu FROM carti WHERE titlu LIKE '%".$cuvant."%'";
    $sql3 = "SELECT id_carte, titlu, descriere FROM carti WHERE descriere LIKE '%".$cuvant."%'";
  // -------------------------------
    $sql = 'PREFIX c: <http://chinde.ro#>
    select ?idAutor ?numeAutor where {
        GRAPH c:Autori { ?idAutor c:numeAutor ?numeAutor. filter regex(?numeAutor, "mit", "i")}
    }';
    // mit ii variabila

    $sql2 = 'PREFIX c: <http://chinde.ro#>
    select ?idCarte ?titlu where {
        GRAPH c:Carti { ?idCarte c:titlu ?titlu. filter regex(?titlu, "zi", "i")}
    }';
    // zi ii variabila

    $sql3 = 'PREFIX c: <http://chinde.ro#>
    select ?idCarte ?titlu ?descriere where {
        GRAPH c:Carti { ?idCarte c:titlu ?titlu. ?idCarte c:descriere ?descriere. filter regex(?descriere, "zi", "i")}
    }';
    // zi ii variabila
// componente/domeniu.php
  $selectDomeniu = "SELECT nume_domeniu FROM domenii WHERE id_domeniu=".$id_domeniu;
  $autorQ = "SELECT id_autor FROM autori WHERE nume_autor='".$row['nume_autor']."'";
  // -------------------------------
  $selectDomeniu = 'PREFIX c: <http://chinde.ro#>
  select ?numeDomeniu where {
      GRAPH c:Domenii { c:Poezii c:numeDomeniu ?numeDomeniu }
  }'; 
  // ^^^ c:Poezii variabila
  $autorQ = 'PREFIX c: <http://chinde.ro#>
  select ?idAutor where {
      GRAPH c:Autori { ?idAutor c:numeAutor "Mihai Eminescu" }
  }';
  // ^^^ "Mihai Eminescu" ii variabila
// componente/firstPage.php 
  $select = "SELECT id_carte, titlu, nume_autor, pret FROM carti, autori WHERE carti.id_autor=autori.id_autor ORDER BY data LIMIT 0,8";
  $autorQ = "SELECT id_autor FROM autori WHERE nume_autor='".$row['nume_autor']."'";
  $selectVanzari = "SELECT id_carte, sum(nr_buc) AS bucatiVandute FROM vanzari GROUP BY id_carte ORDER BY bucatiVandute DESC LIMIT 0,6";
  $selectCarte = "SELECT titlu, nume_autor, pret FROM carti, autori WHERE carti.id_autor=autori.id_autor AND id_carte=".$rowVanzari['id_carte'];
  $autorQ = "SELECT id_autor FROM autori WHERE nume_autor='".$rowCarte['nume_autor']."'";
  // -------------------------------
  $select = 'PREFIX c: <http://chinde.ro#>
  select distinct ?idCarte ?titlu ?numeAutor ?pret where { 
      GRAPH c:Carti { 
          ?idCarte c:pret ?pret. 
          ?idCarte c:titlu ?titlu. 
          ?idCarte c:autor ?x 
      }
      GRAPH c:Autori { ?x c:numeAutor ?numeAutor}
  } order by ???'

  $autor! = 'PREFIX c: <http://chinde.ro#>
  select ?idAutor where { 
      GRAPH c:Autori {?idAutor ?y $numeAutor}
  }' ($numeAutor = "Mihai Eminescu");

  $selectVanzari = 'PREFIX c: <http://chinde.ro#>
  select distinct ?idCarte (sum(?nrBuc) as ?bucatiVandute) where {
      GRAPH c:Vanzari { ?idCarte c:bucati ?nrBuc }
  } group by ?idCarte order by desc(?bucatiVandute) limit 6'

  $selectCarte = 'PREFIX c: <http://chinde.ro#>
  select ?titlu ?numeAutor ?pret where {
      GRAPH c:Carti { ?x c:titlu ?titlu. ?x c:pret ?pret. ?x c:autor ?z }
      GRAPH c:Autori { ?z c:numeAutor ?numeAutor }
      filter(?x=c:Hamlet)
  }' 
  // ^^^ dar nu inteleg de ce --- c:Hamlet va fi variabila 

  $autorQ = 'PREFIX c: <http://chinde.ro#>
  select ?idAutor where {
      GRAPH c:Autori { ?idAutor c:numeAutor ?z }
      filter (?z = "Mihai Eminescu")
  }'
  // ^^^ "Mihai Eminescu" ii variabila

// componente/meniuDomenii.php
  $domenii = "SELECT * FROM domenii ORDER BY nume_domeniu ASC";
  // -------------------------------
  $domenii = 'PREFIX c: <http://chinde.ro#>
  select distinct * where { GRAPH c:Domenii { ?x c:numeDomeniu ?z }} order by ?z'
?>
