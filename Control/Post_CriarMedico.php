<?php
$alert = "";
include('../views/conexao.php');
if(count($_POST) > 0){
    $nomemedico = $_POST['nome'];
    $CRM = $_POST['CRM'];

    if(empty($nomemedico))
        $alert = "NOME DO MÉDICO OBRIGATÓRIO";

    if(strlen ($nomemedico) < 3 || strlen ($nomemedico) > 100 )
        $alert = "NOME DO MÉDICO INCORRETO";

    if(empty($CRM))
        $alert = "CRM DO MÉDICO OBRIGATÓRIO";
    
    if($alert){
        die($alert);
    }else{
        $query_verify = $mysqli->query("SELECT * FROM medicos WHERE nome = '$nomemedico' and CRM = '$CRM'");
        $verify = $query_verify->fetch_assoc();
        if($verify){
            die("MÉDICO JÁ CADASTRADO");
        }else{
            $query = $mysqli->query("INSERT INTO medicos (nome, CRM) VALUES ('$nomemedico','$CRM')");
            if($query)
                header("location: ../views/listagem_medicos.php");
        }
    }
}

?>