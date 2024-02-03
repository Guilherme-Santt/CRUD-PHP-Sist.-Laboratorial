<?php
$alert = "";
include('../views/conexao.php');
if(count($_POST) > 0){
    $nomeconvenio = $_POST['nome'];

    if(empty($nomeconvenio))
        $alert = "NOME DO CONVENIO OBRIGATÓRIO";

    if(strlen ($nomeconvenio) < 3 || strlen ($nomeconvenio) > 100 )
        $alert = "NOME DO MÉDICO INCORRETO";
    
    if($alert){
        die($alert);
    }else{
        $query_verify = $mysqli->query("SELECT * FROM convenio WHERE nome = '$nomeconvenio'");
        $verify = $query_verify->fetch_assoc();
        if($verify){
            die("CONVÊNIO JÁ CADASTRADO");
        }else{
            $query = $mysqli->query("INSERT INTO convenio (nome) VALUES ('$nomeconvenio')");
            if($query)
                header("location: ../views/listagem_usuarios.php");
        }
    }
}

?>