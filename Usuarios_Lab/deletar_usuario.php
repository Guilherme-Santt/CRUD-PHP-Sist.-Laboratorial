<?php

include('../Control/conexao.php');
$id = intval($_GET['id']);
$sucess = "";
// REMOVER USUARIO PUXANDO ID DO GET
$sql_code = "DELETE FROM clientes WHERE id = '$id'";
$query_code = $mysqli->query($sql_code) or die($mysqli->error);    
    if($query_code){
        $sucess = "Removido com sucesso";
        $_SESSION['sucess'] = $sucess;
        header("location: ../listagem_usuarios.php");
    }
?>