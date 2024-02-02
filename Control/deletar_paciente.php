<?php
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("location: ../views/index_login.php");
    }    
}
include('../views/conexao.php');
$id = intval($_GET['id']);
$sql_code = "DELETE FROM pacientes WHERE id = '$id'";
$query_code = $mysqli->query($sql_code) or die($mysqli->error);
    if($query_code)
        header("location: ../views/listagem_pacientes.php");  
?>