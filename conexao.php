<?php
$db_hostname = "localhost";
$db_bancodedados = "crud_clientes";
$db_usuario = "root";
$db_senha = "";

$mysqli = new mysqli($db_hostname, $db_usuario, $db_senha, $db_bancodedados);
if($mysqli->connect_errno){
    echo "falha ao conectar . (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
?>