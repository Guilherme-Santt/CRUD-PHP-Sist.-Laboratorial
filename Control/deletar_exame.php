<?php
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        die('Você não está logado!' . '<a href="../views/index_login.php">Clique aqui para logar</a>');
    }    
}
include('../views/conexao.php');
$id = intval($_GET['id']);
$sql_code = "DELETE FROM exames WHERE exameid = '$id'";
$query_code = $mysqli->query($sql_code);
    if($query_code) 
        header("location: ../views/listagem_exames.php");
?>


