<?php 
    $path = "/licenta2";
    $root = $_SERVER['DOCUMENT_ROOT']."/licenta2";
  
    $autorizare  = $root . '/admin/componenteAdmin/autorizareAdmin.php';
    $headerAdmin = $root . '/admin/componenteAdmin/headerAdmin.php';
    $footerAdmin    = $root . '/admin/componenteAdmin/footerAdmin.php';
    $adminModifStergPath = $path . '/admin/componenteAdmin/modificare_stergere.php';

    include($autorizare);
    include($headerAdmin);

    // modificare nume domeniu
    if(isset($_POST['modifica_domeniu'])) {
      if($_POST['nume_domeniu'] == '') {
        print "<div class='admin-main-content'>Nu ati introdus numele domeniului!</div>";
      } else {
        $sql = "UPDATE domenii SET nume_domeniu='".$_POST['nume_domeniu']."' WHERE id_domeniu=".$_POST['id_domeniu'];
        mysqli_query($con, $sql);
        header("Location:".$adminModifStergPath);
      }
    }

    // sterge domeniu
    if(isset($_POST['sterge_domeniu'])) {
      $sql = "DELETE FROM domenii WHERE id_domeniu=".$_POST['id_domeniu'];
      mysqli_query($con, $sql);
      header("Location:".$adminModifStergPath);
    }

    // modificare nume autor
    if(isset($_POST['modifica_autor'])) {
      if($_POST['nume_autor'] == '') {
        print "<div class='admin-main-content'>Nu ati introdus numele autorului!</div>";
      } else {
        $sql = "UPDATE autori SET nume_autor='".$_POST['nume_autor']."' WHERE id_autor=".$_POST['id_autor'];
        mysqli_query($con, $sql);
        header("Location:".$adminModifStergPath);
      }
    }

    // sterge autor
    if(isset($_POST['sterge_autor'])) {
      $sql = "DELETE FROM autori WHERE id_autor=".$_POST['id_autor'];
      mysqli_query($con, $sql);
      header("Location:".$adminModifStergPath);
    }

    // modificare carte
    if(isset($_POST['modifica_carte'])){
      if($_POST['titlu'] == ''){
        print "<div class='admin-main-content'>Nu ati introdus titlul!</div>";
      } else if($_POST['pret'] == ''){
        print "<div class='admin-main-content'>Nu ati introdus pretul!</div>";
      } else if(!is_numeric($_POST['pret'])){
        print "<div class='admin-main-content'>Pretul trebuie sa fie numeric! Scrieti <b>1000</b> nu <b>1000 lei</b>.</div>";
      } else {
        $sql = "UPDATE carti SET id_domeniu=".$_POST['id_domeniu'].", id_autor=".$_POST['id_autor'].", titlu=".$_POST['titlu'].", descriere=".$_POST['descriere'].", pret=".$_POST['pret']." WHERE id_carte=".$_POST['id_carte'];
        mysqli_query($con, $sql);
        header("Location:".$adminModifStergPath);
      }
    }

    // sterge carte
    if(isset($_POST['sterge_carte'])) {
      $sql = "DELETE FROM domenii WHERE id_carte=".$_POST['id_carte'];
      mysqli_query($con, $sql);
      header("Location:".$adminModifStergPath);
    }
?>

<?php include($footerAdmin); ?>