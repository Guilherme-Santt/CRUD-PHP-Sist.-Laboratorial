<?php

include('../views/conexao.php');
$id = intval($_GET['id']);
$sql_code = "DELETE FROM medicos WHERE id = '$id'";
$query_code = $mysqli->query($sql_code);
    if($query_code) 
        header("location: ../views/listagem_medicos.php");
?>

