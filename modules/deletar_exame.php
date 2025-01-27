<?php

include('../Control/conexao.php');
$id = intval($_GET['id']);
$sql_code   = "DELETE FROM exames WHERE exameid = '$id'";
$query_code = $mysqli->query($sql_code);
    if($query_code) 
        header("location: ../listagem_exames.php");
?>