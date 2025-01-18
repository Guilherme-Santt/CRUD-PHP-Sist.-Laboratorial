<?php

include('../views/conexao.php');
$id = $_SESSION['usuario'];
// INFORMAÇÕES DE USUARIOS & QUANTIDADE DE USUARIOS

$sqlcode   = "SELECT * FROM clientes WHERE id = '$id'";
$query     = $mysqli->query($sqlcode);
$usuario   = $query->fetch_assoc();
$cont_user = $query->num_rows; 




?>