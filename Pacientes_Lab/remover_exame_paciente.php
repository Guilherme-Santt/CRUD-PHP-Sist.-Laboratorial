<?php
include('../Control/conexao.php');
$id_exame = intval($_GET['id']);
$sql = "SELECT * FROM pacientes_exames WHERE id = '$id_exame'";
$querysql = $mysqli->query($sql);
$infos = $querysql->fetch_assoc();
$idpaciente = $infos['paciente_id'];

$sql_code  = "DELETE FROM pacientes_exames WHERE id = '$id_exame'";
$query_code = $mysqli->query($sql_code) or die($mysqli->error);
    if($query_code)
        header("location: ../editar_paciente.php?id=$idpaciente");  
    else{
      var_dump($sql_code);
      die("erro ao excluir");
    }
?>