<?php
include('../views/conexao.php');
$id_exame = intval($_GET['id']);

$sql_code   = "DELETE FROM pacientes_exames WHERE exame_id = '$id_exame' AND paciente_id = ''";
$query_code = $mysqli->query($sql_code) or die($mysqli->error);
    if($query_code)
    var_dump($sql_code);
        // header("location: ../Pacientes_Lab/listagem_pacientes.php");  
    else{
      var_dump($sql_code);
      die("erro ao excluir");
    }
?>