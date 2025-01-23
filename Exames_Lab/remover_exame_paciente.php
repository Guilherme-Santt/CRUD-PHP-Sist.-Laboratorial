<?php
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['usuario'])){
        header("location: ../views/index_login.php");
    }    
}
$id = intval($_GET['id']);
include('../Control/conexao.php');
$sql_pacientes_exames = "SELECT * FROM pacientes_exames WHERE id = '$id'";
$query_p_e            = $mysqli->query($sql_pacientes_exames);
$id_paciente          = $query_p_e->fetch_assoc();
$id_paciente          = $id_paciente['paciente_id'];

$sql_remover = "DELETE FROM pacientes_exames WHERE id = '$id'";
$query_remover = $mysqli->query($sql_remover);
    if($query_remover)
        header("location: ../views/editar_paciente.php?id=$id_paciente");

?>