<?php
$alert = "";
include('../views/conexao.php');
if(count($_POST) > 0){
    $nomeconvenio = $_POST['nome'];
    $codigo = ($_POST['codigo']);
    if(isset($codigo))
        strtolower($codigo);

    if(empty($nomeconvenio) || strlen ($nomeconvenio) < 3 || strlen ($nomeconvenio) > 100 )
        $alert = "NOME DO CONVÊNIO OBRIGATÓRIO";


    if(empty($codigo) || strlen ($codigo) < 3 || strlen ($codigo) > 3  )
        $alert = "CÓDIGO DO CONVÊNIO INCORRÉTO";

    if($alert){
        die($alert);
    }else{
        $query_verify = $mysqli->query("SELECT * FROM convenio WHERE nome = '$nomeconvenio' AND codigo = '$codigo'");
        $verify = $query_verify->fetch_assoc();
        if($verify){
            die("CONVÊNIO JÁ CADASTRADO");
        }else{
            $query = $mysqli->query("INSERT INTO convenio (nome, codigo) VALUES ('$nomeconvenio', '$codigo')") or die($mysqli->error);
            if($query)
                header("location: ../views/listagem_convenios.php");
        }
    }
}

?>