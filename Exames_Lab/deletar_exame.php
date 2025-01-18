<?php

include('../views/conexao.php');
$id = intval($_GET['id']);
$sql_code   = "DELETE FROM exames WHERE exameid = '$id'";
$query_code = $mysqli->query($sql_code);
    if($query_code) 
        header("location: ../Exames_Lab /listagem_exames.php");
?>