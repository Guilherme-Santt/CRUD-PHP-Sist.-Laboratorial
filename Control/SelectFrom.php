<?php
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        die('Você não está logado!' . '<a href="login.php">Clique aqui para logar</a>');
    }    
}
include('conexao.php');
$id = $_SESSION['usuario'];
// INFORMAÇÕES DE USUARIOS & QUANTIDADE DE USUARIOS
$sqlcode = "SELECT * FROM clientes WHERE id = '$id'";
$query = $mysqli->query($sqlcode);
$usuario = $query->fetch_assoc();
$cont_user = $query->num_rows; 
?>